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
            ->paginate(10)
            ->withQueryString();
        // dd($dc_products);
        return view("dcmanagement.index", ["dc_products" => $dc_products]);
    }
}