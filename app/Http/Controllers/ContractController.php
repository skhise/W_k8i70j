<?php

namespace App\Http\Controllers;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ContractSiteType;
use App\Models\ContractType;
use App\Models\Schedule;
use App\Models\Product_Accessory;
use App\Models\ContractBaseProduct;
use App\Models\ContractBaseAccessory;
use App\Models\ContractScheduleModel;
use App\Models\CustomerSites;
use App\Models\Service;
use App\Models\ContractStatus;
use App\Models\Attachment;
use App\Models\ProductImage;
use App\Models\ContractUnderProduct;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Models\Account_Setting;


class ContractController extends Controller
{

    public function DeleteContractProduct(Request $request){

        $validator  =  Validator::make($request->all(),
        [
            "mainPId" =>"required",
            "CNRT_ID" =>"required",
        ]);
        if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"required details missing.","validation_error" => $validator->errors()]);
        }
        $check = ContractUnderProduct::find($request->mainPId);
        if($check){
            $isDeleted = ContractUnderProduct::where("id",$request->mainPId)
                        ->where("contractId",$request->CNRT_ID)->delete();
            if($isDeleted){
                return response()->json(["success" => true, "message"=>"product deleted"]); 
            }
            return response()->json(["success" => false, "message"=>"product not deleted, try again."]); 
        } 
        return response()->json(["success" => false, "message"=>"product not found, try again."]); 

    }
    
    public function DeleteContract(Request $request)
    {
        $validator  =   Validator::make($request->all(),
        [
            'id' =>"required",
            'loginId'=>"required"
        ]
        );
        if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"Contract information missing.","validation_error" => $validator->errors()]);
        }
        $isService  = $this->CheckIfServiceCall($request->id); 
        if($isService){
            $contract = Contract::find($request->id);
            $isDelete = Contract::find($request->id)->delete();
            if($isDelete){
                $action = "Contract Delete, Contract Number:".$contract->CNRT_Number.", Customer Name:".$contract->CNRT_CustomerName;
                $log = App(\App\Http\Controllers\LogController::class);
                $log->SystemLog($request->loginId,$action);
                return response()->json(["success" => true, "message"=>"Contract Deleted."]);
                return response()->json(["success" => true, "message"=>"Action failed, try again."]);
            } else {
                return response()->json(["success" => true, "message"=>"Action failed, try again."]);
            }
            
        } else {
            $contract = Contract::find($request->id);
            $update = Contract::find($request->id)->update(['CNRT_Status'=>0]);
            if($update){
                $action = "Contract marked as deleted, Contract Number:".$contract->CNRT_Number.", Customer Name:".$contract->CNRT_CustomerName;
                $log = App(\App\Http\Controllers\LogController::class);
                $log->SystemLog($request->loginId,$action);
                return response()->json(["success" => true, "message"=>"Contract marked as deleted."]);
            } else {
                return response()->json(["success" => true, "message"=>"Action failed, try again."]);
            }
        }
    }
    public function CheckIfServiceCall($id){
        $count = Service::where("contract_id",$id)->count();
        if($count){
            return false;
        }
        return true;
    }
    public function DeleteScheduleService(Request $request){

        $validator  =  Validator::make($request->all(),
        [
            "scheduleId" =>"required",
            "CNRT_ID" =>"required",
        ]);
        if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"contract details missing.","validation_error" => $validator->errors()]);
        }
        $check = ContractScheduleModel::find($request->scheduleId);
        if($check){
            $isDeleted = ContractScheduleModel::where("id",$request->scheduleId)
                        ->where("Contract_Id",$request->CNRT_ID)->delete();
            if($isDeleted){
                return response()->json(["success" => true, "message"=>"schedule deleted"]); 
            }
            return response()->json(["success" => false, "message"=>"schedule not deleted, try again."]); 
        } 
        return response()->json(["success" => false, "message"=>"schedule not found, try again."]); 

    }
    public function DeleteAttachment(Request $request){

        $validator  =  Validator::make($request->all(),
        [
            "id" =>"required",
            "Contract_Id" =>"required",
            "Attachment_Path"=>"required",
        ]);
        if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"contract details missing.","validation_error" => $validator->errors()]);
        }
        $file = public_path($request->Attachment_Path);
        
            $deleteRow = Attachment::where("id",$request->id)->where("Contract_Id",$request->Contract_Id)->delete();
            if($deleteRow){
                if(File::exists($file)){
                    $isDeleted = File::delete($file);
                    if(!$isDeleted){
                        return response()->json(["success" => false, "message"=>"attachment not deleted, try again."]); 
                    }
                    return response()->json(["success" => true, "message"=>"attachment deleted."]); 
                } else {
                    return response()->json(["success" => true, "message"=>"attached file not found,entry deleted."]); 
                }
            }
            return response()->json(["success" => false, "message"=>"attachment not deleted, try again."]); 
        




    }
    public function UpdateSubject(Request $request){
        $validator  =  Validator::make($request->all(),
        [
            "contractId" =>"required",
            "subject" =>"required",
        ]);
        if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"contract details missing.","validation_error" => $validator->errors()]);
        }
        $contractId = $request->contractId;
        $subject =$request->subject;
        $update = Contract::where("CNRT_ID",$contractId)->update([
            "AgreementSubject"=>$subject
        ]);
        if($update){
            return response()->json(["success" => true, "message"=>"subject updated."]);
        } else {
            return response()->json(["success" => false, "message"=>"failed to update subject."]);
        }
    }
    public function UpdateSocpeOfWork(Request $request){
        
        $validator  =  Validator::make($request->all(),
        [
            "contractId" =>"required",
            "scopeofwork" =>"required",
        ]);
        if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"contract details missing.","validation_error" => $validator->errors()]);
        }
        $contractId = $request->contractId;
        $scopeofwork = $request->scopeofwork;
        $update = Contract::where("CNRT_ID",$contractId)->update([
            "AgreementScope"=>$scopeofwork
        ]);
        if($update){
            return response()->json(["success" => true, "message"=>"scope of work updated."]);
        } else {
            return response()->json(["success" => false, "message"=>"failed to update scope of work."]);
        }

    }
    public function UpdateBody(Request $request){
        $validator  =  Validator::make($request->all(),
        [
            "contractId" =>"required",
            "subjectbody" =>"required",
        ]);
        if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"contract details missing.","validation_error" => $validator->errors()]);
        }
        $contractId = $request->contractId;
        $subjectbody = $request->subjectbody;
        $update = Contract::where("CNRT_ID",$contractId)->update([
            "AgreementBody"=>$subjectbody
        ]);
        if($update){
            return response()->json(["success" => true, "message"=>"body text updated."]);
        } else {
            return response()->json(["success" => false, "message"=>"failed to update body text."]);
        }
    }
    public function GetAccountSettings(){
        $accountsetting = Account_Setting::where("id",1)->first();
        return $accountsetting;
    }
    public function GetContractNumber(Request $request){

        $cust_code = "";
        $last = Contract::latest()->first();
        $accountsetting = $this->GetAccountSettings();
        $cust_code = $accountsetting->contractno_ins;
        $cust_code = isset($cust_code) ? $cust_code : "";
        if(is_null($last)){
            $cust_code = $cust_code."001";
        } else {
            $lastNumber = $last->CNRT_ID;
            $num = (int)$lastNumber+1;
            $cust_code = $cust_code."00".$num;
            
        }
        return $cust_code;
    }
    public function GetContractSchedules(Request $request) {
        $contractsSchedule= array();    
         try {
            $contractId = $request->CNRT_ID;
            $productId = $request->productId;//master product id
            $accessoryId = $request->accessoryId;
            $contractsSchedule = ContractScheduleModel::
            join("contract_under_product","contract_under_product.id",
            "contract_schedule_service.Accessory_Id")
            ->join("master_service_status","master_service_status.Status_Id","contract_schedule_service.Schedule_Status")
            ->leftJoin("services","services.id","contract_schedule_service.Service_Call_Id")
            ->leftJoin("master_issue_type","master_issue_type.id","contract_schedule_service.issueType")
            ->leftJoin("master_service_type","master_service_type.id","contract_schedule_service.serviceType")
            ->join("contracts","contracts.CNRT_ID","contract_schedule_service.Contract_Id")
            ->when($productId!=0,function($query) use ($productId){
                return $query->where('contract_under_product.id',$productId);
            })
            ->where('contract_schedule_service.Contract_Id',$contractId)
            ->get(["master_service_type.*","master_issue_type.*","contracts.*","contract_schedule_service.id as scheduleId",
            "contract_schedule_service.*","contract_under_product.*","services.*","master_service_status.*"]);
            foreach($contractsSchedule as $cs) {
                $cs->View = "/service/view-service?id=".$cs->Service_Call_Id;   
                if($cs->Service_Call_Id!=0){
                    $this->getManagedServiceStatus($cs);
                }
            }
            
        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $contractsSchedule;
    }
    public function GetPaymentStatusSchedule($accessoryId){
        $status = 0;
        $statusCode = ContractBaseAccessory::
        where("accessoryId",$accessoryId)->first();
        if($statusCode) {
            $status = $statusCode->Is_Paid;
        }
        return $status;
    }
    public function uploadImage($request) {
        $imagesName = "";
        if($request->has('path')) {
            $image = $request->path;
            $Contract_Id =$request->Contract_Id;
            $productId =$request->productId;
            $timestamp = time(); 
            $image_path = "/images/Contract/ProductImage/pi_".$Contract_Id."_".$productId.'_'.$timestamp.'.png';
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
            $imagesName= "";    
        }
        return $imagesName;
    }
    public function Add_Contract_ProductImage(Request $request){
        $validator  =  Validator::make($request->all(),
        [
            "path" =>"required",
            "Contract_Id" =>"required",
            "productId"=>"required"
        ]);
        if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"* marked fields required.","validation_error" => $validator->errors()]);
        }
        $upload = $this->uploadImage($request);
        if($upload!=""){
            $insert = ProductImage::create([
                "Product_Id"=>$request->productId,
                "Contract_Id"=>$request->Contract_Id,
                "Image_Path"=>$upload,
                
                ]);

            if($insert){
                return response()->json(["success" => true, "message"=>"added"]);
            } else {
                return response()->json(["success" => false, "message"=>"failed to add, try again."]);
            }
        } else {
            return response()->json(["success" => false, "message"=>"failed to add, try again."]);
        }
    }
    public function uploadAttach($request) {
        $imagesName = "";
        if($request->has('path')) {
            $image = $request->path;
            $Contract_Id =$request->Contract_Id;
            $timestamp = time(); 
            $attachmentExt = $request->attachmentExt;
            $image_path = "/images/Contract/Attachment/contractaggrement_".$Contract_Id.'_'.$timestamp."_".$attachmentExt;
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
            $imagesName= "";    
        }
        return $imagesName;
    }
    public function GetAttachments(Request $request){
        $attachement = array();
        $attachement = Attachment::where("Contract_Id",$request->Contract_Id)->get();
        return $attachement;

    }
    public function UploadAttachment(Request $request)
       {
        $validator  =       Validator::make($request->all(),
        [
            "path" =>"required",
            "Contract_Id" =>"required",
            "attachmentExt"=>"required",
            "description"=>"required",
        ]);
    if($validator->fails()) {
        return response()->json(["success" => false, "message"=>"* marked fields required.","validation_error" => $validator->errors()]);
    }
    $upload = $this->uploadAttach($request);
    if($upload!=""){
        $insert = Attachment::create([
            "Contract_Id"=>$request->Contract_Id,
            "Attachment_Path"=>$upload,
            "Description"=>$request->description
            ]);

        if($insert){
            return response()->json(["success" => true, "message"=>"added"]);
        } else {
            return response()->json(["success" => false, "message"=>"failed to add, try again."]);
        }
    } else {
        return response()->json(["success" => false, "message"=>"failed to add, try again."]);
    }
    }
    public function getManagedServiceStatus($cs){
        $statusCode = Service::
        join("master_service_status","master_service_status.Status_Id","services.service_status")
        ->where("id",$cs->Service_Call_Id)
        ->first();
        if($statusCode) {
            $cs->MStatusName = $statusCode->Status_Name;
            $cs->MStatusColor = $statusCode->status_color;
        }
        return $cs;
        
    }
    public function AddContractScheduleServiceOne(Request $request){

       $validator  =   Validator::make($request->all(),
        [
            "contractId" => "required",
            "productId"=>"required",
            'Schedule_Date' => "required",
        ]
    );

    if($validator->fails()) {
        return response()->json(["success" => false, "message"=>"all * marked fields required.","validation_error" => $validator->errors()]);
    }

        $iscp = ContractScheduleModel::create([
            'Contract_Id'=>$request->contractId,
            'Accessory_Id'=>$request->productId,
            'Schedule_Date'=>Carbon::parse($request->Schedule_Date)->format("Y-m-d"),
            'Schedule_Qty'=>0,
            'Service_Call_Id'=>0,
            'Schedule_Status'=>8,
            'price'=>$request->Price ? $request->Price : 0 ,
            'issueType'=>$request->issueType,
            'serviceType'=>$request->serviceType,
            'payment'=>$request->payment,
            'isManaged'=>0,
        ]);
        if($iscp){
            return response()->json(['success' => true, 'message'=> 'Contract Schedule Service Added.']); 
        } else {
            return response()->json(['success' => true, 'message'=> 'action failed, try again.']); 
        }

    }
    public function UpdateContractScheduleServiceOne(Request $request){
        $validator  =   Validator::make($request->all(),
        [
            "rowId" => "required",
            'Schedule_Date' => "required",
            'Schedule_Qty' => "required",
            'Price' => "required",
        ]
    );

    if($validator->fails()) {
        return response()->json(["success" => false, "message"=>"all * marked fields required.","validation_error" => $validator->errors()]);
    }
        $today = date('Y-m-d H:i:s');
        $schd =   strtotime($request->Schedule_Date);
        $td = strtotime($today);
        $from_date = Carbon::parse(date('Y-m-d', $schd)); 
        $through_date = Carbon::parse(date('Y-m-d', $td)); 
        $days_difference = $through_date->diffInDays($from_date);
            if($schd<$td){
                $days_difference = $days_difference*-1;
            }
        $iscp = ContractScheduleModel::where("id",$request->rowId)->update([ 
            'Schedule_Date'=>Carbon::parse($request->Schedule_Date)->format("Y-m-d"),
            'Schedule_Qty'=>$request->Schedule_Qty,
            'price'=>$request->Price,
            'serviceType'=>$request->serviceType,
            'issueType'=>$request->issueType,
            'description'=>$request->description,
            'payment'=>$request->payment,
            'DueIn'=>$days_difference,
        ]);
        if($iscp){
            return response()->json(['success' => true, 'message'=> 'Contract Schedule Service Updated.']); 
        } else {
            return response()->json(['success' => true, 'message'=> 'action failed, try again.']); 
        }

    } 
    
    public function AddContractProductAccessory(Request $request){


        $validator  =   Validator::make($request->all(),
        [
            "ProductId"=>"required",
            "accessoryId" => "required",
            'scheduleId' => "required",
            'totalQty' => "required",
            'price' => "required",
            'serviceDay'=>"required",
            'scheduleQty'=>"required",


        ]
    );

    if($validator->fails()) {
        return response()->json(["success" => false, "message"=>"all * marked fields required.","validation_error" => $validator->errors()]);
    }
        $check = ContractBaseAccessory::where("contractId",$request->contractID)
        ->where("productId",$request->ProductId)
        ->where("accessoryId",$request->accessoryId)->first();
        if($check){
            return response()->json(["success" => false, "message"=>"Accessory Already Added."]);
        } else {
            $Contract_Accessory = ContractBaseAccessory::create([
                "contractId"=>$request->contractID,
                "productId"=>$request->ProductId,
                "accessoryId"=>$request->accessoryId,
                "isBase" =>2,
                "serviceSchedule"=>$request->scheduleId,
                "totalQty"=>$request->totalQty,
                "perServiceAllocatedQty"=>$request->scheduleQty,
                "usedQty"=>0,
                "balanceQty"=> $request->totalQty,
                "price"=> $request->price,
                "serviceDay"=> $request->serviceDay,
                "Is_Paid"=> $request->isPaid,
                
            ]);
            if($Contract_Accessory) {
                return response()->json(["success" => true, "message"=>"Accessory Added"]);
            } else {
                return response()->json(["success" => false, "message"=>"action failed, try again."]);
            }
        }
      
    }
    public function UpdateContractProductAccessory(Request $request){


        $validator  =   Validator::make($request->all(),
        [
            "accessoryId" => "required",
            'scheduleId' => "required",
            'totalQty' => "required",
            'price' => "required",
            'serviceDay'=>"required",
            'scheduleQty'=>"required",

        ]
    );

    if($validator->fails()) { 
        return response()->json(["success" => false, "message"=>"all * marked fields required.","validation_error" => $validator->errors()]);
    }
        $Contract_Accessory = ContractBaseAccessory::where("contractId",$request->contractID)
        ->where("id",$request->accessoryId)
        ->update([
            "isBase" =>$request->isBase,
            "serviceSchedule"=>$request->scheduleId,
            "totalQty"=>$request->totalQty,
            "perServiceAllocatedQty"=>$request->scheduleQty,
            "price"=> $request->price,
            "serviceDay"=> $request->serviceDay,
            "Is_Paid"=> $request->isPaid,
        ]);
        if($Contract_Accessory){
            return response()->json(["success" => true, "message"=>"Updated"]);
        } else {
            return response()->json(["success" => false, "message"=>"action failed, try again."]);
        }
    }
    public function AddContractScheduleService(Request $request){
                    $contract_service = $request->schedule;
                    $contractID = $request->contractID;
                    $accessoryId = $request->accessoryId;
                    $isOk=0;
                    if($accessoryId!=0 && $contractID!=0){
                        if(!is_null($contract_service)) {
                            if(sizeof($contract_service)>0) {
                                foreach($contract_service as $cs){
                                    if($cs['Schedule_Date'] == "" || $cs['Schedule_Qty'] == "") {
                                        $isOk = 0;
                                        return response()->json(['success' => false, 'message'=> 'All Fields Required']); 
                                        exit;
                                    } else {
                                       $isOk = 1;
                                    }
                                }
                            } else {
                                return response()->json(['success' => false, 'message'=> 'All Fields Required']); 
                            }
                            if($isOk == 1){
                                $size=0;
                                foreach($contract_service as $cs){
                                    $size++;
                                    $iscp = ContractScheduleModel::create([
                                        'Contract_Id'=>$contractID,
                                        'Accessory_Id'=>$accessoryId,
                                        'Schedule_Date'=>$cs['Schedule_Date'],
                                        'Schedule_Qty'=>$cs['Schedule_Qty'],
                                        'Service_Call_Id'=>0,
                                        'Schedule_Status'=>8,
                                        'price'=>$cs['Price'],
                                        'issueType'=>$cs['issueType']['id'],
                                        'serviceType'=>$cs['serviceType']['id'],
                                        'payment'=>$cs['payment'],
                                        'description'=>$cs['description']
                                    ]);
                                }
                                if($size == sizeof($contract_service)){
                                    ContractBaseAccessory::where("id",$request->id)->where("contractId",$contractID)
                                    ->update(['isSchedule'=>1]);
                                    ContractUnderProduct::where("id",$request->accessoryId)->where("contractId",$contractID)
                                    ->update(['isScheduleAdded'=>1]);
                                    return response()->json(['success' => true, 'message'=> 'Contract Schedule Service Added.']); 
                                } else {
                                    $failed = sizeof($contract_service)-$size; 
                                    return response()->json(['success' => false, 'message'=> $failed.' Contract Schedule Service to add.']); 
                                }
                                
                            } else {
                                return response()->json(['success' => false, 'message'=> 'Something went wrong, Try again.']);
                            }
                        } else {
                            return response()->json(['success' => false, 'message'=> 'Empty Input Values.']); 
                        }
                    } else {
                        return response()->json(['success' => false, 'message'=> 'Empty Input Values.']); 
                    }
    }
    public function GetContracts(Request $request) {
        $contracts= array();    
         try {
            $contracts = Contract::join("master_contract_type","master_contract_type.id","contracts.CNRT_Type")
            ->join("master_site_type","master_site_type.id","contracts.CNRT_SiteType")
            ->join("master_contract_status","master_contract_status.id","contracts.CNRT_Status")
            ->leftJoin("customers","customers.CST_ID","contracts.CNRT_CustomerID")
            ->where("CNRT_Status","!=",0)
            ->orderBy('CNRT_ID', 'DESC')->get();
            foreach($contracts as $contract) {
                $contract->Edit = "/contracts/edit?id=".$contract->CNRT_ID;
                $contract->View = "/contracts/view?CNRT_ID=".$contract->CNRT_ID;
                $contract->CNRT_Status = intval($contract->CNRT_Status);
            }
            
        } catch (Illuminate\Database\QueryException $ex){
            return $ex->errorInfo;
        }
        return $contracts;
    }
    public function GetScheduleList(Request $request) {
        $schedules= array();    
         try {
            $schedules = Schedule::all();
        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $schedules;
    }
    public function GetProductList(Request $request) {
        $products= array();    
         try {
            $products = Product::where("Status",1)->get();
            foreach($products as $product) {
                $product->title = $product->Product_Name;
                $product->value = $product->Product_ID;
                $product->price = $product->Product_Price;
               
            }
            
        } catch (Illuminate\Database\QueryException $ex){
            return $ex->errorInfo;
        }
        return $products;
    }
    public function GetProductAccessory(Request $request){
        $accessory= array();    
         try {
             $Product_ID = $request->Product_ID;
            $accessory = Product_Accessory::where("Product_ID",$Product_ID)->get();
            foreach($accessory as $acc){
                $acc->label = $acc->PA_Name;
                $acc->id = $acc->PA_ID;
            }
            
        } catch (Illuminate\Database\QueryException $ex){
            return $ex->errorInfo;
        }
        return $accessory;
    }
    public function GetContractStatus(Request $request){
        $contractStatus= array();    
         try {
            $contractStatus = ContractStatus::all();
            foreach($contractStatus as $status){
                $status->name = $status->contract_status_name;
                $status->value = $status->id;
            }
        } catch (Illuminate\Database\QueryException $ex){
            return $ex->errorInfo;
        }
        return $contractStatus;
    }
    public function GetContractType(Request $request){
        $contractType= array();    
         try {
            
            $contractType = ContractType::all();
            foreach($contractType as $type){
                $type->name = $type->contract_type_name;
                $type->value = $type->id;
            }
            
        } catch (Illuminate\Database\QueryException $ex){
            return $ex->errorInfo;
        }
        return $contractType;
    }
    public function GetContractSiteType(Request $request){
        $siteType= array();    
         try {
            
            $siteType = ContractSiteType::all();
            foreach($siteType as $site){
                $site->name = $site->site_type_name;
                $site->value = $site->id;
            }
            
        } catch (Illuminate\Database\QueryException $ex){
            return $ex->errorInfo;
        }
        return $siteType;
    }
    public function GetCustomerList(Request $request){
        $Customer= array();    
         try {
            
            $Customer = Customer::where("CST_Status","1")->get();
            foreach($Customer as $c){
                $c->name = $c->CST_Name;
                $c->value = $c->CST_ID;
                $c->SiteList = $this->GetCustomerSiteList($c->CST_ID);
            }
        } catch (Illuminate\Database\QueryException $ex){
            return $ex->errorInfo;
        }
        return $Customer;
    }
    public function GetCustomerSiteList($CST_ID){

        $Sites = array();
        if($CST_ID!=""){
           $Sites = CustomerSites::where("CustomerId",$CST_ID)->get(); 
           foreach($Sites as $site){
                $site->name=$site->SiteNumber."/".$site->SiteName;
           }
        }
        return $Sites;
    }
    public function UpdateContractUnderProduct(Request $request){

        $validator  =   Validator::make($request->all(),
        [
            "contractID" => "required",
            'productId' => "required",
            'productName' => "required",
        ]);
        if($validator->fails()) { 
            return response()->json(["success" => false, "message"=>"all * marked fields required.","validation_error" => $validator->errors()]);
        }
        $contractID = $request->contractID;
        $updatedby = $request->updatedby;
        $update = ContractUnderProduct::where("id",$request->productId)->update([
            'product_name'=>$request->productName,
            'product_type'=>$request->productType,
            'product_price'=>$request->price,
            'product_description'=>$request->description,
            'nrnumber'=>$request->nrnumber,
            'other'=>$request->other,
            'branch'=>$request->branch,
            'updated_by'=>$updatedby,
        ]);
        if($update){
            return response()->json(["success" => true, "message"=>"Product Updated"]);
        } else {
            return response()->json(["success" => false, "message"=>"something went wrong!"]);
        }
        
    

    }
    public function AddContractProduct(Request $request){

                    $contract_product = $request->test;
                    $contractID = $request->contractID;
                    $updatedby = $request->updatedby;
                    $isOk=0;
                    if(!is_null($contract_product)) {
                        if(sizeof($contract_product)>0){
                            foreach($contract_product as $cp){
                                if($cp['productId'] == "" || $cp['productName'] == ""){
                                    return response()->json(['success' => false, 'message'=> 'All Fields Required']); 
                                    exit;
                                } else {
                                    $isOk=1;
                                }

                            }
                        } else { 
                            return response()->json(['success' => false, 'message'=> 'All Fields Required']); 
                        }
                        if($isOk == 1){
                            $size=0;
                            foreach($contract_product as $cp){
                                $size++;
                                $iscp = ContractUnderProduct::create([
                                    'contractId'=>$contractID,
                                    'productId'=>$cp['productId'],
                                    'product_name'=>$cp['productName'],
                                    'product_type'=>$cp['product_type'],
                                    'product_price'=>$cp['price'],
                                    'product_description'=>$cp['description'],
                                    'nrnumber'=>$cp['nrnumber'],
                                    'other'=>$cp['other'],
                                    'branch'=>$cp['branch'],
                                    'no_of_service'=>$cp['noOfService'],
                                    'serviceDay'=>$cp['serviceDay'],
                                    'updated_by'=>$updatedby,
                                    "contractId"=>$contractID,
                                    
                                ]);
                                
                            }
                            if($size == sizeof($contract_product)){
                                return response()->json(['success' => true, 'message'=> 'Product Added']); 
                            } else {
                                $failed = sizeof($contract_product)-$size; 
                                return response()->json(['success' => true, 'message'=> $failed.' Product Failed to add.']); 
                            }
                            
                        } else {
                            return response()->json(['success' => false, 'message'=> 'Something went wrong, Try again.']);
                        }
                    } else {
                        return response()->json(['success' => false, 'message'=> 'Empty Input Values.']); 
                    }
                   
    }
    public function CheckContractProduct($ContractId,$productId){

        $check = ContractBaseProduct::where("CNRT_ID",$ContractId)
        ->where("BaseProduct_ID",$productId)
        ->first();
        if($check->ID>0){
            return 1;
        } else {
            return 0;
        }   

    }
    public function UpdateContract(Request $request){
        
        $validator  =   Validator::make($request->all(),
             [
                 "CNRT_SiteType" => "required",
                 "CNRT_TypeStatus"=>"required",
                 'CNRT_Type' => "required",
                 'CNRT_Date' => "required",
                 'CNRT_CustomerContactPerson' => "required",
                 'CNRT_CustomerContactNumber' => "required",
                 'CNRT_CustomerEmail' => "required",
                 'CNRT_StartDate' => "required",
                 'CNRT_EndDate' => "required",
             ]
         );
           
         if($validator->fails()) {
             return response()->json(["success" => false, "message"=>"all * marked fields required.","validation_error" => $validator->errors()]);
         }
         try { 
             $check = Contract::where("CNRT_Number",$request->CNRT_Number)->where("CNRT_ID","!=",$request->CNRT_ID)->get();
             if(count($check)==0) {
                $contract = Contract::where("CNRT_ID",$request->CNRT_ID)->update([
                    'CNRT_TypeStatus'=>$request->CNRT_TypeStatus,
                    'CNRT_SiteType'=>$request->CNRT_SiteType,
                    'CNRT_Number'=>$request->CNRT_Number,
                    'CNRT_Type'=>$request->CNRT_Type,
                    'CNRT_RefNumber'=>$request->CNRT_RefNumber,
                    'CNRT_Date'=>date('Y-m-d H:i:s', strtotime($request->CNRT_Date)),
                    'CNRT_CustomerContactPerson'=>$request->CNRT_CustomerContactPerson,
                    'CNRT_CustomerContactNumber'=>$request->CNRT_CustomerContactNumber,
                    'CNRT_CustomerEmail'=>$request->CNRT_CustomerEmail,
                    'CNRT_Site'=>$request->CNRT_Site,
                    'CNRT_SiteLocation'=>$request->CNRT_SiteLocation,
                    'CNRT_SiteAddress'=>$request->CNRT_SiteAddress,
                    'CNRT_StartDate'=>date('Y-m-d H:i:s', strtotime($request->CNRT_StartDate)),
                    'CNRT_EndDate'=>date('Y-m-d H:i:s', strtotime($request->CNRT_EndDate)),
                    'CNRT_Charges'=>$request->CNRT_Charges,
                    'CNRT_Charges_Paid'=>$request->CNRT_Charges_Paid,
                    'CNRT_Charges_Pending'=>$request->CNRT_Charges_Pending,
                    'CNRT_TNC'=>$request->CNRT_TNC,
                    'CNRT_OfficeAddress'=>$request->CNRT_OfficeAddress,
                    'CNRT_Note'=>$request->CNRT_Note,
                ]);
                if($contract){
                   $contract = Contract::where("CNRT_ID",$request->CNRT_ID)->first();
                   $action = "Contract updated, Contract Number:".$contract->CNRT_Number.", Customer Name:".$contract->CNRT_CustomerName;
                   $log = App(\App\Http\Controllers\LogController::class);
                   $log->SystemLog($request->loginId,$action);
                   $this->UpdateContractStatus($request->CNRT_EndDate,$request->CNRT_ID);
                    return response()->json(['success' => true, 'message'=> 'Contract Updated.']); 
                } else {
                    return response()->json(['success' => false, 'message'=> 'Action failed, Try again.']); 
                }
             } else {
                return response()->json(['success' => false, 'message'=> 'dublicate contract number.']); 
             }
             
            } catch(Illuminate\Database\QueryException $ex){
                return response()->json(['success' => false, 'message'=>$ex->errorInfo]);
            }
         
         //return response()->json($engineer);
       }
    public function UpdateContractStatus($EndDate,$ContractId){

        try{
            $today = date('Y-m-d H:i:s');
            $account_setting = Account_Setting::where("id",1)->first();
            $renewalAlertDays= $account_setting->renewal_days;
            $from_date = Carbon::parse(date('Y-m-d', strtotime($EndDate))); 
            $through_date = Carbon::parse(date('Y-m-d', strtotime($today))); 
            $days_difference = $through_date->diffInDays($from_date);
            if($from_date<=$through_date){
                Contract::where("CNRT_ID",$ContractId)->update(['CNRT_Status'=>3]);
            } else if($days_difference<=$renewalAlertDays){
                Contract::where("CNRT_ID",$ContractId)->update(['CNRT_Status'=>2]);
            }
        }catch(Exception $e){

        }
        

    }   
    public function AddContract(Request $request){
        
       $validator  =   Validator::make($request->all(),
            [
                "CNRT_SiteType" => "required",
                "CNRT_TypeStatus"=>"required",
                'CNRT_Type' => "required",
                'CNRT_Date' => "required",
                'CNRT_CustomerID' => "required",
                'CNRT_CustomerName' => "required",
                'CNRT_CustomerContactPerson' => "required",
                'CNRT_CustomerContactNumber' => "required",
                'CNRT_CustomerEmail' => "required",
                'CNRT_StartDate' => "required",
                'CNRT_EndDate' => "required",
                
               
            ]
        );
          
        if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"all * marked fields required.","validation_error" => $validator->errors()]);
        }
        try{
            $account = App(\App\Http\Controllers\MasterController::class);
            $setting = $account->Account_Setting($request);
            $check = Contract::where("CNRT_Number",$request->CNRT_Number)->first();
            if(is_null($check)){
                $contract = Contract::create([
                    'CNRT_Number'=>$request->CNRT_Number,
                    'CNRT_TypeStatus'=>$request->CNRT_TypeStatus,
                    'CNRT_SiteType'=>$request->CNRT_SiteType,
                    'CNRT_Type'=>$request->CNRT_Type,
                    'CNRT_RefNumber'=>$request->CNRT_RefNumber,
                    'CNRT_Date'=>date('Y-m-d H:i:s', strtotime($request->CNRT_Date)),
                    'CNRT_CustomerID'=>$request->CNRT_CustomerID,
                    'CNRT_CustomerName'=>$request->CNRT_CustomerName,
                    'CNRT_CustomerContactPerson'=>$request->CNRT_CustomerContactPerson,
                    'CNRT_CustomerContactNumber'=>$request->CNRT_CustomerContactNumber,
                    'CNRT_CustomerEmail'=>$request->CNRT_CustomerEmail,
                    'CNRT_Site'=>$request->CNRT_Site,
                    'CNRT_SiteLocation'=>$request->CNRT_SiteLocation,
                    'CNRT_SiteAddress'=>$request->CNRT_SiteAddress,
                    'CNRT_StartDate'=>date('Y-m-d H:i:s', strtotime($request->CNRT_StartDate)),
                    'CNRT_EndDate'=>date('Y-m-d H:i:s', strtotime($request->CNRT_EndDate)),
                    'CNRT_Charges'=>$request->CNRT_Charges,
                    'CNRT_Charges_Paid'=>$request->CNRT_Charges_Paid,
                    'CNRT_Charges_Pending'=>$request->CNRT_Charges_Pending,
                    'CNRT_TNC'=>$request->CNRT_TNC,
                    'CNRT_OfficeAddress'=>$request->CNRT_OfficeAddress,
                    'CNRT_Note'=>$request->CNRT_Note, 
                    'CNRT_Status'=>1,
                    'AgreementBody'=>$setting[0]['AgreementBody'],
                    'DefaultSignText'=>$setting[0]['DefaultSignText'],
                ]);
                if($contract){
                    $action = "Contract created, Contract Number:".$request->CNRT_Number.", Customer Name:".$request->CNRT_CustomerName;
                    $log = App(\App\Http\Controllers\LogController::class);
                    $log->SystemLog($request->loginId,$action);
                    return response()->json(['success' => true, 'message'=> 'Contract Created.','ID'=>$contract->CNRT_ID]); 
                    
                }else {
                    return response()->json(['success' => false, 'message'=> 'Action failed, Try again.']); 
                }
            } else {
                return response()->json(['success' => false, 'message'=> 'dublicate contract number']); 
            }
            
       }catch(Illuminate\Database\QueryException $ex){
           return response()->json(['success' => false, 'message'=>$ex->errorInfo]);
       }
        
        //return response()->json($engineer);
      }
      
      function GetContractById(Request $request){
            
        try {
            $contractID =  $request->CNRT_ID;
            if($contractID!="" && $contractID!=0){
                 $contract = Contract::join("customers","contracts.CNRT_CustomerID","customers.CST_ID")
                    ->join("master_contract_status","master_contract_status.id","contracts.CNRT_Status")
                    ->join("master_contract_type","master_contract_type.id","contracts.CNRT_Type")
                    ->join("master_site_type","master_site_type.id","contracts.CNRT_SiteType")
                    ->leftJoin("customer_sites","customer_sites.id","contracts.CNRT_Site")
                    ->leftJoin("master_site_area","master_site_area.id","customer_sites.AreaName")
                    ->where("CNRT_ID",$contractID)->first();
                        $contract->contractDate=Carbon::parse($contract->CNRT_Date)->format("d-M-Y");
                        $contract->contractStartDate=Carbon::parse($contract->CNRT_StartDate)->format("d-M-Y");
                        $contract->contractEndDate=Carbon::parse($contract->CNRT_EndDate)->format("d-M-Y");
                        $contract->sites=$this->GetCustomerSiteList($contract->CNRT_CustomerID);
                         $contract->CNRT_Status = intval($contract->CNRT_Status);
                     return response()->json(['success' => true, 'message'=> '','contract'=>$contract]); 
            } else {
                     return response()->json(['success' => false, 'message'=> 'Something went wrong.','contract'=>null]); 
            }
           
        } catch (Illuminate\Database\QueryException $ex){
             return response()->json(['success' => false, 'message'=> "Error:".$ex->errorInfo,'contract'=>null]);
        }
        
    }
    function getPrintContractAccessory(Request $request){
            
        try {
            $contractID =  $request->CNRT_ID;
            $cc = array();
            if($contractID!="" && $contractID!=0){
                $contractproducta = ContractBaseAccessory::join("product_accessory","product_accessory.PA_ID","contract_base_accessory.accessoryId")
                ->join("master_service_schedule","master_service_schedule.id","contract_base_accessory.serviceSchedule")
                ->join("products","products.Product_ID","product_accessory.Product_ID")
                ->where("contract_base_accessory.contractId",$contractID)
                ->where("contract_base_accessory.Is_Paid","1")
                ->get(["products.*","master_service_schedule.*","contract_base_accessory.id as cbaId","contract_base_accessory.*","product_accessory.*"]);
                return response()->json(['success' => true, 'message'=> '','contractproduct'=>$contractproducta]); 
            } else {

                return response()->json(['success' => false, 'message'=> 'Something went wrong.','contractproduct'=>null]); 
            }
        } catch (Illuminate\Database\QueryException $ex){
             return response()->json(['success' => false, 'message'=> "Error:".$ex->errorInfo,'contractproduct'=>null]);
        }
        
    }
    function GetContractProductImagesById(Request $request){
        try {
            $contractproductax = array();
            $contractproductAA = array();
            $contractID =  $request->CNRT_ID;
            $All_Images = array();
            $cc = array();
            if($contractID!="" && $contractID!=0){
                    $contractproduct = ContractBaseProduct::join("products","products.Product_ID","contract_base_product.BaseProduct_ID")
                            ->join("contracts","contracts.CNRT_ID","contract_base_product.CNRT_ID")
                            ->where("contract_base_product.CNRT_ID",$contractID)->get();
                        foreach($contractproduct as $cp) {
                            $contractproductI = ProductImage::where("contract_product_images.Product_Id",$cp->ID)
                            ->where("contract_product_images.Contract_Id",$contractID)
                            ->get();
                            foreach($contractproductI as $cpi){
                                array_push($All_Images,$cpi);
                            }
                            array_push($cc,array("ID"=>$cp->ID,"ProductId"=>$cp->BaseProduct_ID,"BaseProduct_QTY"=>$cp->BaseProduct_QTY,"Product_Name"=>$cp->Product_Name,"images"=>$contractproductI));
                        }
                    return response()->json(['success' => true, 'message'=> '','contractproduct'=>$cc,"ProductImages"=>$All_Images]); 
            } else {
                return response()->json(['success' => false, 'message'=> 'Something went wrong.','contractproduct'=>null,"ProductImages"=>null]); 
            }
           
        } catch (Illuminate\Database\QueryException $ex){
             return response()->json(['success' => false, 'message'=> "Error:".$ex->errorInfo,'contractproduct'=>null,"ProductImages"=>null]);
        }
        
    }
    function GetContractProductAccessoryById(Request $request){
             
        try {
            $contractproductax = array();
            $contractproductAA = array();
            $contractID =  $request->CNRT_ID;
            $cc = array();
            if($contractID!="" && $contractID!=0){
                    $contractproduct = ContractBaseProduct::join("products","products.Product_ID","contract_base_product.BaseProduct_ID")
                            ->join("contracts","contracts.CNRT_ID","contract_base_product.CNRT_ID")
                            ->where("contract_base_product.CNRT_ID",$contractID)->get();
                        foreach($contractproduct as $cp) {
                            $startDate = Carbon::createFromFormat("Y-m-d",$cp->CNRT_StartDate);
                            $EndDate = Carbon::createFromFormat("Y-m-d",$cp->CNRT_EndDate);
                            $diff_in_months = $startDate->diffInMonths($EndDate);
                            $contractproducta = ContractBaseAccessory::join("product_accessory","product_accessory.PA_ID","contract_base_accessory.accessoryId")
                            ->join("master_service_schedule","master_service_schedule.id","contract_base_accessory.serviceSchedule")
                            ->where("contract_base_accessory.productId",$cp->ID)
                            ->where("contract_base_accessory.contractId",$contractID)
                            ->get(["master_service_schedule.*","contract_base_accessory.id as cbaId","contract_base_accessory.*","product_accessory.*"]);

                            foreach($contractproducta as $cpa) {
                                 $schedules =  $cpa->scheduleMonth;
                                 $toatlScheduleService =  round($diff_in_months/$schedules);  
                                 $cpa->startDate =  Carbon::parse($cp->CNRT_StartDate)->format("Y-m-d");
                                 $cpa->toatlScheduleService = $toatlScheduleService;
                                 $cpa->diff_in_months = $diff_in_months;
                                 $cpa->Is_Paid = $cpa->Is_Paid;
                                 $cpa->serviceQty = $this->getServiceCount($cpa->accessoryId,$contractID);
                            }
                            array_push($cc,array("ID"=>$cp->ID,"ProductId"=>$cp->BaseProduct_ID,"BaseProduct_QTY"=>$cp->BaseProduct_QTY,"Product_Name"=>$cp->Product_Name,"accessory"=>$contractproducta));
                            //$dd = array($cp,);
                            //array_push($contractproductax,$cc);
                        }
                    return response()->json(['success' => true, 'message'=> '','contractproduct'=>$cc]); 
            } else {
                return response()->json(['success' => false, 'message'=> 'Something went wrong.','contractproduct'=>null]); 
            }
           
        } catch (Illuminate\Database\QueryException $ex){
             return response()->json(['success' => false, 'message'=> "Error:".$ex->errorInfo,'contractproduct'=>null]);
        }
        
    }
    function getServiceCount($accessoryId,$contractID){

        $count = 0;
        $count = ContractScheduleModel::where("Accessory_Id",$accessoryId)
                ->where("Contract_Id",$contractID)
                ->count();
        return $count;

    }
    function modify_tree($tree) {
        $array_iterator = new RecursiveArrayIterator($tree);
        $recursive_iterator = new RecursiveIteratorIterator($array_iterator, RecursiveIteratorIterator::CHILD_FIRST);
    
        foreach ($recursive_iterator as $key => $value) {
            if (is_array($value) && array_key_exists('children', $value)) {
                $array_with_children = $value;
                $array_with_children_count = $array_with_children['count'];
    
                foreach ($array_with_children['children'] as $children) {
                    $array_with_children_count = $array_with_children_count + $children['count'];
                }
    
                $array_with_children['count'] = $array_with_children_count;
                $current_depth = $recursive_iterator->getDepth();
    
                for ($sub_depth = $current_depth; $sub_depth >= 0; $sub_depth--) {
                    // Get the current level iterator
                    $sub_iterator = $recursive_iterator->getSubIterator($sub_depth);
    
                    // If we are on the level we want to change, use the replacements
                    // ($array_with_children) other wise set the key to the parent
                    // iterators value
                    if ($sub_depth === $current_depth) {
                        $value = $array_with_children;
                    } else {
                        $value = $recursive_iterator->getSubIterator(($sub_depth + 1))->getArrayCopy();
                    }
    
                    $sub_iterator->offsetSet($sub_iterator->key(), $value);
                }
            }
        }
    
        return $recursive_iterator->getArrayCopy();
    }
      
      
    
}

