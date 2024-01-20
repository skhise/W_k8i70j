<?php

namespace App\Http\Controllers;
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

    public function GetContractProductById(Request $request){  
        $id= $request->CNRT_ID;
        $product = array();
        $product = ContractUnderProduct::where("contractId",$id)
                   ->leftJoin("contracts","contracts.CNRT_ID","contract_under_product.contractId")
                   ->leftJoin("master_service_schedule","master_service_schedule.id","contract_under_product.no_of_service")
                   ->get(["contract_under_product.id as mainPId",'contracts.*',"contract_under_product.*","master_service_schedule.*"]);
                foreach($product as $cp){
                    $startDate = Carbon::createFromFormat("Y-m-d",$cp->CNRT_StartDate);
                    $EndDate = Carbon::createFromFormat("Y-m-d",$cp->CNRT_EndDate);
                    $diff_in_months = $startDate->diffInMonths($EndDate);
                    $schedules =  $cp->scheduleMonth;
                    $toatlScheduleService = $schedules!= 0 ? round($diff_in_months/$schedules) :0;  
                    $cp->startDate =  Carbon::parse($cp->CNRT_StartDate)->format("Y-m-d");
                    $cp->toatlScheduleService = $toatlScheduleService;
                    $cp->serviceQty = $this->getServiceCount($cp->mainPId,$id);
                }  
        return response()->json(["success" => true, "message"=>"","product"=>$product]);
    }
    public function GetContractProduct(Request $request){
        $product = Product::join("master_product_type","master_product_type.id","products.type")
        ->where("Status",1)->get();
        
        return $product;
    }
    public function GetContractProductList(Request $request){
        $id= $request->Contract_ID; 
        $product = ContractUnderProduct::where("contractId",$id)->get();
        return $product;
    }
    function getServiceCount($productId,$contractID){

        $count = 0;
         $count = ContractScheduleModel::where("Accessory_Id",$productId)
                 ->where("Contract_Id",$contractID)
                 ->count();
        return $count;

    }
    public function GetProductType(Request $request){
        $ProductType = ProductType::all();
        return $ProductType;
    }
    public function DeleteProduct(Request $request)
    {
        $validator  =   Validator::make($request->all(),
        [
            'id' =>"required",
        ]
        );
        if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"Product information missing.","validation_error" => $validator->errors()]);
        }
            $update = Product::find($request->id)->update(['Status'=>0]);
            if($update){
                $product = Product::find($request->id);
                $action = "Product marked as deleted, Name:".$product->Product_Name;
                $log = App(\App\Http\Controllers\LogController::class);
                $log->SystemLog($request->loginId,$action);
                return response()->json(["success" => true, "message"=>"Product marked as deleted."]);
            } else {
                return response()->json(["success" => true, "message"=>"Action failed, try again."]);
            }
      
        
    }
    public function UpdateProductAccessory(Request $request){
        $validator  =       Validator::make($request->all(),
        [
            "accessoryName" =>"required",
        ]
        );
       
    if($validator->fails()) {
        return response()->json(["success" => false, "message"=>"all * marked fields required.","validation_error" => $validator->errors()]);
    }
    $check = Product_Accessory::where("PA_ID","!=",$request->id)->where("Product_ID",$request->productId)->where("PA_Name","=",$request->accessoryName)->get();
        if(count($check) == 0){
            $product_acc = Product_Accessory ::where("Product_ID",$request->productId)
            ->where("PA_ID",$request->id)
            ->update([
            'PA_Name'=>$request->accessoryName,
            'PA_Qty'=>$request->accessoryQty,
            'PA_Price'=>$request->accessoryPrice
        ]);
        if($product_acc) {
            return response()->json(["success" => true, "message"=>"Accessory Updated."]);
        } else {
            return response()->json(["success" => false, "message"=>"Action failed, Try agian."]);
        }
        } else {
            return response()->json(["success" => false, "message"=>"Duplicate accessory name for the product"]);
        }
        
    }
    public function AddProductAccessory(Request $request){

        $validator  =       Validator::make($request->all(),
        [
            "accessoryName" =>"required",
        ]
        );
      
    if($validator->fails()) {
        return response()->json(["success" => false, "message"=>"all * marked fields required.","validation_error" => $validator->errors()]);
    }
        $check = Product_Accessory::where("Product_ID",$request->productId)->where("PA_Name","=",$request->accessoryName)->get();
        if(count($check) == 0){
            $product_acc = Product_Accessory :: Create([
                'Product_ID'=>$request->productId,
                'PA_Name'=>$request->accessoryName,
                'PA_Qty'=>$request->accessoryQty,
                'PA_Price'=>$request->accessoryPrice
            ]);
            if($product_acc) {

                return response()->json(["success" => true, "message"=>"Accessory Added."]);
            } else {
                return response()->json(["success" => false, "message"=>"Action failed, Try agian."]);
            }
        } else {
            return response()->json(["success" => false, "message"=>"Duplicate accessory name for the product"]);
        }
       
    }
    public function GetProductAccessory(Request $request){
        $id= $request->id;
        $Product_Accessory = Product_Accessory::where("Product_ID",$id)->get();
        return $Product_Accessory;
    }
    public function GetProductById(Request $request){
        $id = $request->id;
        $product = Product::join("master_product_type","master_product_type.id","products.type")
        ->where("Product_ID",$id)->first();
        return $product; 
    } 
    public function GetProducts(Request $request){
        $products= array();    
         try {
            $products = Product::leftJoin("master_product_type","master_product_type.id","products.type")
            ->where("Status","1")->get();
            foreach($products as $product) {
                $product->edit = "/pages/edit-product?id=".$product->Product_ID;
                $product->view = "/pages/view-product?id=".$product->Product_ID;
            }
            
        } catch (Illuminate\Database\QueryException $ex){
            return $ex->errorInfo;
        }
        return $products;
    }
    public function UpdateProduct(Request $request){

        $validator  =       Validator::make($request->all(),
        [
            "Product_Name" =>"required",
        ]
    );
      
    if($validator->fails()) {
        return response()->json(["success" => false, "message"=>"all * marked fields required.","validation_error" => $validator->errors()]);
    }
        $product = Product::where("Product_ID",$request->Product_ID)->update([
            'Product_Name'=> $request->Product_Name,
            'Product_Description' => $request->Product_Description,
            'Product_Price' => $request->Product_Price,
            'type' => $request->type
        ]);
        if($product){
            return response()->json(["success" => true, "message"=>"Product Updated."]);
        } else {
            return response()->json(["success" => false, "message"=>"Action failed, Try again."]);
        }
    }
    public function UpdateProductImage(Request $request){

        $validator  =  Validator::make($request->all(),
        [
            "product_name" =>"required",
            "productId" =>"required",
        ]
    );
      
    if($validator->fails()) {
        return response()->json(["success" => false, "message"=>"data missing, refresh and try again."]);
    }
        $upload = $this->UploadProductImage($request);
        if($upload!=""){
            try {
                $product = Product::where("Product_ID",$request->productId)->update([
                    'Image_Path'=>$upload,
            ]);
            if($product){
                    return response()->json(['success' => true, 'message'=> 'Product Image Updated.']); 
                } else {
                    return response()->json(['success' => false, 'message'=> 'Action failed, Try again.']);     
                }
            }
            catch(Illuminate\Database\QueryException $ex){
                return response()->json(['success' => false, 'message'=>$ex->errorInfo]);
            }
        } else {
            return response()->json(['success' => false, 'message'=> 'Product Image Update Failed.']); 
        }
    }
    public function UploadProductImage($request) {
        $imagesName = "";
        if($request->has('product_image_url_path')) {
            $image = $request->product_image_url_path;
            $productName = str_replace(' ', '',$request->product_name);
            $productName = str_replace('+', '',$request->product_name);
            $image_path = "/images/ContractProducts/Product_".$productName. '.png';
            $imagesName = "/app/public".$image_path;
            $path = storage_path().$imagesName;
            if(file_exists($path)){
                unlink($path);
            }
            $img = substr($image, strpos($image, ",")+1);
            $data = base64_decode($img);
            $success= file_put_contents($path,$data);
            if($success){
                $imagesName= "/storage".$image_path;    
            } else {
                $imagesName="";
            }
        } else {
            $imagesName= null;    
        }
        return $imagesName;
    }
    public function AddProduct(Request $request){
        
       $validator  =       Validator::make($request->all(),
            [
                "Product_Name" =>"required",
            ]
        );
          
        if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"all * marked fields required.","validation_error" => $validator->errors()]);
        }
        try {
            $isOk=0;
                
                if(isset($request->product_accessorys)){
                    $product_accessory = $request->product_accessorys;
                    foreach($product_accessory as $pa){
                            if($pa['PA_Name']!="" && $pa['PA_Name']!=null){
                                $isOk = 1;
                            } else {
                                $isOk = 0;
                                return response()->json(['success' => false, 'message'=> 'Product accessories name missing.']); 
                                exit;
                            }
                    }



                } else {
                    $isOk = 1;
                }
                if($isOk == 1){
                    $check = Product::where("Product_Name",$request->Product_Name)->get();
                    if(count($check) == 0){
                        $product = Product::create([
                            'Product_Name'=> $request->Product_Name,
                            'Product_Description' => $request->Product_Description,
                            'Product_Price' => $request->Product_Price,
                            'type' => $request->Product_Type,
                        ]);
                        if($product){
                            $isUpload = $this->UploadProductImage($request);
                            if($isUpload!=""){
                                $product->Image_Path=$isUpload;
                                $product->save();
                            }
                            $product_accessory = $request->product_accessorys;
                        if(!is_null($product_accessory)){
                            if(sizeof($product_accessory)>0){
                                $tpa = sizeof($product_accessory);
                                $atpa=0;
                                $fatpa=0;
                                foreach($product_accessory as $pa){
                                    $product_acc = Product_Accessory :: Create([
                                        'Product_ID'=>$product->Product_ID,
                                        'PA_Name'=>$pa['PA_Name'],
                                        'PA_Qty'=>$pa['PA_Qty'],
                                        'PA_Price'=>$pa['PA_Price']
                                    ]);
                                    if($product_acc) {
                                        $atpa++;        
                                    } else {
                                        $fatpa++;
                                    }       
                                }
                                if($atpa == $tpa-1){
                                    return response()->json(['success' => true, 'message'=> 'Product Created.']); 
                                } else {
                                    
                                    return response()->json(['success' => true, 'message'=> 'Product Created, Falied to add '.$fatpa." accessory."]); 
                                }
                            } else {
                                return response()->json(['success' => true, 'message'=> 'Product Created.']); 
                            }
                        }else {
                            return response()->json(['success' => true, 'message'=> 'Product created without accessories.']); 
                        }
                        } else {
                            return response()->json(['success' => false, 'message'=> 'Action failed, Try again.']); 
                        }
                    } else {
                        return response()->json(['success' => false, 'message'=> 'duplicate product details']);
                    }
                    
                } else {
                    return response()->json(['success' => false, 'message'=> 'Action failed, Try again.']); 
                }
                    } catch(Illuminate\Database\QueryException $ex){
                        return response()->json(['success' => false, 'message'=>$ex->errorInfo]);
                    }
        
        
      }
      
      
      
    
}

