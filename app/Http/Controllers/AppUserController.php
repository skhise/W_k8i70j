<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\LocationHistory;
use App\Models\ProductSerialNumber;
use App\Models\ProductType;
use App\Models\ServiceDc;
use App\Models\ServiceDcProduct;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\DateTime;
use App\Models\User;
use App\Models\Service;
use App\Models\ServiceAccessory;
use App\Models\ServiceHistory;
use App\Models\ServiceStatus;
use App\Models\ActionReason;
use App\Models\Contract;
use App\Models\ContractBaseProduct;
use App\Models\ServiceFieldReport;
use App\Models\StoreProduct;
use App\Models\StoreProductCategory;
use App\Models\Product;
use App\Models\Product_Accessory;
use App\Models\LoginSessionHistory;
use App\Models\NewInquiry;
use App\Models\ServiceRequest;
use App\Models\Account_Setting;
use App\Models\ContractBaseAccessory;
use App\Services\PushNotificationService;
use Carbon\Carbon;
use Illuminate\Support\Str;


class AppUserController extends Controller
{


    private $status_code = 200;

    public function __construct()
    {


    }
    public function updateToken(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'UserId' => 'required|integer|exists:users,id',
                'token' => 'required|string|min:100'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ]);
            }

            $userId = $request->UserId;
            $fcmToken = $request->token;

            // Update FCM token in database
            $user = User::where('id', $userId)->first();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ]);
            }

            $user->update(['fcm_token' => $fcmToken]);

            \Log::info("FCM token updated for user {$userId}: " . substr($fcmToken, 0, 20) . "...");

            return response()->json([
                'success' => true,
                'message' => 'FCM token updated successfully',
                'user_id' => $userId,
                'token_updated' => true
            ]);

        } catch (\Exception $e) {
            \Log::error('Error updating FCM token: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update FCM token: ' . $e->getMessage()
            ]);
        }
    }
    public function markOnlineOffline(Request $request)
    {
        try {
            
            User::where("id", $request->User_ID)->update(['isOnline' => 1]);
            if(isset($request->last_long) && $request->last_long !="undefined" && $request->last_long !=null){
                LocationHistory::create([
                    'User_ID' => $request->User_ID,
                    'last_long' => $request->last_long,
                    'last_lang' => $request->last_lang,
                    'full_address' => "",
                    'area_code' => "",
                ]);
            }
         
            return "updated";
        } catch (Exception $e) {
            report($e);
            return "not updated" . $e->getMessage();
        }
    }

    public function GetAccountSettings(Request $request)
    {
        $account = Account_Setting::all();
        return response()->json(["success" => true, "message" => "", "account" => $account]);
    }
    public function SaveServiceRequest(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => "required",
                'email' => "required",
                'phone' => "required",
                'message' => "required",
                'service_type' => "required",
                'issue_type' => "required",
            ]
        );

        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "all * marked fields required.", "validation_error" => $request->all()]);
        }

        $result = ServiceRequest::create([
            'Name' => $request->name,
            'Email' => $request->email,
            'Phone' => $request->phone,
            'VisitTime' => $request->visitTime,
            'VisitDate' => $request->visitDate,
            'ServiceType' => $request->service_type,
            'IssueType' => $request->issue_type,
            'Address' => $request->address,
            'Message' => $request->message,
            'Customer_Id' => $request->Customer_Id
        ]);
        if ($result->id > 0) {
            return response()->json(["success" => true, "message" => "Thank you, Your service request has been submited."]);
        } else {
            return response()->json(["success" => false, "message" => "Action failed, Try again."]);
        }
    }
    public function SaveNewInquiry(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => "required",
                'email' => "required",
                'phone' => "required",
                'message' => "required",
            ]
        );

        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "all * marked fields required.", "validation_error" => $request->all()]);
        }

        $result = NewInquiry::create([
            'Name' => $request->name,
            'Email' => $request->email,
            'Phone' => $request->phone,
            'VisitTime' => $request->visitTime,
            'VisitDate' => $request->visitDate,
            'Address' => $request->address,
            'Message' => $request->message,
            'Customer_Id' => $request->Customer_Id
        ]);
        if ($result->id > 0) {
            return response()->json(["success" => true, "message" => "Thank you, Your Inquiry has been submited."]);
        } else {
            return response()->json(["success" => false, "message" => "Action failed, Try again."]);
        }
    }

    public function UpdatePassword(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "id" => "required",
                "password" => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => 'user or password details missing.', "user" => $request->all()]);
        }
        // check if entered email exists in db
        $email_status = User::where("id", $request->id)->first();
        // if email exists then we will check password for the same email
        if ($email_status) {
            $password = Hash::make($request->password);
            $update = User::where("id", $request->id)->update([
                'password' => $password
            ]);
            // if password is correct
            if ($update) {
                return response()->json(["success" => true, "message" => 'Password Changed.']);
            } else {
                return response()->json(["success" => false, "message" => 'Invalid Password']);
            }
        } else {
            return response()->json(["success" => false, "message" => 'User not found.']);

        }



    }
    public function UpdateProfile(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "id" => "required",
                "role" => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => 'user details missing.', "user" => $request->all()]);
        }

        $isok = User::where("id", $request->id)->where("role", $request->role)->first();
        // if email exists then we will check password for the same email
        if ($isok) {

            // if password is correct
            if ($isok->role == 2) {
                $update = Client::where("CST_ID", $request->id)->update([
                    'CST_OfficeAddress' => $request->address
                ]);
                if ($update) {
                    return response()->json(["success" => true, "message" => 'Changes Saved.']);
                } else {
                    return response()->json(["success" => false, "message" => 'Invalid Failed, Try Again.']);
                }
            } else if ($isok->role == 3) {
                $update = Employee::where("EMP_ID", $request->id)->update([
                    'EMP_Address' => $request->address
                ]);
                if ($update) {
                    return response()->json(["success" => true, "message" => 'Changes Saved.']);
                } else {
                    return response()->json(["success" => false, "message" => 'Invalid Failed, Try Again.']);
                }
            } else {
                return response()->json(["success" => false, "message" => 'User not found.']);
            }

        } else {
            return response()->json(["success" => false, "message" => 'User not found.']);

        }
    }
    public function AddServiceCallAccessoryApp(Request $request){

        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'product_id' => 'required',
                    'amount' => 'required',
                    'note' => 'required',
                    'service_id' => 'required',
                ]
            );
            if ($validator->fails()) {
                return response()->json(["success" => false, "message" => "service information missing", "validation_error" => $validator->errors()]);
            }

            DB::beginTransaction();
            $dc = ServiceDc::where('service_id',$request->service_id)->first();
            if(empty($dc)){
                $dc = ServiceDc::create([
                    'service_id' => $request->service_id,
                    'dc_type' => 1,
                    'dc_remark' => '',
                    'dc_amount' => $request->amount,
                    'issue_date' => NOW(),
                    'dc_status' => 1,
                ]);
            } else {
                $dc->dc_amount = $dc->dc_amount + $request->amount;
                $dc->save();
            }
            
            if ($dc->id > 0) {
                $create = ServiceDcProduct::create([
                    'dc_id' => $dc->id,
                    'product_id' => $request->product_id,
                    'serial_no' => $request->serial_no ?? "",
                    'amount' => $request->amount,
                    'description' => $request->description,
                ]);
                if ($create) {
                    DB::commit();
                    return response()->json(["status" => true, 'message' => 'Saved successfully']);
                } else {
                    DB::rollBack();
                    return response()->json(["status" => false, 'message' => 'Something went wrong, try again.']);
                }
            } else {
                return response()->json(["status" => false, 'message' => 'Something went wrong, try again.']);
            }
        }catch(Exception $exp){
            return response()->json(["status" => false, 'message' => 'Something went wrong, try again.']);
        }
        
    }
    public function AddServiceCallAccessoryAppOld(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'service_id' => "required",
            ]
        );

        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "all fields required.", "validation_error" => $request->all()]);
        }
        try {
            $serviceAcc = ServiceAccessory::create([
                'service_id' => $request->service_id,
                'contract_id' => $request->contract_id,
                'product_id' => $request->product_id,
                'accessory_id' => $request->accessory_id,
                'given_qty' => $request->given_qty,
                'price' => $request->price,
                'Is_Paid' => $request->Is_Paid,
                'isContracted' => $request->type,
            ]);
            if ($serviceAcc) {
                return response()->json(["success" => true, "message" => "accessory added."]);
            } else {
                return response()->json(["success" => false, "message" => "action failed, try again."]);
            }
        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(["success" => false, "message" => "action failed, try again."]);
        }

    }
    public function GetAllProductAccessoryApp(Request $request)
    {
        $accessory = array();
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'Product_ID' => "required",
                ]
            );

            if ($validator->fails()) {
                return response()->json(["success" => false, "message" => "Product information missing.", "validation_error" => $validator->errors()]);
            }
            $Product_ID = $request->Product_ID;
            $accessory = Product_Accessory::where("Product_ID", $Product_ID)->get();
            foreach ($accessory as $acc) {
                $acc->title = $acc->PA_Name;
                $acc->id = $acc->PA_ID;
            }
            return response()->json(["success" => true, "message" => "Product information missing.", "accessory" => $accessory]);
        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(["success" => false, "message" => "Product information missing.", "accessory" => $accessory]);
        }

    }
    public function GetContractProductAccessoryApp(Request $request)
    {
        $accessory = array();
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'Product_ID' => "required",
                ]
            );

            if ($validator->fails()) {
                return response()->json(["success" => false, "message" => "Product information missing."]);
            }

            $Product_ID = $request->Product_ID;
            $accessory =ProductSerialNumber::join("products","products.Product_ID", "product_serial_numbers.product_id")
                ->where("product_serial_numbers.product_id", $Product_ID)->get();
            $accessory->title = "Select Serial No.";
            $accessory->value = 0;
            foreach ($accessory as $acc) {
                $acc->title = $acc->sr_number;

            }
            return response()->json(["success" => true, "message" => "", "accessory" => $accessory]);
        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(["success" => true, "message" => "Product information missing.", "accessory" => []]);
        }

    }
    public function GetContractProductListApp(Request $request)
    {
        $products = array();
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'Contract_ID' => "required",
                ]
            );

            if ($validator->fails()) {
                return response()->json(["success" => false, "message" => "contract details missing.", "validation_error" => $validator->errors()]);
            }
            $Contract_ID = $request->Contract_ID;
            $products = ContractBaseProduct::join("products", "products.Product_ID", "contract_base_product.BaseProduct_ID")
                ->where("CNRT_ID", $Contract_ID)->get();
            foreach ($products as $product) {
                $product->title = $product->Product_Name;
                $product->id = $product->ID;
                $product->Product_ID = $product->BaseProduct_ID;
                $product->contractId = $Contract_ID;
            }
            return response()->json(["success" => true, "message" => "", "product" => $products]);
        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(["success" => false, "message" => "contract details missing.", "product" => $products]);
        }

    }
    public function GetAllProductListApp(Request $request)
    {
        $productAll = array();
        try {
            $products = Product::where("Status", 1)->get();
            foreach ($products as $product) {
                $product->title = $product->Product_Name;
                $product->id = $product->Product_ID;
                $product->price = $product->Product_Price;
                array_push($productAll,$product);
            }
            return response()->json(["success" => true, "message" => "", "product" => $productAll]);
        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(["success" => false, "message" => $ex->getMessage(), "product" => $productAll]);
        }

    }
    public function GetAllProductListByTypeApp(Request $request)
    {
        $productAll = array();
        try {
            $products = Product::where("Status", 1)->where("Product_Type",$request->type_id)->get();
            foreach ($products as $product) {
                $product->title = $product->Product_Name;
                $product->id = $product->Product_ID;
                $product->price = $product->Product_Price;
                array_push($productAll,$product);
            }
            return response()->json(["success" => true, "message" => "", "product" => $productAll]);
        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(["success" => false, "message" => $ex->getMessage(), "product" => $productAll]);
        }

    }
    public function GetProductType(Request $request)
    {
        
        $ProductType = array();
        try {
            $ProductType = ProductType::all();
            foreach ($ProductType as $type) {
                $type->title = $type->type_name;
            }
            return response()->json(["success" => true, "message" => "", "ProductType" => $ProductType]);
        } catch (Exception $ex) {
            return response()->json(["success" => false, "message" => $ex->getMessage(), "ProductType" => $ProductType]);
        }
    }
    public function getCategoryListApp(Request $request)
    {
        $categorys = array();
        try {
            $categorys = StoreProductCategory::all();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        return $categorys;
    }

    public function GetStoreProductsBestPlanApp(Request $request)
    {
        $storeproducts = array();
        try {
            $storeproducts = StoreProduct::where("product_category", 3)->get();
            return response()->json(["success" => true, "storeproducts" => $storeproducts]);
        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(["success" => false, "storeproducts" => []]);
        }
    }
    public function GetStoreProductsBestOfferApp(Request $request)
    {
        $storeproducts = array();
        try {
            $storeproducts = StoreProduct::where("product_is_active", 1)->where("is_offer_active", 1)->get();
            return response()->json(["success" => true, "storeproducts" => $storeproducts]);
        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(["success" => false, "storeproducts" => []]);
        }
    }
    public function GetStoreProductsApp(Request $request)
    {
        $storeproducts = array();
        try {
            $category = $request->category;
            $storeproducts = StoreProduct::where("product_is_active", 1)->when($category != 0, function ($query) use ($category) {
                return $query->where('product_category', $category);
            })->get();
            return response()->json(["success" => true, "storeproducts" => $storeproducts]);
        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(["success" => false, "storeproducts" => []]);
        }
    }

    public function GetServiceFieldReportApp(Request $request)
    {

        $report = array();
        try {
            $id = $request->id;
            $report = Service::leftJoin("service_fieldreport", "service_fieldreport.ServiceId", "services.id")
                ->join("clients", "clients.CST_ID", "services.customer_id")
                ->leftJoin("users", "users.id", "services.assigned_to")
                ->leftJoin("contracts", "contracts.CNRT_ID", "services.contract_id")
                ->leftJoin("customer_sites", "customer_sites.id", "contracts.CNRT_Site")
                ->leftJoin("master_site_area", "master_site_area.id", "customer_sites.AreaName")
                ->where("services.id", $id)->first();
            $report->serviceDate = date('d-m-Y', strtotime($report->service_date));
            $report->acceptedDate = $report->accepted_datetime == null ? null : date('d-m-Y', strtotime($report->accepted_datetime));
            $report->QuotDate = $report->QuotationDate == null ? null : date('d-m-Y', strtotime($report->QuotationDate));
            $report->dateAtt = $report->DOA == null ? null : date('d-m-Y', strtotime($report->DOA));
            $report->startTime = $report->TOA == null ? null : date('H:i', strtotime($report->TOA));
            $report->endTime = $report->ETOA == null ? null : date('H:i', strtotime($report->ETOA));
            $report->productName = $report->contract_id != 0 ? $this->getProductName($report->contract_id) : '';
        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(["success" => false, "report" => []]);
        }
        return response()->json(["success" => true, "report" => $report]);
    }
    public function AddFieldReportApp(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "ServiceId" => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "Service information missing."]);
        }
        $check = ServiceFieldReport::where('ServiceId', $request->ServiceId)->first();
        if ($check) {
            $doa = null;
            $doatmp = $request->DOA;
            // if($doatmp!=""){
            //     $doa = date('Y-m-d', strtotime($request->DOA));
            // }
            $QuotationDate = null;
            $QuotationDatetmp = $request->QuotationDate;
            // if($QuotationDatetmp!=""){
            //     $QuotationDate = date('Y-m-d', strtotime($request->QuotationDate));
            // }
            $report = ServiceFieldReport::where('ServiceId', $request->ServiceId)->update([
                'QuotationNo' => $request->QuotationNo,
                'QuotationDate' => $QuotationDatetmp,
                'FWTDS' => $request->FWTDS,
                'PWTDS' => $request->PWTDS,
                'FWPH' => $request->FWPH,
                'PWPH' => $request->PWPH,
                'FWHardness' => $request->FWHardness,
                'PWHardness' => $request->PWHardness,
                'FeedPumpPr' => $request->FeedPumpPr,
                'HpPumpPr' => $request->HpPumpPr,
                'FilterOutletPr' => $request->FilterOutletPr,
                'FeedFlow' => $request->FeedFlow,
                'FilterInletPr' => $request->FilterInletPr,
                'RejectFlow' => $request->RejectFlow,
                'SystemPr' => $request->SystemPr,
                'ProductFlow' => $request->ProductFlow,
                'RejectPr' => $request->RejectPr,
                'DOA' => $doatmp,
                'TOA' => $request->STOA,
                'ETOA' => $request->ETOA,
                'ObservationNote' => $request->ObservationNote,
                'ServiceType' => $request->ServiceType,
                'PaymentMode' => $request->PaymentMode,
                'ServiceCharges' => $request->ServiceCharges,
                'Part_Fitting' => $request->Part_Fitting,
                'Vat' => $request->Vat,
                'TotalAmount' => $request->TotalAmount,
                'PaymentStatus' => $request->PaymentStatus,
                'EquipmentLeft' => $request->EquipmentLeft,
                'Remarks' => $request->Remarks,
                'EquipmenttoOrder' => $request->EquipmenttoOrder,
                'saltVisit' => $request->saltVisit,
                'saltVisitDate' => $request->saltVisitDate != "" ? date('Y-m-d H:i:s', strtotime($request->saltVisitDate)) : null,
                'filterVisit' => $request->filterVisit,
                'filterVisitDate' => $request->filterVisitDate != "" ? date('Y-m-d H:i:s', strtotime($request->filterVisitDate)) : null
            ]);
            if ($report) {
                return response()->json(["success" => true, "message" => "Field Report Saved"]);
            } else {
                return response()->json(["success" => false, "message" => "action failed, try again"]);
            }
        } else {
            $doa = null;
            $doatmp = $request->DOA;
            if ($doatmp != "") {
                $doa = date('Y-m-d H:i:s', strtotime($request->DOA));
            }
            $QuotationDate = null;
            $QuotationDatetmp = $request->QuotationDate;
            if ($QuotationDatetmp != "") {
                $QuotationDate = date('Y-m-d H:i:s', strtotime($request->QuotationDate));
            }
            $report = ServiceFieldReport::create([
                'ServiceId' => $request->ServiceId,
                'QuotationNo' => $request->QuotationNo,
                'QuotationDate' => $QuotationDate,
                'FWTDS' => $request->FWTDS,
                'PWTDS' => $request->PWTDS,
                'FWPH' => $request->FWPH,
                'PWPH' => $request->PWPH,
                'FWHardness' => $request->FWHardness,
                'PWHardness' => $request->PWHardness,
                'FeedPumpPr' => $request->FeedPumpPr,
                'HpPumpPr' => $request->HpPumpPr,
                'FilterOutletPr' => $request->FilterOutletPr,
                'FeedFlow' => $request->FeedFlow,
                'FilterInletPr' => $request->FilterInletPr,
                'RejectFlow' => $request->RejectFlow,
                'SystemPr' => $request->SystemPr,
                'ProductFlow' => $request->ProductFlow,
                'RejectPr' => $request->RejectPr,
                'DOA' => $doa,
                'TOA' => $request->STOA,
                'ETOA' => $request->ETOA,
                'ObservationNote' => $request->ObservationNote,
                'ServiceType' => $request->ServiceType,
                'PaymentMode' => $request->PaymentMode,
                'ServiceCharges' => $request->ServiceCharges,
                'Part_Fitting' => $request->Part_Fitting,
                'Vat' => $request->Vat,
                'TotalAmount' => $request->TotalAmount,
                'PaymentStatus' => $request->PaymentStatus,
                'EquipmentLeft' => $request->EquipmentLeft,
                'Remarks' => $request->Remarks,
                'EquipmenttoOrder' => $request->EquipmenttoOrder,
                'saltVisit' => $request->saltVisit,
                'saltVisitDate' => $request->saltVisitDate != "" ? date('Y-m-d H:i:s', strtotime($request->saltVisitDate)) : null,
                'filterVisit' => $request->filterVisit,
                'filterVisitDate' => $request->filterVisitDate != "" ? date('Y-m-d H:i:s', strtotime($request->filterVisitDate)) : null
            ]);
            if ($report) {
                return response()->json(["success" => true, "message" => "Field Report Saved"]);
            } else {
                return response()->json(["success" => false, "message" => "action failed, try again"]);
            }
        }


    }

    public function GetContractListByCustomer(Request $request)
    {
        $contracts = array();
        try {
            $customerId = $request->id;
            $contracts = Contract::join("master_contract_type", "master_contract_type.id", "contracts.CNRT_Type")
                ->join("master_site_type", "master_site_type.id", "contracts.CNRT_SiteType")
                ->join("master_contract_status", "master_contract_status.id", "contracts.CNRT_Status")
                ->leftJoin("customer_sites", "customer_sites.id", "contracts.CNRT_Site")
                ->leftJoin("master_site_area", "master_site_area.id", "customer_sites.AreaName")
                ->where("contracts.CNRT_CustomerID", $customerId)
                ->get();
            foreach ($contracts as $contract) {
                $contract->CNRT_Date = Carbon::parse($contract->CNRT_Date)->format("d-M-Y");
                $contract->Start_Date = Carbon::parse($contract->CNRT_StartDate)->format("d-M-Y");
                $contract->End_Date = Carbon::parse($contract->CNRT_EndDate)->format("d-M-Y");
                $contract->Product_Name = $this->getProductName($contract->CNRT_ID);

            }
            return response()->json(['success' => true, 'message' => "", "contracts" => $contracts]);
        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => false, 'message' => $ex->getMessage(), "contracts" => $contracts]);
        }
    }
    function getProductName($id)
    {
        $productName = "";
        $product = ContractBaseProduct::
            join("products", "products.Product_ID", "contract_base_product.BaseProduct_ID")
            ->where("contract_base_product.CNRT_ID", $id)->get();
        if (!is_null($product)) {
            foreach ($product as $p) {
                if ($productName == "") {
                    $productName = $p->Product_Name;
                } else {
                    $productName = $productName . ", " . $p->Product_Name;
                }

            }
        }


        return $productName;

    }
    public function GetTicketListCustomer(Request $request)
    {

        try {
            $userId = $request->id;
            $requestType = $request->requesttype;
            if ($requestType == 1) {
                $services = Service::
                    join("master_service_status", "master_service_status.Status_Id", "services.service_status")
                    ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
                    ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
                    ->join("clients", "clients.CST_ID", "services.customer_id")
                    ->join("master_service_type", "master_service_type.id", "services.service_type")
                    ->leftJoin("contracts", "contracts.CNRT_ID", "services.contract_id")
                    ->leftJoin("employees", "employees.EMP_ID", "services.assigned_to")
                    ->where("services.customer_id", "$userId")
                    ->where("services.service_status", "6")
                    ->orderBy('services.id', 'DESC')
                    ->limit(30)
                    ->get(["employees.*", "services.id as service_id", "master_service_status.*", "master_service_priority.*", "services.*", "contracts.*", "clients.*", "master_issue_type.*", "master_service_type.*"]);
                foreach ($services as $service) {
                    $service->service_date = Carbon::parse($service->service_date)->format("d-M-Y");
                    $service->service_time = Carbon::parse($service->service_date)->format("");
                    $service->accessory = $this->GetServiceAccessory($service->service_id);
                }

                return response()->json(['success' => true, 'message' => "2", "tickets" => $services]);

            } else {

                $services = Service::
                    join("master_service_status", "master_service_status.Status_Id", "services.service_status")
                    ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
                    ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
                    ->join("clients", "clients.CST_ID", "services.customer_id")
                    ->join("master_service_type", "master_service_type.id", "services.service_type")
                    ->leftJoin("contracts", "contracts.CNRT_ID", "services.contract_id")
                    ->leftJoin("employees", "employees.EMP_ID", "services.assigned_to")
                    ->where("services.customer_id", "$userId")
                    ->where("services.service_status", "!=", "6")
                    ->get(["employees.*", "services.id as service_id", "master_service_status.*", "master_service_priority.*", "services.*", "contracts.*", "clients.*", "master_issue_type.*", "master_service_type.*"]);

                foreach ($services as $service) {
                    $service->service_date = Carbon::parse($service->service_date)->format("d-M-Y");
                    $service->service_time = Carbon::parse($service->service_date)->format("");
                    $service->accessory = $this->GetServiceAccessory($service->service_id);
                }

                return response()->json(['success' => true, 'message' => $userId, "tickets" => $services]);

            }

        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => false, 'message' => "Exception:" . $ex->getMessage(), "tickets" => []]);
        }

    }
    public function GetServiceTicketByIdCustomer(Request $request)
    {

        $service = array();
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "id" => "required",
                    "userId" => "required",
                ]
            );
            if ($validator->fails()) {
                return response()->json(["success" => false, "message" => "Service information missing."]);
            }
            $id = $request->id;
            $userId = $request->userId;
            $service = Service::
                join("master_service_status", "master_service_status.Status_Id", "services.service_status")
                ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
                ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
                ->join("clients", "clients.CST_ID", "services.customer_id")
                ->join("master_service_type", "master_service_type.id", "services.service_type")
                ->leftJoin("contracts", "contracts.CNRT_ID", "services.contract_id")
                ->where("services.customer_id", $userId)
                ->where("services.id", $id)
                ->first(["services.id as service_id", "master_service_status.*", "master_service_priority.*", "services.*", "contracts.*", "clients.*", "master_issue_type.*", "master_service_type.*"]);


            // $service->status=$this->GetStatusList();  
            if ($service) {
                $service->serviceDate = Carbon::parse($service->service_date)->format("d-M-Y");
                $service->reason = $this->GetReasonList();
                $service->accessory = $this->GetServiceAccessory($service->service_id);
            }


        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(["success" => false, "ticket" => []]);
        }
        return response()->json(["success" => true, "ticket" => $service]);
    }
    public function GetServiceTicketById(Request $request)
    {

        $service = array();
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "id" => "required",
                    "userId" => "required",
                ]
            );
            if ($validator->fails()) {
                return response()->json(["success" => false, "message" => "Service information missing."]);
            }
            $id = $request->id;
            $userId = $request->userId;
            $service = Service::select("*", "services.id as service_id","services.updated_at as updatedAt")
                ->join("master_service_status", "master_service_status.Status_Id", "services.service_status")
                ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
                ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
                ->join("master_service_type", "master_service_type.id", "services.service_type")
                ->leftJoin("master_site_area", "master_site_area.id", "services.areaId")
                ->join("clients", "clients.CST_ID", "services.customer_id")
                ->leftJoin("users", "users.id", "services.assigned_to")
                ->where("services.assigned_to", $userId)
                ->where("services.id", $id)
                ->first(["master_site_area.*", "customer_sites.*", "services.id as service_id", "master_service_status.*", "master_service_priority.*", "services.*", "contracts.*", "clients.*", "master_issue_type.*", "master_service_type.*"]);


            // $service->status=$this->GetStatusList();  
            if ($service) {
                $service->serviceDate = Carbon::parse($service->service_date)->format("d-M-Y");
                $service->reason = $this->GetReasonList();
                $service->accessory = $this->GetServiceAccessory($service->service_id);
                $service->updatedAt = date('d-M-Y H:s a', strtotime($service->updatedAt));
            }


        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(["success" => false, "ticket" => []]);
        }
        return response()->json(["success" => true, "ticket" => $service]);
    }
    public function GetReasonList()
    {


        $reason = ActionReason::all();
        return $reason;

    }
    public function GetStatusList()
    {

        $status = ServiceStatus::where("flag", 1)->whereNotIn("Status_Id", [1,6,5])->get();
        return $status;

    } 
    public function GetServiceHistory(Request $request)
    {
        $history = array();
        try {
            $serviceId = $request->id;
            $history = ServiceHistory::leftJoin("master_service_status", "master_service_status.Status_Id", "service_action_history.status_id")
                ->leftJoin("master_service_sub_status", "master_service_sub_status.Sub_Status_Id", "service_action_history.sub_status_id")
                ->where("service_id", $serviceId)
                ->orderBy('service_action_history.id', 'DESC')->get();
        } catch (Exception $ex) {
            return response()->json(["success" => false, "history" => []]);
        }
        return response()->json(["success" => true, "history" => $history]);
    }

    public function ApplyServiceAction(Request $request)
    {

        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "service_id" => "required",
                    "status_id" => "required",
                    'user_id' => "required",
                    'reason_id' => "required",
                    // 'last_long'=>'required',
                    // 'last_lang'=>'required'
                ]
            );

            if ($validator->fails()) {
                return response()->json(["success" => false, "message" => "all fields required.", "validation_error" => $validator->errors()]);
                // exit;
            }
            $engineerId = $request->user_id;
            $reasonId = $request->reason_id;
            $actionId = $request->status_id;
            $note = $request->action_description;
            $serviceId = $request->service_id;
            DB::beginTransaction();
            $create = ServiceHistory::create([
                    'service_id' => $serviceId,
                    'status_id' => $actionId,
                    'user_id' => $engineerId,
                    'reason_id' => $reasonId,
                    'action_description' => $note,
                ]);
                if ($create) {
                    $update = Service::where("id", $serviceId)
                        ->update([
                            'service_status' => $actionId,
                            'assigned_to' => $actionId == 8 ? 0 : $engineerId,
                            'notification_flag' => 1
                        ]);
                    if ($update) {
                        try{
                            // Send push notification for status update
                            $service = Service::where('id', $serviceId)->first();
                            if ($service) {
                                $pushNotificationService = new PushNotificationService();
                                $pushNotificationService->sendServiceStatusUpdateNotification(
                                    $engineerId,
                                    $service->service_no,
                                    $this->getStatusName($actionId)
                                );
                            }
                            
                            $location = LocationHistory::create([
                                'User_ID' => $request->user_id,
                                'last_long' => $request->last_long,
                                'last_lang' => $request->last_lang,
                                'full_address' => "",
                                'area_code' => "",
                            ]);
                            if($location){
                                DB::commit();
                                return response()->json(['success' => true, 'message' => 'action applied and status updated.']);
                            }
                        }catch(Exception $exp){
                            DB::rollBack();
                            return response()->json(['success' => false, 'message' => 'action failed, try again!'.$exp->getMessage()]);
                        }
                        
                    } else {
                        DB::rollBack();
                        return response()->json(['success' => false, 'message' => 'Unable to update status, try again.!']);
                    }
    
                } else {
                    return response()->json(['success' => false, 'message' => 'Unable to store action, try again.']);
                }
            // if($request->last_long != "undefined" && $request->last_lang != "undefined"){
                
            // } else {
            //     return response()->json(["success" => false, "message" => "action failed, try again, Uable to get location!"]);
            // }
           

        } catch (Exception $ex) {
            return response()->json(["success" => false, "message" => "action failed, try again!"]);
        }

    }
    public function ApplyRejectAction(Request $request)
    {

        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "service_id" => "required",
                    "status_id" => "required",
                    'user_id' => "required",
                    'reason_id' => "required",
                    'action_description' => "required",
                ]
            );

            if ($validator->fails()) {
                return response()->json(["success" => false, "message" => "all fields required.", "validation_error" => $validator->errors()]);
            }
            $engineerId = $request->user_id;
            $reasonId = $request->reason_id;
            $actionId = $request->status_id;
            $note = $request->action_description;
            $serviceId = $request->service_id;
            DB::beginTransaction();
            $create = ServiceHistory::create([
                'service_id' => $serviceId,
                'status_id' => $actionId,
                'user_id' => $engineerId,
                'reason_id' => $reasonId,
                'action_description' => $note,
            ]);
            if ($create) {
                $update = Service::where("id", $serviceId)
                    ->update([
                        'service_status' => $actionId,
                        'assigned_to' => $actionId == 8 ? 0 : $engineerId,
                        'notification_flag' => 1
                    ]);
                if ($update) {
                    try{
                      $location =   LocationHistory::create([
                            'User_ID' => $request->user_id,
                            'last_long' => $request->last_long,
                            'last_lang' => $request->last_lang,
                            'full_address' => "",
                            'area_code' => "",
                        ]);
                        if($location){
                            DB::commit();
                            return response()->json(['success' => true, 'message' => 'action applied and status updated.']);
               

                        }
                    }catch(Exception $exp){
                        DB::rollBack();
                        return response()->json(['success' => false, 'message' => 'action failed, try again!'.$exp->getMessage()]);
                    }
                    
                } else {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'action failed, try again!']);
                }

            } else {
                return response()->json(['success' => false, 'message' => 'action failed, try again!']);
            }
           

        } catch (Exception $ex) {
            return response()->json(["success" => false, "message" => "action failed, try again!"]);
        }

    }
    public function FinalTicketClose(Request $request)
    {


        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "service_id" => "required",
                    'user_id' => "required",
                ]
            );

            if ($validator->fails()) {
                return response()->json(["success" => false, "message" => "ticket details missing.", "validation_error" => $validator->errors()]);
            }
            $engineerId = $request->user_id;
            $serviceId = $request->service_id;

            $create = ServiceHistory::create([
                'service_id' => $serviceId,
                'status_id' => 6,
                'user_id' => $engineerId,
                'reason_id' => 1,
                'action_description' => "Resloved & Closed",
            ]);
            if ($create) {
                $closedBy = $this->GetClosedByName($engineerId);
                $update = Service::where("id", $serviceId)
                    ->update([
                        'service_status' => 6,
                        'ClosedBy' => $closedBy,
                        'notification_flag' => 1
                    ]);
                if ($update) {
                    return response()->json(['success' => true, 'message' => 'Ticket closed successfully.']);
                } else {
                    ServiceHistory::where('id', $create->id)->delete();
                    return response()->json(['success' => false, 'message' => 'action failed, try again!']);
                }

            } else {
                return response()->json(['success' => false, 'message' => 'action failed, try again!']);
            }

        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(["success" => false, "message" => "action failed, try again!"]);
        }
    }
    public function GetClosedByName($engineerId)
    {
        $closeName = "";
        $user = User::where("users.id", $engineerId)->join("master_user_roles", "master_user_roles.id", "users.role")->first();
        if ($user) {
            $closeName = $user->name . " (" . $user->role_name . ")";
        }
        return $closeName;

    }

    public function GetServiceAccessory($id)
    {

        $serviceId = $id;
        $dc_products = ServiceDcProduct::select("service_dc.*","service_dc_product.*","products.*", "master_product_type.*", "service_dc_product.id as sdp", "service_dc_product.*", "products.*")
            ->join("products", "products.Product_ID", "service_dc_product.product_id")
            ->leftJoin("master_product_type", "master_product_type.id", "products.Product_Type")
            ->join("service_dc", "service_dc.id", "service_dc_product.dc_id")
            ->join("services", "services.id", "service_dc.service_id")
            ->where("service_dc.service_id", $id)->get();
        // dd($dc_products);
           
        return $dc_products;

    }

    public function GetTickets(Request $request)
    {

        try {
            $userId = $request->id;
            $ticket_status = $request->status;
            $services = Service::
                join("master_service_status", "master_service_status.Status_Id", "services.service_status")
                ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
                ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
                ->join("clients", "clients.CST_ID", "services.customer_id")
                ->join("master_service_type", "master_service_type.id", "services.service_type")
                ->join("employees", "employees.EMP_ID", "services.assigned_to")
                ->leftJoin("contracts", "contracts.CNRT_ID", "services.contract_id")
                ->where("assigned_to", $userId)
                ->when($ticket_status != 0, function ($query) use ($ticket_status) {
                    $query->where("service_status", $ticket_status);
                })
                ->orderByDesc("services.updated_at")
                ->get(["services.updated_at as updatedAt","employees.*", "services.id as service_id", "master_service_status.*", "master_service_priority.*", "services.*", "contracts.*", "clients.*", "master_issue_type.*", "master_service_type.*"]);
            foreach ($services as $service) {
                $service->updatedAt = date('d-M-Y H:s a', strtotime($service->updatedAt));
                $service->serviceDate = Carbon::parse($service->service_date)->format("d-M-Y");
                $service->serviceTime = Carbon::parse($service->service_date)->format("d-M-Y H:s a");
                $service->accessory = $this->GetServiceAccessory($service->service_id);
                $service->StartDate = date('d-M-Y', strtotime($service->accepted_datetime));
                $service->CompletionDate = date('d-M-Y', strtotime($service->resolved_datetime));
                $service->createdAt = date('d-M-Y', strtotime($service->created_at));
                $service->ClosedBy = '';
                $service->productName = $this->getProductName($service->contract_id);
            }
            return response()->json(['success' => true, 'message' => "", "tickets" => $services]);
        } catch (Exception $ex) {
            return response()->json(['success' => false, 'message' => "Exception:" . $ex->getMessage(), "tickets" => []]);
        }

    }

    public function EngineerDashboard(Request $request)
    {

        $new_ticket = 0;
        $open_ticket = 0;
        $pending_ticket = 0;
        $resovled_ticket = 0;
        $closed_ticket = 0;
        try {
            $userId = $request->id;

            $new_ticket = Service::where("service_status", "6")->where("assigned_to", $userId)->get()->count();
            $open_ticket = Service::where("service_status", "2")->where("assigned_to", $userId)->get()->count();
            $pending_ticket = Service::where("service_status", "3")->where("assigned_to", $userId)->get()->count();
            $resolved_ticket = Service::where("service_status", "4")->where("assigned_to", $userId)->get()->count();
            $closed_ticket = Service::where("service_status", "5")->where("assigned_to", $userId)->get()->count();

            return response()->json(["success" => true, "message" => '', "newTicket" => $new_ticket, "openTicket" => $open_ticket, "pendingTicket" => $pending_ticket, "closedTicket" => $closed_ticket, "resolvedTicket" => $resolved_ticket]);
        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(["success" => false, "message" => 'Action Failed', "newTicket" => $new_ticket, "openTicket" => $open_ticket, "pendingTicket" => $pending_ticket, "closedTicket" => $closed_ticket, "resolvedTicket" => $resolved_ticket]);
        }

    }
    public function SignIn(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "email" => "required|email",
                "password" => "required",
            ]
        );
        if ($validator->fails()) {
            return [400, "message" => "Valid email and password required", "data" => $request->all()];
        }
        // check if entered email exists in db
        $email_status = User::where("email", $request->email)->first();
        // if email exists then we will check password for the same email
        if ($email_status) {
            $password_status = Hash::check($request->password, $email_status->password);
            // if password is correct
            if ($password_status) {
                if($email_status->status !=1){
                    return response()->json(["success" => false, "message" => 'Your account has been deactivated', "user" =>[]]);
                
                } else
                if ($email_status->role == 3) {
                    $token = Str::random(40); // Generate a random token with 40 characters
                    $email_status->api_token = $token;
                    $email_status->save();
                    $this->Login_Session_History($email_status, $request->ip);
                    $userData = $this->userDetail($email_status->email, $email_status->role);
                    return response()->json(["success" => true, "message" => 'You have logged in successfully', "user" => $userData]);
                } else {
                    return response()->json(["success" => false, "message" => 'Invalid user.', "user" => null]);
                }

            } else {
                return response()->json(["success" => false, "message" => 'Invalid Password', "user" => null]);
            }
        } else {
            return response()->json(["success" => false, "message" => 'Invalid Email or Password']);

        }
    }
    public function Login_Session_History($user, $ip)
    {

        if ($user->id > 0) {
            $session = LoginSessionHistory::create([
                "Role" => $user->role,
                "User_Id" => $user->id,
                "Login_Token" => "",
                "Ip_Address" => $ip,
            ]);
        }
    }
    public function userDetail($email, $role)
    {
        $user = array();
        if ($email != "" && $role != "") {
            if ($role == 1) {
                $user = User::where("email", $email)->first();
                return $user;
            } else if ($role == 2) {
                $user = User::join("clients", "clients.CST_ID", "users.id")->where("email", $email)->first();
                $user->loginDate = new \DateTime("NOW");
                return $user;

            } else if ($role == 3) {
                $user = User::join("employees", "employees.EMP_ID", "users.id")->where("email", $email)->first();
                $user->loginDate = new \DateTime("NOW");
                return $user;
            } else {
                return $user;
            }

        }
    }
    public function GetCustomerCode()
    {

        $code = "";
        $last = Client::latest()->first();
        if (is_null($last)) {
            $code = "CST001";
        } else {
            $lastNumber = $last->CST_Code;
            $array = explode("CST", $lastNumber);
            $num = $array[1];
            $num = $num + 1;
            if ($num < 100 && $num > 9) {
                $code = "CST0" . $num;
            } else {
                $code = "CST00" . $num;
            }

        }
        return $code;

    }

    function SignUp(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "name" => "required",
                "email" => "required",
                "password" => "required",


            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "all fields required.", "email" => $request->email]);
        }
        try {
            $uniqId = $this->GetCustomerCode();
            $iscustomer = Client::where("CST_Code", $uniqId)->first();
            if (is_null($iscustomer)) {
                $isUser = User::where("email", $request->email)->first();
                if (is_null($isUser)) {
                    $password = Hash::make($request->password);
                    $user = User::create([
                        "name" => $request->name,
                        "email" => $request->email,
                        "password" => $password,
                        "role" => 2
                    ]);
                    $userId = $user->id;
                    if ($userId > 0) {
                        $customer = Client::create([
                            'CST_ID' => $userId,
                            'CST_Code' => $uniqId,
                            'CST_Name' => $request->name,
                            'CST_Website' => '',
                            'CST_OfficeAddress' => '',
                            'CST_SiteAddress' => '',
                            'CST_Note' => '',
                            'CCP_Name' => $request->name,
                            'CCP_Mobile' => '',
                            'CCP_Department' => '',
                            'CCP_Email' => $request->email,
                            'CCP_Phone1' => '',
                            'CCP_Phone2' => '',
                        ]);
                        if ($customer) {
                            return response()->json(["success" => true, "message" => "Account created, Login to continue."]);
                        } else {
                            return response()->json(["success" => false, "message" => "Failed, Try again."]);
                        }
                    } else {
                        return response()->json(["success" => false, "message" => "Someting went wrong, Try again."]);
                    }
                } else {
                    return response()->json(["success" => false, "message" => "Email already exists, Try to login."]);

                }

            }

        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => false, 'message' => "Exception:" . $ex->getMessage()]);
        }
    }
    public function Profile(Request $request)
    {
        try{
            $id = $request->userId;
            $user = User::where("id", $id)->join("employees","employees.EMP_ID","users.id")->first();
            return response()->json(['success' => true, "user"=>$user,'message' => "success"]);
        }catch(Exception $exp){
            return response()->json(['success' => false, 'message' => "Exception:" . $exp->getMessage()]);
        }
        

    }

    public function GetRecentActivity(Request $request)
    {
        try {
            $userId = $request->userId;
            
            if (!$userId) {
                return response()->json([
                    'success' => false, 
                    'message' => 'User ID is required'
                ]);
            }

            // Get the most recent service assigned to the user with notification_flag = 1
            $recentActivity = Service::where('assigned_to', $userId)
                ->where('notification_flag', 1)
                ->orderBy('updated_at', 'desc')
                ->first();

            if (!$recentActivity) {
                return response()->json([
                    'success' => true,
                    'message' => 'No recent activity found',
                    'recentActivity' => null
                ]);
            }

            // Get service status name
            $statusName = ServiceStatus::where('Status_Id', $recentActivity->service_status)->first();
            
            // Format the response
            $activityData = [
                'service_id' => $recentActivity->service_id,
                'service_no' => $recentActivity->service_no,
                'service_date' => $recentActivity->service_date,
                'customer_name' => $recentActivity->customer->CST_Name ?? 'N/A',
                'service_type' => $recentActivity->service_type,
                'service_status' => $recentActivity->service_status,
                'status_name' => $statusName->Status_Name ?? 'N/A',
                'assigned_to' => $recentActivity->assigned_to,
                'notification_flag' => $recentActivity->notification_flag,
                'updated_at' => $recentActivity->updated_at,
                'created_at' => $recentActivity->created_at
            ];

            return response()->json([
                'success' => true,
                'message' => 'Recent activity retrieved successfully',
                'recentActivity' => $activityData
            ]);

        } catch (Exception $exp) {
            return response()->json([
                'success' => false, 
                'message' => "Exception: " . $exp->getMessage()
            ]);
        }
    }

    /**
     * Get status name by status ID
     *
     * @param int $statusId
     * @return string
     */
    private function getStatusName($statusId)
    {
        $statusMap = [
            1 => 'New',
            2 => 'Open',
            3 => 'Pending',
            4 => 'Resolved',
            5 => 'Closed',
            6 => 'Assigned',
            7 => 'In Progress',
            8 => 'Unassigned'
        ];

        return $statusMap[$statusId] ?? 'Unknown';
    }

    /**
     * Test push notification functionality
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function testPushNotification(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer|exists:users,id',
                'title' => 'required|string|max:255',
                'message' => 'required|string|max:500'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ]);
            }

            $pushNotificationService = new PushNotificationService();
            $result = $pushNotificationService->sendPushNotification(
                $request->user_id,
                $request->title,
                $request->message,
                ['type' => 'test', 'timestamp' => now()->toISOString()]
            );

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Push notification sent successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send push notification. Check if user has valid FCM token.'
                ]);
            }

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Test FCM token functionality
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function testFCMToken(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer|exists:users,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ]);
            }

            $userId = $request->user_id;
            $user = User::where('id', $userId)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ]);
            }

            $fcmToken = $user->fcm_token;
            $hasToken = !empty($fcmToken);

            return response()->json([
                'success' => true,
                'message' => 'FCM token status retrieved successfully',
                'user_id' => $userId,
                'has_fcm_token' => $hasToken,
                'fcm_token_preview' => $hasToken ? substr($fcmToken, 0, 20) . '...' : null,
                'token_length' => $hasToken ? strlen($fcmToken) : 0
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get service type list
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function GetServiceTypeList()
    {
        try {
            $serviceTypes = DB::table('service_types')
                ->select('id', 'name', 'description')
                ->where('status', 1)
                ->orderBy('name', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Service types retrieved successfully',
                'data' => $serviceTypes
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get issue type list
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function GetIssueTypeList()
    {
        try {
            $issueTypes = DB::table('issue_types')
                ->select('id', 'name', 'description')
                ->where('status', 1)
                ->orderBy('name', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Issue types retrieved successfully',
                'data' => $issueTypes
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}
