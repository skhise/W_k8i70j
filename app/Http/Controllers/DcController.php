<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ServiceDcProduct;
use Illuminate\Support\Facades\Request;

class DcController extends Controller
{


    public function index(Request $request)
    {
        $dc_products = ServiceDcProduct::select(["product_serial_numbers.*", "clients.*", "services.*", "master_product_type.*", "service_dc_product.id as dcp_id", "service_dc_product.*"])->leftJoin("products", "products.Product_ID", "service_dc_product.product_id")
            ->leftJoin("master_product_type", "master_product_type.id", "products.Product_Type")
            ->leftJoin("product_serial_numbers", "product_serial_numbers.id", "service_dc_product.serial_no")
            ->leftJoin("dc_type", "dc_type.id", "service_dc_product.type")
            ->leftJoin("services", "services.id", "service_dc_product.type")
            ->leftJoin("clients", "clients.CST_ID", "services.customer_id")
            ->paginate(10)
            ->withQueryString();

        return view("dcmanagement.index", ["dc_products" => $dc_products]);
    }
}