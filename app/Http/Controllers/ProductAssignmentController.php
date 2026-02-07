<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Product;
use App\Models\ProductAssignment;
use App\Models\ProductAssignmentItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class ProductAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $assignments = ProductAssignment::with(['employee', 'items.product'])
            ->has('items')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $employees = Employee::orderBy('EMP_Name')->get(['EMP_ID', 'EMP_Name']);
        $products = Product::leftJoin('master_product_type', 'master_product_type.id', '=', 'products.Product_Type')
            ->orderBy('products.Product_Name')
            ->select('products.Product_ID', 'products.Product_Name', 'products.quantity', 'master_product_type.type_name as product_type_name')
            ->get();

        return view('product_assignments.index', [
            'assignments' => $assignments,
            'employees'   => $employees,
            'products'    => $products,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => ['required', Rule::exists('employees', 'EMP_ID')],
            'items'       => 'required|array',
            'items.*.product_id' => ['nullable', Rule::exists('products', 'Product_ID')],
            'items.*.quantity'   => 'nullable|integer|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        $items = collect($request->items)->filter(fn ($i) => !empty($i['product_id']) && (int)($i['quantity'] ?? 0) > 0);
        if ($items->isEmpty()) {
            return redirect()->route('product-assignments')->with('error', 'Add at least one product with quantity.');
        }

        if (!Schema::hasColumn('products', 'quantity')) {
            return redirect()->route('product-assignments')->with('error', 'Product quantity column not available.');
        }

        foreach ($items as $row) {
            $pid = (int) $row['product_id'];
            $qty = (int) $row['quantity'];
            $avail = (int) Product::where('Product_ID', $pid)->value('quantity');
            if ($avail < $qty) {
                $name = Product::where('Product_ID', $pid)->value('Product_Name');
                return redirect()->route('product-assignments')->with('error', "Insufficient quantity for \"{$name}\". Available: {$avail}.");
            }
        }

        DB::beginTransaction();
        try {
            $assignment = ProductAssignment::create([
                'employee_id' => $request->employee_id,
                'notes'       => $request->notes,
            ]);

            foreach ($items as $row) {
                $pid = (int) $row['product_id'];
                $qty = (int) $row['quantity'];
                ProductAssignmentItem::create([
                    'product_assignment_id' => $assignment->id,
                    'product_id' => $pid,
                    'quantity'   => $qty,
                ]);
                Product::where('Product_ID', $pid)->decrement('quantity', $qty);
            }

            DB::commit();
            return redirect()->route('product-assignments')->with('success', 'Products assigned successfully. Quantities updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('product-assignments')->with('error', 'Failed to save: ' . $e->getMessage());
        }
    }

    public function show(ProductAssignment $product_assignment)
    {
        $product_assignment->load(['employee', 'items.product']);
        return response()->json([
            'assignment' => $product_assignment,
            'employee_name' => $product_assignment->employee->EMP_Name ?? '',
            'items' => $product_assignment->items->map(fn ($i) => [
                'id' => $i->id,
                'product_id' => $i->product_id,
                'product_name' => $i->product->Product_Name ?? '',
                'quantity' => $i->quantity,
            ]),
        ]);
    }

    public function updateItem(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:product_assignment_items,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $item = ProductAssignmentItem::with('product')->findOrFail($request->item_id);
        $newQty = (int) $request->quantity;
        $oldQty = $item->quantity;
        $productId = $item->product_id;

        if (!Schema::hasColumn('products', 'quantity')) {
            return response()->json(['success' => false, 'message' => 'Product quantity not available.'], 400);
        }

        DB::beginTransaction();
        try {
            if ($newQty === 0) {
                $assignmentId = $item->product_assignment_id;
                $item->delete();
                Product::where('Product_ID', $productId)->increment('quantity', $oldQty);
                $assignment = ProductAssignment::find($assignmentId);
                $assignmentDeleted = $assignment && $assignment->items()->count() === 0;
                if ($assignmentDeleted) {
                    $assignment->delete();
                }
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Item removed.',
                    'removed' => true,
                    'assignment_deleted' => $assignmentDeleted,
                    'assignment_id' => $assignmentId,
                    'total_quantity' => $assignmentDeleted ? 0 : $assignment->items()->sum('quantity'),
                ]);
            }

            $diff = $newQty - $oldQty;
            if ($diff > 0) {
                $avail = (int) Product::where('Product_ID', $productId)->value('quantity');
                if ($avail < $diff) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Insufficient quantity. Available: ' . $avail], 422);
                }
                Product::where('Product_ID', $productId)->decrement('quantity', $diff);
            } else {
                Product::where('Product_ID', $productId)->increment('quantity', -$diff);
            }

            $item->update(['quantity' => $newQty]);
            $assignment = ProductAssignment::with('items')->find($item->product_assignment_id);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Updated.',
                'removed' => false,
                'quantity' => $newQty,
                'assignment_id' => $assignment->id,
                'total_quantity' => $assignment->items->sum('quantity'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function removeItem(Request $request)
    {
        $request->validate(['item_id' => 'required|exists:product_assignment_items,id']);
        $item = ProductAssignmentItem::findOrFail($request->item_id);
        $qty = $item->quantity;
        $productId = $item->product_id;
        $assignmentId = $item->product_assignment_id;

        if (Schema::hasColumn('products', 'quantity')) {
            Product::where('Product_ID', $productId)->increment('quantity', $qty);
        }
        $item->delete();

        $assignment = ProductAssignment::find($assignmentId);
        $assignmentDeleted = $assignment && $assignment->items()->count() === 0;
        if ($assignmentDeleted) {
            $assignment->delete();
        }

        $totalQuantity = $assignmentDeleted ? 0 : $assignment->items()->sum('quantity');
        return response()->json([
            'success' => true,
            'message' => 'Item removed.',
            'assignment_deleted' => $assignmentDeleted,
            'assignment_id' => (int) $assignmentId,
            'total_quantity' => $totalQuantity,
        ]);
    }

    public function addItem(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:product_assignments,id',
            'product_id'    => ['required', Rule::exists('products', 'Product_ID')],
            'quantity'      => 'required|integer|min:1',
        ]);

        $assignment = ProductAssignment::findOrFail($request->assignment_id);
        $productId = (int) $request->product_id;
        $qty = (int) $request->quantity;

        $avail = (int) Product::where('Product_ID', $productId)->value('quantity');
        if ($avail < $qty) {
            return response()->json(['success' => false, 'message' => 'Insufficient quantity. Available: ' . $avail], 422);
        }

        $existing = ProductAssignmentItem::where('product_assignment_id', $assignment->id)->where('product_id', $productId)->first();
        if ($existing) {
            $newQty = $existing->quantity + $qty;
            $avail = (int) Product::where('Product_ID', $productId)->value('quantity');
            if ($avail < $qty) {
                return response()->json(['success' => false, 'message' => 'Insufficient quantity. Available: ' . $avail], 422);
            }
            $existing->update(['quantity' => $newQty]);
            Product::where('Product_ID', $productId)->decrement('quantity', $qty);
            $assignment->load('items');
            return response()->json([
                'success' => true,
                'message' => 'Quantity added.',
                'item' => $existing->load('product'),
                'assignment_id' => $assignment->id,
                'total_quantity' => $assignment->items->sum('quantity'),
            ]);
        }

        ProductAssignmentItem::create([
            'product_assignment_id' => $assignment->id,
            'product_id' => $productId,
            'quantity'   => $qty,
        ]);
        Product::where('Product_ID', $productId)->decrement('quantity', $qty);

        $item = ProductAssignmentItem::with('product')->where('product_assignment_id', $assignment->id)->where('product_id', $productId)->first();
        $assignment->load('items');
        return response()->json([
            'success' => true,
            'message' => 'Product added.',
            'item' => $item,
            'assignment_id' => $assignment->id,
            'total_quantity' => $assignment->items->sum('quantity'),
        ]);
    }

    public function productQuantity(Request $request)
    {
        $productId = $request->get('product_id');
        if (!$productId) {
            return response()->json(['quantity' => 0]);
        }
        $qty = 0;
        if (Schema::hasColumn('products', 'quantity')) {
            $qty = (int) Product::where('Product_ID', $productId)->value('quantity');
        }
        return response()->json(['quantity' => $qty]);
    }
}
