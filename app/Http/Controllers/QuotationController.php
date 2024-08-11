<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\DcType;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Quotation;
use App\Models\QuotationProduct;
use App\Models\QuotationStatus;
use App\Models\QuotationType;
use App\Models\ServiceQuotation;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuotationController extends Controller
{


    public function index(Request $request)
    {

        $service_quots = Quotation::select(["quotation_type.*", "clients.*", "quotation.id as dcp_id", "quotation.*"])
            ->leftJoin("quotation_type", "quotation_type.id", "quotation.quot_type")
            ->leftJoin("clients", "clients.CST_ID", "quotation.customer_id")
            ->when(isset($request->customer_id), function ($query) use ($request) {
                $query->where("quotation.customer_id", $request->customer_id);
            })
            ->when(isset($request->quot_type), function ($query) use ($request) {
                $query->where("quotation.quot_type", $request->quot_type);
            })
            ->when(isset($request->quot_status), function ($query) use ($request) {
                $query->where("quotation.quot_status", $request->quot_status);
            })
            ->filter($request->only('search'))
            ->paginate(10)
            ->withQueryString();
        // dd($dc_products);
        $quotationType = QuotationType::all();
        $quotationStatus = QuotationStatus::all();
        return view(
            "quotmanagement.index",
            [
                "service_quots" => $service_quots,
                'filters' => $request->all('search', 'trashed', 'search_field', 'filter_status'),
                'search_field' => $request->search_field ?? '',
                'filter_status' => $request->filter_status ?? '',
                'quot_status' => $request->quot_status ?? "",
                'quot_type' => $request->quot_type ?? "",
                'search' => $request->search ?? '',
                'clients' => Client::all(),
                'quotationStatus' => $quotationStatus,
                'quotationType' => $quotationType,
                'customer_id' => isset($request->customer_id) ? $request->customer_id : 0
            ]
        );
    }
    public function create(Request $request)
    {
        $product_types = ProductType::all();
        foreach ($product_types as $i => $type) {

            $products = Product::where("Product_Type", $type->id)->get();
            $product_types[$i]['products'] = $products;

        }
        return view("quotmanagement.create", [
            'dctype' => QuotationType::all(),
            'productType' => $product_types,
            'clients' => Client::all(),
        ]);
    }

    public function Print(Quotation $quotation, Request $request)
    {
        $products = QuotationProduct::select("master_product_type.*", "quotation_product.id as sdp", "quotation_product.*", "products.*")
            ->join("products", "products.Product_ID", "quotation_product.product_id")
            ->leftJoin("master_product_type", "master_product_type.id", "products.Product_Type")
            ->where(['quot_id' => $quotation->id])
            ->get();

        $quotation = Quotation::select("clients.*", "quotation.*", "master_quotation_type.*", "quotation.id as dcp_id", "master_quotation_status.*")->join("master_quotation_status", "master_quotation_status.id", "quotation.quot_status")
            ->join("master_quotation_type", "master_quotation_type.id", "quotation.quot_type")
            ->join("clients", "clients.CST_ID", "quotation.customer_id")
            ->where("quotation.id", $quotation->id)
            ->first();

        $date = date('Y-m-d');

        return view('quotmanagement.print', compact('quotation', 'products', 'date'));
    }
    public function view(Quotation $quotation, Request $request)
    {
        $quotation_products = QuotationProduct::select("master_product_type.*", "quotation_product.id as sdp", "quotation_product.*", "products.*")
            ->join("products", "products.Product_ID", "quotation_product.product_id")
            ->leftJoin("master_product_type", "master_product_type.id", "products.Product_Type")
            ->where(['quot_id' => $quotation->id])
            ->get();

        $quotation_details = Quotation::select("clients.*", "quotation.*", "master_quotation_type.*", "quotation.id as dcp_id", "master_quotation_status.*")->join("master_quotation_status", "master_quotation_status.id", "quotation.quot_status")
            ->join("master_quotation_type", "master_quotation_type.id", "quotation.quot_type")
            ->join("clients", "clients.CST_ID", "quotation.customer_id")
            ->where("quotation.id", $quotation->id)
            ->first();
        return view("quotmanagement.view", [
            "quotation" => $quotation_details,
            "products" => $quotation_products,
            'flag' => $request->flag ?? 0
        ]);
    }
    public function delete(Quotation $quotation)
    {
        try {
            $delete = QuotationProduct::where(['quot_id' => $quotation->id])->delete();
            if ($delete) {
                $quotation->delete();
                return back()->with("success", "Deleted");
            }
            return back()->with("error", "Action failed, try again");
        } catch (Exception $exp) {
            return back()->withErrors("Action failed, try again");
        }
    }
    public function DeleteQP(QuotationProduct $quotationProduct)
    {
        try {
            $delete = $quotationProduct->delete();
            if ($delete) {
                return back()->with("success", "Deleted");
            }
            return back()->with("error", "Action failed, try again");
        } catch (Exception $exp) {
            return back()->withErrors("Action failed, try again");
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'issue_date' => 'required',
                'quot_type' => 'required',
                'customer_id' => 'required',
                'product_id.*' => 'required',
                'amount.*' => 'required',
                'description.*' => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "Quotation information missing.", "validation_error" => $validator->errors()]);
        }
        $size = 0;
        $data = $request->data;
        DB::beginTransaction();
        $dc = Quotation::create([
            'customer_id' => $request->customer_id,
            'quot_type' => $request->quot_type,
            'quot_remark' => $request->quot_remark,
            'quot_amount' => array_sum(array_column($data, "amount")),
            'issue_date' => date('Y-m-d', strtotime($request->issue_date)),
            'quot_status' => 2,
        ]);
        if ($dc->id > 0) {
            foreach ($data as $key => $name) {
                $create = QuotationProduct::create([
                    'quot_id' => $dc->id,
                    'product_id' => $data[$key]['product_id'],
                    'amount' => $data[$key]['amount'],
                    'description' => $data[$key]['description'] ?? "",
                ]);
                if ($create) {
                    $size++;
                }
            }
        }
        if ($size == count($data)) {
            DB::commit();
            return response()->json(["status" => true, 'message' => 'Saved successfully']);
        } else {
            DB::rollBack();
            return response()->json(["status" => false, 'message' => 'Something went wrong, try again.']);
        }
    }
    
}