<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ServiceQuotation;
use Illuminate\Support\Facades\Request;

class QuotationController extends Controller
{


    public function index(Request $request)
    {
        $service_quots = ServiceQuotation::select(["quotation_type.*", "clients.*", "services.*", "service_quotation.id as dcp_id", "service_quotation.*"])
            ->join("services", "services.id", "service_quotation.service_id")
            ->leftJoin("quotation_type", "quotation_type.id", "service_quotation.quot_type")
            ->leftJoin("clients", "clients.CST_ID", "services.customer_id")
            ->paginate(10)
            ->withQueryString();
        // dd($dc_products);
        return view("quotmanagement.index", ["service_quots" => $service_quots]);
    }
}