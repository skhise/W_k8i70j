<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ServiceDc;
use App\Models\ServiceDcProduct;
use Illuminate\Support\Facades\Request;

class DcController extends Controller
{


    public function index(Request $request)
    {
        $dc_products = ServiceDc::select(["dc_type.*", "clients.*", "services.*", "service_dc.id as dcp_id", "service_dc.*"])
            ->join("services", "services.id", "service_dc.service_id")
            ->leftJoin("dc_type", "dc_type.id", "service_dc.dc_type")
            ->leftJoin("clients", "clients.CST_ID", "services.customer_id")
            ->filter($request->only('search', 'trashed', 'search_field', 'filter_status'))
            ->paginate(10)
            ->withQueryString();
        // dd($dc_products);
        return view(
            "dcmanagement.index",
            [
                'search' => $request->search ?? '',
                'search_field' => $request->search_field ?? '',
                'filter_status' => $request->filter_status ?? '',
                "service_dcs" => $dc_products
            ]
        );
    }

    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['search'] ?? null, function ($query, $search) use ($filters) {

            $search_field = $filters['search_field'] ?? '';
            if (empty($search_field)) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('CNRT_Number', 'like', '%' . $search . '%')
                        ->orWhere('CST_Name', 'like', '%' . $search . '%');
                });
            }
        });
        $query->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        })->when($filters['filter_status'] ?? null, function ($query, $search) {
            $query->where('CNRT_Status', 'like', '%' . $search . '%');
        });
    }
}