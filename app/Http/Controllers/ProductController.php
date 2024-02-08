<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Product_Accessory;
use App\Models\ContractUnderProduct;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\ContractScheduleModel;

class ProductController extends Controller
{
    //
    public $status = [
        "1" => '<div class="badge badge-success badge-shadow">Available</div>',
        "2" => '<div class="badge badge-info badge-shadow">Not Available</div>',
    ];

    public function GetContractProductById(Request $request)
    {
        $id = $request->CNRT_ID;
        $product = array();
        $product = ContractUnderProduct::where("contractId", $id)
            ->leftJoin("contracts", "contracts.CNRT_ID", "contract_under_product.contractId")
            ->leftJoin("master_service_schedule", "master_service_schedule.id", "contract_under_product.no_of_service")
            ->get(["contract_under_product.id as mainPId", 'contracts.*', "contract_under_product.*", "master_service_schedule.*"]);
        foreach ($product as $cp) {
            $startDate = Carbon::createFromFormat("Y-m-d", $cp->CNRT_StartDate);
            $EndDate = Carbon::createFromFormat("Y-m-d", $cp->CNRT_EndDate);
            $diff_in_months = $startDate->diffInMonths($EndDate);
            $schedules = $cp->scheduleMonth;
            $toatlScheduleService = $schedules != 0 ? round($diff_in_months / $schedules) : 0;
            $cp->startDate = Carbon::parse($cp->CNRT_StartDate)->format("Y-m-d");
            $cp->toatlScheduleService = $toatlScheduleService;
            $cp->serviceQty = $this->getServiceCount($cp->mainPId, $id);
        }
        return response()->json(["success" => true, "message" => "", "product" => $product]);
    }
    public function GetContractProduct(Request $request)
    {
        $product = Product::join("master_product_type", "master_product_type.id", "products.type")
            ->where("Status", 1)->get();

        return $product;
    }
    public function GetContractProductList(Request $request)
    {
        $id = $request->Contract_ID;
        $product = ContractUnderProduct::where("contractId", $id)->get();
        return $product;
    }
    function getServiceCount($productId, $contractID)
    {

        $count = 0;
        $count = ContractScheduleModel::where("Accessory_Id", $productId)
            ->where("Contract_Id", $contractID)
            ->count();
        return $count;

    }
    public function GetProductType(Request $request)
    {
        $ProductType = ProductType::all();
        return $ProductType;
    }
    public function DeleteProduct(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "Product information missing.", "validation_error" => $validator->errors()]);
        }
        $update = Product::find($request->id)->update(['Status' => 0]);
        if ($update) {
            $product = Product::find($request->id);
            $action = "Product marked as deleted, Name:" . $product->Product_Name;
            $log = App(\App\Http\Controllers\LogController::class);
            $log->SystemLog($request->loginId, $action);
            return response()->json(["success" => true, "message" => "Product marked as deleted."]);
        } else {
            return response()->json(["success" => true, "message" => "Action failed, try again."]);
        }


    }
    public function UpdateProductAccessory(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "accessoryName" => "required",
            ]
        );

        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "all * marked fields required.", "validation_error" => $validator->errors()]);
        }
        $check = Product_Accessory::where("PA_ID", "!=", $request->id)->where("Product_ID", $request->productId)->where("PA_Name", "=", $request->accessoryName)->get();
        if (count($check) == 0) {
            $product_acc = Product_Accessory::where("Product_ID", $request->productId)
                ->where("PA_ID", $request->id)
                ->update([
                    'PA_Name' => $request->accessoryName,
                    'PA_Qty' => $request->accessoryQty,
                    'PA_Price' => $request->accessoryPrice
                ]);
            if ($product_acc) {
                return response()->json(["success" => true, "message" => "Accessory Updated."]);
            } else {
                return response()->json(["success" => false, "message" => "Action failed, Try agian."]);
            }
        } else {
            return response()->json(["success" => false, "message" => "Duplicate accessory name for the product"]);
        }

    }
    public function AddProductAccessory(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "accessoryName" => "required",
            ]
        );

        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "all * marked fields required.", "validation_error" => $validator->errors()]);
        }
        $check = Product_Accessory::where("Product_ID", $request->productId)->where("PA_Name", "=", $request->accessoryName)->get();
        if (count($check) == 0) {
            $product_acc = Product_Accessory::Create([
                'Product_ID' => $request->productId,
                'PA_Name' => $request->accessoryName,
                'PA_Qty' => $request->accessoryQty,
                'PA_Price' => $request->accessoryPrice
            ]);
            if ($product_acc) {

                return response()->json(["success" => true, "message" => "Accessory Added."]);
            } else {
                return response()->json(["success" => false, "message" => "Action failed, Try agian."]);
            }
        } else {
            return response()->json(["success" => false, "message" => "Duplicate accessory name for the product"]);
        }

    }
    public function GetProductAccessory(Request $request)
    {
        $id = $request->id;
        $Product_Accessory = Product_Accessory::where("Product_ID", $id)->get();
        return $Product_Accessory;
    }
    public function GetProductById(Request $request)
    {
        $id = $request->id;
        $product = Product::join("master_product_type", "master_product_type.id", "products.type")
            ->where("Product_ID", $id)->first();
        return $product;
    }
    public function index(Request $request)
    {
        return view("products.index", [
            'filters' => $request->all('search', 'trashed', 'search_field', 'filter_status'),
            'search_field' => $request->search_field ?? '',
            'filter_status' => $request->filter_status ?? '',
            'search' => $request->search ?? '',
            'products' => Product::leftJoin("master_product_type", "master_product_type.id", "products.Product_Type")
                ->orderBy('products.updated_at', "DESC")
                ->filter($request->only('search', 'trashed', 'search_field', 'filter_status'))
                ->paginate(10)
                ->withQueryString()


        ]);
    }
    public function create(Request $request)
    {
        return view("products.create", [
            "update" => false,
            "product_types" => ProductType::all(),
            "product" => new Product(),
        ]);
    }
    public function view(Request $request, Product $product)
    {
        $product1 = Product::join("master_product_type", "master_product_type.id", "products.Product_Type")
            ->where("Product_ID", $product->Product_ID)->first();
        // dd(url('images/') . "/" . $product->Image_Path);
        return view("products.view", [
            "status" => $this->status,
            "img_url" => url('images/') . "/" . $product->Image_Path,
            "product" => $product1,
        ]);
    }
    public function edit(Request $request, Product $product)
    {
        return view("products.create", [
            "update" => true,
            "product" => $product,
            "product_types" => ProductType::all(),
        ]);
    }
    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "Product_Name" => "required",
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator->messages());
            // return response()->json(["success" => false, "message" => "all * marked fields required.", "validation_error" => $validator->errors()]);
        }
        try {
            $check = Product::where("Product_Name", $request->Product_Name)->get();
            if (count($check) == 0) {
                DB::beginTransaction();
                $product = Product::create([
                    'Product_Name' => $request->Product_Name,
                    'Product_Description' => $request->Product_Description,
                    'Product_Price' => $request->Product_Price,
                    'Product_Type' => $request->Product_Type,
                ]);
                if ($product) {
                    $isUpload = $this->UploadProductImage($request);
                    if ($isUpload != "") {
                        $product->Image_Path = $isUpload;
                        $product->save();
                    }
                    DB::commit();
                    return Redirect("products")->with("success", "Product added!");
                    // $product_accessory = $request->product_accessorys;
                    // if (!is_null($product_accessory)) {
                    //     if (sizeof($product_accessory) > 0) {
                    //         $tpa = sizeof($product_accessory);
                    //         $atpa = 0;
                    //         $fatpa = 0;
                    //         foreach ($product_accessory as $pa) {
                    //             $product_acc = Product_Accessory::Create([
                    //                 'Product_ID' => $product->Product_ID,
                    //                 'PA_Name' => $pa['PA_Name'],
                    //                 'PA_Qty' => $pa['PA_Qty'],
                    //                 'PA_Price' => $pa['PA_Price']
                    //             ]);
                    //             if ($product_acc) {
                    //                 $atpa++;
                    //             } else {
                    //                 $fatpa++;
                    //             }
                    //         }

                    //         if ($atpa == $tpa - 1) {
                    //             return response()->json(['success' => true, 'message' => 'Product Created.']);
                    //         } else {

                    //             return response()->json(['success' => true, 'message' => 'Product Created, Falied to add ' . $fatpa . " accessory."]);
                    //         }
                    //     } else {
                    //         return response()->json(['success' => true, 'message' => 'Product Created.']);
                    //     }
                    // } else {


                    //     //return response()->json(['success' => true, 'message' => 'Product created.']);
                    // }
                } else {
                    return back()
                        ->withInput()
                        ->withErrors("Action failed, Try again.");
                    //  return response()->json(['success' => false, 'message' => 'Action failed, Try again.']);
                }
            } else {
                return back()
                    ->withInput()
                    ->withErrors("Duplicate product details");
                // return response()->json(['success' => false, 'message' => '']);
            }
        } catch (Exception $ex) {
            return back()
                ->withInput()
                ->withErrors($ex->getMessage());
            //return response()->json(['success' => false, 'message' => $ex->errorInfo]);
        }


    }
    public function update(Request $request, Product $product)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "Product_Name" => "required",
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator->messages());
            // return response()->json(["success" => false, "message" => "all * marked fields required.", "validation_error" => $validator->errors()]);
        }
        $product = Product::where("Product_ID", $product->Product_ID)->update([
            'Product_Name' => $request->Product_Name,
            'Product_Description' => $request->Product_Description,
            'Product_Price' => $request->Product_Price,
            'Product_Type' => $request->Product_Type
        ]);
        if ($product) {
            return Redirect("products")->with("success", "Product Updated!");
            // return response()->json(["success" => true, "message" => "Product Updated."]);
        } else {
            return back()
                ->withInput()
                ->withErrors("Action failed, Try again.");
            // return response()->json(["success" => false, "message" => "Action failed, Try again."]);
        }
    }
    public function UpdateProductImage(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "product_name" => "required",
                "productId" => "required",
            ]
        );

        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "data missing, refresh and try again."]);
        }
        $upload = $this->UploadProductImage($request);
        if ($upload != "") {
            try {
                $product = Product::where("Product_ID", $request->productId)->update([
                    'Image_Path' => $upload,
                ]);
                if ($product) {
                    return response()->json(['success' => true, 'message' => 'Product Image Updated.']);
                } else {
                    return response()->json(['success' => false, 'message' => 'Action failed, Try again.']);
                }
            } catch (Illuminate\Database\QueryException $ex) {
                return response()->json(['success' => false, 'message' => $ex->errorInfo]);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Product Image Update Failed.']);
        }
    }
    public function UploadProductImage($request)
    {
        $imagesName = "";
        if ($request->has('Image_Path')) {
            $image = $request->Image_Path;
            $productName = str_replace(' ', '', $request->Product_Name);
            $productName = str_replace('+', '', $request->Product_Name);
            // $image_path = "/images/ContractProducts/Product_" . $productName . '.png';
            // $imagesName = "/app/public" . $image_path;
            // $path = storage_path() . $imagesName;
            // if (file_exists($path)) {
            //     unlink($path);
            // }
            // $img = substr($image, strpos($image, ",") + 1);
            // $data = base64_decode($img);
            $imageName = time() . '.' . $request->Image_Path->extension();

            // Public Folder
            $success = $request->Image_Path->move(public_path('images'), $imageName);
            // $success = file_put_contents($path, $data);
            if ($success) {
                $imagesName = $imageName;
            } else {
                $imagesName = "";
            }
        } else {
            $imagesName = null;
        }
        return $imagesName;
    }





}

