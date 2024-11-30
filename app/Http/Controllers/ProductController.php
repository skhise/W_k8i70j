<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ContractScheduleService;
use App\Models\ContractStatus;
use App\Models\ContractType;
use App\Models\ProductSerialNumber;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
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

class ProductController extends Controller
{
    //
    public $status = [
        "1" => '<div class="badge badge-success badge-shadow">Available</div>',
        "2" => '<div class="badge badge-info badge-shadow">Not Available</div>',
    ];

    public function product_by_id(Request $request)
    {
        $id = $request->product_id;
        $product = null;
        $product = ContractUnderProduct::where("contract_under_product.id", $id)
            ->orWhere("contract_under_product.nrnumber", $id)
            ->leftJoin("contracts", "contracts.CNRT_ID", "contract_under_product.contractId")
            ->leftJoin("master_product_type", "master_product_type.id", "contract_under_product.product_type")
            ->leftJoin("master_service_schedule", "master_service_schedule.id", "contract_under_product.no_of_service")
            ->first(["contract_under_product.nrnumber as product_sn", "master_product_type.*", "contract_under_product.id as mainPId", 'contracts.*', "contract_under_product.*", "master_service_schedule.*"]);

        if (!empty($product)) {
            $startDate = Carbon::createFromFormat("Y-m-d", $product->CNRT_StartDate);
            $EndDate = Carbon::createFromFormat("Y-m-d", $product->CNRT_EndDate);
            $diff_in_months = $startDate->diffInMonths($EndDate);
            $schedules = $product->scheduleMonth;
            $toatlScheduleService = $schedules != 0 ? round($diff_in_months / $schedules) : 0;
            $product->startDate = Carbon::parse($product->CNRT_StartDate)->format("Y-m-d");
            $product->toatlScheduleService = $toatlScheduleService;
            $product->contractEndDate = Carbon::parse($product->CNRT_EndDate)->format("d-m-Y");
            $product->serviceQty = $this->getServiceCount($product->mainPId, $id);
            $product->client_name = Client::where("CST_ID", $product->CNRT_CustomerID)->first()['CST_Name'] ?? "";
            $product->contract_type_name = ContractType::where('id', $product->CNRT_Type)->first()['contract_type_name'] ?? "";
            $product->contract_status_name = ContractStatus::where('id', $product->CNRT_Status)->first()['contract_status_name'] ?? "";
        }

        return response()->json(["success" => true, "message" => "", "product" => $product]);
    }
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
    public function DeleteProductSrNo(Request $request, ProductSerialNumber $productSerialNumber)
    {
        try {
            $productSerialNumber->delete();
            return back()->with("success", "Deleted!");
        } catch (Exception $exp) {
            return back()->withErrors("Action failed, try again.");
        }
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
        $count = ContractScheduleService::where("product_Id", $productId)
            ->where("contractId", $contractID)
            ->count();
        return $count;

    }
    public function GetProductType(Request $request)
    {
        $ProductType = ProductType::all();
        return $ProductType;
    }
    public function DeleteProduct(Request $request,Product $product)
    {
        $update = $product->delete();//::find($product->Product_ID)->update(['Status' => 0]);
        if ($update) {
            $action = "Product marked as deleted, Name:" . $product->Product_Name;
            $log = App(\App\Http\Controllers\LogController::class);
            $log->SystemLog($request->loginId, $action);
            return Redirect("products")->with("success", "Product marked as deleted");
            // return response()->json(["success" => true, "message" => "Product marked as deleted."]);
        } else {
            return Redirect("products")->with("error", "Action failed, try again.");
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
        $product_type = ProductType::all();
        $filter_type  = $request->filter_type ?? "";
        return view("products.index", [
            'filters' => $request->all('search', 'trashed', 'search_field', 'filter_status'),
            'search_field' => $request->search_field ?? '',
            'filter_status' => $request->filter_status ?? '',
            'product_type'=>$product_type,
            'filter_type'=>$filter_type,
            'search' => $request->search ?? '',
            'products' => Product::leftJoin("master_product_type", "master_product_type.id", "products.Product_Type")
                ->orderBy('products.updated_at', "DESC")
                ->filter($request->only('search', 'trashed', 'search_field', 'filter_status'))
                ->when($request->filter_type !="", function ($query) use ($request) {
                    $query->where("products.Product_Type", $request->filter_type);
                })
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
        $serial_numbers = ProductSerialNumber::where("product_id", $product->Product_ID)->get();
        // dd(url('images/') . "/" . $product->Image_Path);
        return view("products.view", [
            "status" => $this->status,
            "img_url" => url('images/') . "/" . $product->Image_Path,
            "product" => $product1,
            "serialnumbers" => $serial_numbers,
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

        $messages = array(
            'nrnumber' => 'Serial number required',
            'nrnumber.*' => 'Serial number must be unique',
            'Product_Type' => 'Product type required',
            'Product_Name' => 'Product name required',
        );
        $validator = Validator::make(
            $request->all(),
            [
                "nrnumber" => "nullable",
                'nrnumber.*' => 'nullable|distinct',
                'Product_Type' => "required",
                'Product_Name' => "required",
            ],
            $messages
        );

        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "all * marked fields required.", "validation_error" => $validator->errors()]);
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
                    $nrnumber = $request->nrnumber;
                    $isOk = 0;
                    $size = 0;
                    foreach ($nrnumber as $index => $sr) {
                        if ($sr != "") {

                            $is_unique = ProductSerialNumber::where(['sr_number' => $sr])->get();
                            if (count($is_unique) > 0) {
                                return response()->json(["success" => false, "index" => $index, "message" => "Serial number must be unique."]);
                            }
                            $iscp = ProductSerialNumber::create([
                                'sr_number' => $sr,
                                'product_id' => $product->Product_ID,
                            ]);
                            if ($iscp) {
                                $size++;
                            }
                        } else {
                            $size++;
                        }
                    }
                    if ($size == sizeof($nrnumber)) {
                        DB::commit();
                        Session::flash("success", "Product Added");
                        return response()->json(['success' => true, 'message' => 'Product Added']);
                    } else {
                        DB::rollBack();
                        return response()->json(['success' => false, 'message' => 'Something went wrong,try again']);
                    }
                }
                return response()->json(['success' => false, 'message' => 'Something went wrong,try again']);


            }
            return response()->json(['success' => false, 'message' => 'Dublicate product name']);

        } catch (Exception $ex) {

            return response()->json(['success' => false, 'message' => $ex->errorInfo]);
        }
    }
    public function AddProductSrNo(Request $request, Product $product)
    {

        $messages = array(
            'nrnumber' => 'Serial number required',
            'nrnumber.*' => 'Serial number must be unique',
        );
        $validator = Validator::make(
            $request->all(),
            [
                'nrnumber.*' => 'required|distinct',
            ],
            $messages
        );

        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "all * marked fields required.", "validation_error" => $validator->errors()]);
            // return response()->json(["success" => false, "message" => "all * marked fields required.", "validation_error" => $validator->errors()]);
        }
        try {
            DB::beginTransaction();
            if (!empty($product)) {
                $nrnumber = $request->nrnumber;
                $isOk = 0;
                $size = 0;
                foreach ($nrnumber as $index => $sr) {
                    if ($sr != "") {

                        $is_unique = ProductSerialNumber::where(['sr_number' => $sr])->get();
                        if (count($is_unique) > 0) {
                            return response()->json(["success" => false, "index" => $index, "message" => "Serial number must be unique."]);
                        }
                        $iscp = ProductSerialNumber::create([
                            'sr_number' => $sr,
                            'product_id' => $product->Product_ID,
                        ]);
                        if ($iscp) {
                            $size++;
                        }
                    } else {
                        $size++;
                    }
                }
                if ($size == sizeof($nrnumber)) {
                    DB::commit();
                    Session::flash("success", "Serial numbers added.");
                    return response()->json(['success' => true, 'message' => 'Serial numbers added.']);
                } else {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Something went wrong,try again']);
                }
            }
            return response()->json(['success' => false, 'message' => 'Something went wrong,try again']);

        } catch (Exception $ex) {

            return response()->json(['success' => false, 'message' => $ex->getMessage()]);
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
    public function upload(Request $request, Product $product)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "Image_Path" => "required",
            ]
        );

        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "data missing, refresh and try again."]);
        }
        $upload = $this->UploadProductImage($request);
        // $disk = Storage::disk('google');
        // $exist = $disk->exists("abc.jpg");
        // echo $exist;
        // die;
        // $path = $request->file('Image_Path')->store('images', 'gcs');

        // Optionally, retrieve the public URL of the uploaded image
        // $url = Storage::disk('google')->url($path);

        // Return any necessary response, such as the URL of the uploaded image
        // $upload = response()->json(['url' => $url]);
        // $upload = $this->uploadImage($request);
        if ($upload != "") {
            try {
                $product = Product::where("Product_ID", $product->Product_ID)->update([
                    'Image_Path' => $upload,
                ]);
                if ($product) {
                    return back()
                        ->withInput()
                        ->withErrors("Product Image Updated");
                    // return response()->json(['success' => true, 'message' => 'Product Image Updated.']);
                } else {
                    return back()
                        ->withInput()
                        ->withErrors("Action failed, Try again.");
                    // return response()->json(['success' => false, 'message' => 'Action failed, Try again.']);
                }
            } catch (Exception $ex) {
                return back()
                    ->withInput()
                    ->withErrors("Action failed, Try again.");
                // return response()->json(['success' => false, 'message' => $ex->getMessage()]);
            }
        } else {
            return back()
                ->withInput()
                ->withErrors("Action failed, Try again.");
            // return response()->json(['success' => false, 'message' => 'Product Image Update Failed.']);
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

