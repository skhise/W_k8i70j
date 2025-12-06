<?php

namespace App\Http\Controllers;

use App\Models\RepairInward;
use App\Models\RepairInwardStatusHistory;
use App\Models\Client;
use App\Models\ProductType;
use App\Models\Service;
use App\Models\RepairStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class RepairInwardController extends Controller
{
    public function index(Request $request)
    {
        $filter_status = $request->status ?? 'all';
        
        $repairInwards = RepairInward::select([
                'repair_inwards.*',
                'clients.CST_Name',
                'clients.CST_ID'
            ])
            ->leftJoin('clients', 'clients.CST_ID', '=', 'repair_inwards.customer_id')
            ->with(['repairStatus', 'spareType'])
            ->filter($request->only('search', 'status'))
            ->orderBy('repair_inwards.id', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Get status counts
        $statusCounts = ['all' => RepairInward::count()];
        $repairStatuses = RepairStatus::where('is_active', true)->get();
        
        foreach ($repairStatuses as $status) {
            $statusCounts[$status->id] = RepairInward::where('status_id', $status->id)->count();
        }

        return view('repairinward.index', [
            'repairInwards' => $repairInwards,
            'search' => $request->search ?? '',
            'filter_status' => $filter_status,
            'statusCounts' => $statusCounts,
            'repairStatuses' => $repairStatuses,
        ]);
    }

    public function create()
    {
        $customers = Client::where('CST_Status', 1)->get();
        $productTypes = ProductType::all();
        $repairStatuses = RepairStatus::where('is_active', true)->get();

        return view('repairinward.create', [
            'customers' => $customers,
            'productTypes' => $productTypes,
            'repairStatuses' => $repairStatuses,
        ]);
    }

    public function getTicketsByCustomer(Request $request)
    {
        try {
            $customerId = $request->customer_id;
            
            if (!$customerId) {
                return response()->json(['tickets' => []]);
            }

            $tickets = Service::select('id', 'service_no', 'customer_id')
                ->where('customer_id', $customerId)
                ->whereNotNull('service_no')
                ->whereNull('deleted_at') // Exclude soft deleted services
                ->get()
                ->map(function ($service) {
                    return [
                        'id' => $service->id,
                        'service_no' => $service->service_no,
                    ];
                });

            return response()->json(['tickets' => $tickets]);
        } catch (Exception $e) {
            return response()->json(['tickets' => [], 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'defective_date' => 'required|date',
            'customer_id' => 'nullable|exists:clients,CST_ID',
            'ticket_no' => 'nullable|string',
            'status_id' => 'required|exists:master_repairstatus,id',
            'spare_type_id' => 'nullable|exists:master_product_type,id',
            'part_model_name' => 'nullable|string',
            'alternate_sn' => 'nullable|string',
            'spare_description' => 'nullable|string',
            'product_remark' => 'nullable|string',
            'current_product_location' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator)->with('error', 'Please fix the validation errors below.');
        }

        try {
            DB::beginTransaction();

            // Generate defective number
            $defectiveNo = $this->generateDefectiveNumber();

            $repairInward = RepairInward::create([
                'defective_no' => $defectiveNo,
                'defective_date' => $request->defective_date,
                'customer_id' => $request->customer_id,
                'ticket_no' => $request->ticket_no,
                'status_id' => $request->status_id,
                'spare_type_id' => $request->spare_type_id ?? null,
                'part_model_name' => $request->part_model_name ?? null,
                'alternate_sn' => $request->alternate_sn ?? null,
                'spare_description' => $request->spare_description ?? null,
                'product_remark' => $request->product_remark ?? null,
                'current_product_location' => $request->current_product_location ?? null,
                'remark' => $request->remark,
                'created_by' => Auth::id(),
            ]);

            // Create initial status history
            RepairInwardStatusHistory::create([
                'repair_inward_id' => $repairInward->id,
                'old_status_id' => null,
                'new_status_id' => $request->status_id,
                'changed_by' => Auth::id(),
                'remarks' => 'Initial status',
            ]);

            DB::commit();
            return redirect()->route('repairinwards.index')->with('success', 'Repair Inward created successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Repair Inward Creation Error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create repair inward: ' . $e->getMessage());
        }
    }

    public function show(RepairInward $repairinward)
    {
        $repairinward->load(['customer', 'spareType', 'service', 'repairStatus', 'statusHistory.oldStatus', 'statusHistory.newStatus', 'statusHistory.changedBy']);
        $repairStatuses = RepairStatus::where('is_active', true)->get();
        return view('repairinward.view', compact('repairinward', 'repairStatuses'));
    }

    public function edit(RepairInward $repairinward)
    {
        $customers = Client::where('CST_Status', 1)->get();
        $productTypes = ProductType::all();

        return view('repairinward.edit', [
            'repairInward' => $repairinward,
            'customers' => $customers,
            'productTypes' => $productTypes,
        ]);
    }

    public function update(Request $request, RepairInward $repairinward)
    {
        $validator = Validator::make($request->all(), [
            'defective_date' => 'required|date',
            'customer_id' => 'nullable|exists:clients,CST_ID',
            'ticket_no' => 'nullable|string',
            'spare_type_id' => 'nullable|exists:master_product_type,id',
            'part_model_name' => 'nullable|string',
            'alternate_sn' => 'nullable|string',
            'spare_description' => 'nullable|string',
            'product_remark' => 'nullable|string',
            'current_product_location' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator)->with('error', 'Please fix the validation errors below.');
        }

        try {
            DB::beginTransaction();

            $repairinward->update([
                'defective_date' => $request->defective_date,
                'customer_id' => $request->customer_id,
                'ticket_no' => $request->ticket_no,
                'spare_type_id' => $request->spare_type_id ?? null,
                'part_model_name' => $request->part_model_name ?? null,
                'alternate_sn' => $request->alternate_sn ?? null,
                'spare_description' => $request->spare_description ?? null,
                'product_remark' => $request->product_remark ?? null,
                'current_product_location' => $request->current_product_location ?? null,
                'remark' => $request->remark,
            ]);

            DB::commit();
            return redirect()->route('repairinwards.index')->with('success', 'Repair Inward updated successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Repair Inward Update Error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update repair inward: ' . $e->getMessage());
        }
    }

    public function destroy(RepairInward $repairinward)
    {
        try {
            $repairinward->delete();
            return redirect()->route('repairinwards.index')->with('success', 'Repair Inward deleted successfully!');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete repair inward: ' . $e->getMessage()]);
        }
    }

    public function updateStatus(Request $request, RepairInward $repairinward)
    {
        $validator = Validator::make($request->all(), [
            'status_id' => 'required|exists:master_repairstatus,id',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Status is required']);
        }

        try {
            DB::beginTransaction();

            $oldStatusId = $repairinward->status_id;
            
            $repairinward->update(['status_id' => $request->status_id]);

            // Create status history
            RepairInwardStatusHistory::create([
                'repair_inward_id' => $repairinward->id,
                'old_status_id' => $oldStatusId,
                'new_status_id' => $request->status_id,
                'changed_by' => Auth::id(),
                'remarks' => $request->remarks ?? 'Status updated',
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Status updated successfully']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to update status: ' . $e->getMessage()]);
        }
    }

    private function generateDefectiveNumber()
    {
        $lastDefective = RepairInward::withTrashed()->orderBy('id', 'desc')->first();
        $number = 1;
        
        if ($lastDefective) {
            // Extract number from DEF1, DEF2, etc.
            preg_match('/DEF(\d+)/', $lastDefective->defective_no, $matches);
            if (!empty($matches[1])) {
                $number = (int)$matches[1] + 1;
            }
        }
        
        return 'DEF' . $number;
    }
}
