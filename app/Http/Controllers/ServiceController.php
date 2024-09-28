<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ContractScheduleService;
use App\Models\DcType;
use App\Models\ProductSerialNumber;
use App\Models\ProductType;
use App\Models\ServiceDc;
use App\Models\ServiceDcProduct;
use App\Models\ServiceSubStatus;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
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
use Illuminate\Support\Facades\Hash;
use App\Models\ServiceType;
use App\Models\IssueType;
use App\Models\Service;
use App\Models\Priority;
use App\Models\ServiceAccessory;
use App\Models\ServiceHistory;
use App\Models\ActionReason;
use App\Models\ServiceStatus;
use App\Models\ServiceFieldReport;
use App\Models\ServiceUnderProduct;
use Carbon\Carbon;
use App\Models\MailSetting;
use App\Models\ContractUnderProduct;
use App\Models\Account_Setting;
use App\Models\AreaName;
use App\Http\Controllers\MailController;
use Notification;
use Exception;
use App\Notifications\SendPushNotification;

class ServiceController extends Controller
{

    public function AcceptRejectCall(Request $request, Service $service)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'service_id' => "required",
                    'flag' => "required",
                ]
            );
            if ($validator->fails()) {
                return response()->json(["success" => false, "message" => "Required information missing.", "validation_error" => $validator->errors()]);
            }
            if (!empty($service)) {
                $id = Auth::user()->id;
                if ($request->flag == 2) {
                    $service->accepted_datetime = now();
                }
                $service->service_status = $request->flag;
                $service->assigned_to = $request->flag != 2 ? 0 : $service->assigned_to;
                $service->save();
                $note = $request->flag == 2 ? "ticket accepeted by engineer." : "ticket rejected by engineer, " . $request->note ?? "";
                $isOk = $this->AddServiceHistoryM($service->id, $request->flag, $id, 1, $note);
                return response()->json(["success" => true, "message" => "Action applied!"]);
            }
            return response()->json(["success" => false, "message" => "Something went wrong, try again."]);
        } catch (Exception $exp) {
            return response()->json(["success" => false, "message" => $exp->getMessage()]);
        }


    }
    public function DeleteServiceDc(Request $request, ServiceDc $serviceDc)
    {

        try {


            $dcproduct_count = ServiceDcProduct::where(["dc_id"=>$serviceDc->id])->count();
            if($dcproduct_count>0){
              
                ServiceDcProduct::where(["dc_id"=>$serviceDc->id])->delete();
               
            }
            $serviceDc->delete();
            $service = Service::where('id',$serviceDc->service_id)->one();
            $action = "Service DC marked as deleted, Name:" . $service->service_no;
            $log = App(\App\Http\Controllers\LogController::class);
            $log->SystemLog($request->loginId, $action);
            return back()->with("success", "Deleted!");
        } catch (Exception $exp) {
            dd($exp->getMessage());
            return back()
                ->withError("Action failed, try again.");
        }

    }
    public function GetServiceUnderProduct(Request $request)
    {
        $product = null;
        try {
            $product = ServiceUnderProduct::where("serviceId", $request->serviceId)->get();
        } catch (Exception $e) {
        }
        return $product;
    }
    public function ProductCreate(Request $request, Service $service)
    {
        $product_types = ProductType::all();
        foreach ($product_types as $i => $type) {

            $products = Product::where("Product_Type", $type->id)->get();
            $product_types[$i]['products'] = $products;
            foreach ($products as $index => $product) {
                $srnumbers = ProductSerialNumber::where(["product_id" => $product->Product_ID])->get();
                $products[$index]['serial_numbers'] = $srnumbers;
            }

        }
        return view("services.product_add", [
            'service' => $service,
            'dctype' => DcType::all(),
            'productType' => $product_types,
        ]);
    }
    public function AddServiceProduct(Request $request, Service $service)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'issue_date' => 'required',
                'dc_type' => 'required',
                'product_id.*' => 'required',
                'serial_no.*' => 'required',
                'amount.*' => 'required',
                'description.*' => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "Product information missing.", "validation_error" => $validator->errors()]);
        }
        $size = 0;
        $data = $request->data;
        DB::beginTransaction();
        $dc = ServiceDc::create([
            'service_id' => $service->id,
            'dc_type' => $request->dc_type,
            'dc_remark' => $request->dc_remark,
            'dc_amount' => array_sum(array_column($data, "amount")),
            'issue_date' => date('Y-m-d', strtotime($request->issue_date)),
            'dc_status' => 1,
        ]);
        if ($dc->id > 0) {
            foreach ($data as $key => $name) {

                $create = ServiceDcProduct::create([
                    'dc_id' => $dc->id,
                    'product_id' => $data[$key]['product_id'],
                    'serial_no' => $data[$key]['serial_no'] != "" ? $data[$key]['serial_no'] : 0,
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
    public function AddUpdateUnderServiceProduct(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'serviceId' => "required",
                'product_name' => "required",
                'action' => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "Product information missing.", "validation_error" => $validator->errors()]);
        }
        try {
            if ($request->action == "add") {
                $product = ServiceUnderProduct::create([
                    'productId' => $request->productId,
                    'serviceId' => $request->serviceId,
                    'contractId' => $request->contractId,
                    'product_name' => $request->product_name,
                    'product_type' => $request->product_type,
                    'product_price' => $request->product_price,
                    'product_description' => $request->product_description,
                    'nrnumber' => $request->nrnumber,
                    'other' => $request->other,
                    'branch' => $request->branch,
                    'updated_by' => $request->userId,
                ]);
                if ($product) {
                    $product_data = ServiceUnderProduct::where("serviceId", $request->serviceId)->get();
                    return response()->json(['success' => true, 'message' => 'Product Add', 'product' => $product_data]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Failed to add product.', 'product' => $product_data]);
                }
            } else if ($request->action == "update") {

                $product = ServiceUnderProduct::where("serviceId", $request->serviceId)->update([
                    'product_name' => $request->product_name,
                    'product_type' => $request->product_type,
                    'product_price' => $request->product_price,
                    'product_description' => $request->product_description,
                    'nrnumber' => $request->nrnumber,
                    'other' => $request->other,
                    'branch' => $request->branch,
                    'updated_by' => $request->userId,
                ]);
                if ($product) {
                    $product_data = ServiceUnderProduct::where("serviceId", $request->serviceId)->get();
                    return response()->json(['success' => true, 'message' => 'Product Updated', 'product' => $product_data]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Failed to update Product.', 'product' => $product]);
                }
            } else {

            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }

    }
    public function DcPrint(ServiceDc $serviceDc, Request $request)
    {
        $products = ServiceDcProduct::select("product_serial_numbers.*", "master_product_type.*", "service_dc_product.id as sdp", "service_dc_product.*", "products.*")->where(['dc_id' => $serviceDc->id])
            ->join("products", "products.Product_ID", "service_dc_product.product_id")
            ->leftJoin("master_product_type", "master_product_type.id", "products.Product_Type")
            ->leftJoin("product_serial_numbers", "product_serial_numbers.id", "service_dc_product.serial_no")
            ->get();

        $serviceDc = ServiceDc::select("clients.*", "services.*", "dc_type.*", "service_dc.id as dcp_id", "master_dc_status.*")->join("master_dc_status", "master_dc_status.id", "service_dc.dc_status")
            ->join("dc_type", "dc_type.id", "service_dc.dc_type")
            ->join("services", "services.id", "service_dc.service_id")
            ->join("clients", "clients.CST_ID", "services.customer_id")
            ->first();
        $date = date('Y-m-d');

        return view('dcmanagement.print', compact('serviceDc', 'products', 'date'));
    }

   public function DcView(ServiceDc $serviceDc, Request $request)
    {
        $dc_products = ServiceDcProduct::select("product_serial_numbers.*", "master_product_type.*", "service_dc_product.id as sdp", "service_dc_product.*", "products.*")->where(['dc_id' => $serviceDc->id])
            ->join("products", "products.Product_ID", "service_dc_product.product_id")
            ->leftJoin("master_product_type", "master_product_type.id", "products.Product_Type")
            ->leftJoin("product_serial_numbers", "product_serial_numbers.id", "service_dc_product.serial_no")
            ->get();

        $serviceDc = ServiceDc::select("clients.*", "services.*", "dc_type.*", "service_dc.id as dcp_id", "master_dc_status.*")->join("master_dc_status", "master_dc_status.id", "service_dc.dc_status")
            ->join("dc_type", "dc_type.id", "service_dc.dc_type")
            ->join("services", "services.id", "service_dc.service_id")
            ->join("clients", "clients.CST_ID", "services.customer_id")
            ->first();
        return view("services.dc_view", [
            "service_dc" => $serviceDc,
            "dc_products" => $dc_products,
            'flag' => $request->flag ?? 0,
        ]);
    }
    public function DcpDelete(ServiceDcProduct $serviceDcProduct)
    { dd("hello");
        try {
           
            $serviceDcProduct->delete();
            return back()->with("success", "Deleted");
        } catch (Exception $exp) {
            return back()->withErrors("Action failed, try again");
        }
    }
    public function DeleteServiceAccesorry(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'productId' => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "Service accessory information missing.", "validation_error" => $validator->errors()]);
        }
        $isDelete = ServiceAccessory::find($request->productId)->delete();
        if ($isDelete) {
            return response()->json(["success" => true, "message" => "deleted successfully."]);
        }
        return response()->json(["success" => false, "message" => "action failed, try again."]);

    }
    public function delete(Service $service){
      
        try{
            $count = ServiceDc::where(["service_id"=>$service->id])->count();
            if($count == 0){
                $isDelete = $service->delete();
                if ($isDelete) {
                    $action = "Service Deleted,  Service No.:" .$service->service_no;
                    $log = App(\App\Http\Controllers\LogController::class);
                    $log->SystemLog(Auth::user()->id, $action);
                    return Redirect("services")->with("success", "Deleted");
                }
                return back()
                ->withError("Action failed, try again.");
            } else {
                // dd("heello");
                return back()
                    ->withError("Dc founds againt the service.");
            }
           
        }catch(Exception $exp){
            return back()
            ->withError($exp->getMessage());
        }
    
    }
    public function DeleteService(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'id' => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "Service information missing.", "validation_error" => $validator->errors()]);
        }
        $isDelete = Service::find($request->id)->delete();
        if ($isDelete) {
            return response()->json(["success" => true, "message" => "deleted successfully."]);
        }
        return response()->json(["success" => false, "message" => "action failed, try again."]);



    }

    public function UpdateServiceAccessory(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "service_id" => "required",
                'id' => "required",
                'given_qty' => "required",
                'price' => "required",
                'IsPaid' => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "Service information missing.", "validation_error" => $validator->errors()]);
        }

        $serviceAcc = ServiceAccessory::where("id", $request->id)
            ->where("service_id", $request->service_id)
            ->update([
                'given_qty' => $request->given_qty,
                'price' => $request->price,
                'Is_Paid' => $request->IsPaid,
            ]);
        if ($serviceAcc) {
            return response()->json(["success" => true, "message" => "Changes Saved."]);
        } else {
            return response()->json(["success" => false, "message" => "Action failed, Try again."]);
        }


    }
    public function AddFieldReport(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "ServiceId" => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "Service information missing, reload and try again.", "validation_error" => $validator->errors()]);
        }
        $check = ServiceFieldReport::where('ServiceId', $request->ServiceId)->first();
        if ($check) {
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
            $report = ServiceFieldReport::where('ServiceId', $request->ServiceId)->update([
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
                'TOA' => $request->TOA,
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
                'filterVisitDate' => $request->filterVisitDate != "" ? date('Y-m-d H:i:s', strtotime($request->filterVisitDate)) : null,
                'isSubmitted' => $request->isSubmitted
            ]);
            if ($report) {
                $action = "Feild Replort updated for ticket., Ticket Number:" . $check->service_no . ", Contact Person:" . $check->contact_person . " Email:" . $check->contact_email;
                $log = App(\App\Http\Controllers\LogController::class);
                $log->SystemLog($request->userId, $action);
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
                'TOA' => $request->TOA,
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
                $check = ServiceFieldReport::where('ServiceId', $request->ServiceId)->first();
                $action = "Feild Replort created for ticket. Ticket Number:" . $check->service_no . ", Contact Person:" . $check->contact_person . " Email:" . $check->contact_email;
                $log = App(\App\Http\Controllers\LogController::class);
                $log->SystemLog($check->assigned_to, $action);
                return response()->json(["success" => true, "message" => "Field Report Saved"]);
            } else {
                return response()->json(["success" => false, "message" => "action failed, try again"]);
            }
        }


    }
    public function AddSeviceUnderProductManage(Request $request, $serviceId)
    {
        if ($request->service_details['productId'] != 0) {
            $product = $request->service_details;
            try {
                $productaa = ServiceUnderProduct::create([
                    'serviceId' => $serviceId,
                    'contractId' => $product['contractId'],
                    'productId' => $product['productId'],
                    'product_name' => $product['product_name'],
                    'product_type' => $product['product_type'],
                    'product_price' => $product['product_price'],
                    'product_description' => $product['product_description'],
                    'nrnumber' => $product['nrnumber'],
                    'other' => $product['other'],
                    'branch' => $product['branch'],
                    'updated_by' => $request->userId,
                ]);
                if ($productaa) {
                    return response()->json(['success' => true, 'message' => 'product added']);
                } else {
                    return response()->json(['success' => true, 'message' => 'product add failed.']);
                }
            } catch (Exception $e) {
                return response()->json(['success' => true, 'message' => 'Service Created']);
            }

        }
    }
    public function AddServiceCallManage(Request $request)
    {
        $Call_Date = $request->Call_Date;
        $Call_Service_Type = $request->Call_Service_Type;
        $Call_Priority = $request->Call_Priority;
        $contractId = $request->contractId;
        $productId = $request->productId;
        $accessoryId = $request->accessoryId;
        $scheduleServiceId = $request->scheduleId;
        $qty = $request->qty;
        $price = $request->price;
        $userId = $request->userId;
        $Customer = $this->getCustomer($contractId);
        $serviceNo = $this->GetServiceNumberM($request);
        if ($Customer != null) {
            try {
                $service = Service::create([
                    'service_no' => $serviceNo,
                    'service_date' => date('Y-m-d H:i:s', strtotime($Call_Date)),
                    'customer_id' => $Customer->CST_ID,
                    'contract_id' => $request->contractId,
                    'contact_person' => $Customer->CCP_Name,
                    'contact_number1' => $Customer->CCP_Mobile,
                    'contact_number2' => $Customer->CCP_Phone1,
                    'contact_email' => $Customer->CCP_Email,
                    'site_location' => $request->Call_Service_Location,
                    'site_google_link' => $request->Call_Googledirectionlink,
                    'issue_type' => $request->Call_Issue_Type,
                    'service_type' => $request->Call_Service_Type,
                    'service_priority' => $request->Call_Priority,
                    'service_status' => 2,
                    'assigned_to' => $request->EngineerId,
                    'service_note' => $request->Call_Description,
                ]);
                if ($service) {
                    $note = "ticket created from contract.";
                    $isOk = $this->AddServiceHistoryM($service->id, 1, $userId, 1, $note);
                    if ($request->EngineerId != "" && $request->EngineerId > 0) {
                        $note = "ticket assigned to engineer.";
                        $isOk = $this->AddServiceHistoryM($service->id, 2, $userId, 1, $note);
                    }
                    if ($isOk > 0) {
                        $isupdate = ContractScheduleModel::where("id", $scheduleServiceId)
                            ->update(["isManaged" => 1, "Service_Call_Id" => $service->id, "Schedule_Status" => 1]);
                        if ($isupdate) {
                            $this->AddSeviceUnderProductManage($request, $service->id);
                            return response()->json(["success" => true, "message" => "Ticket Created."]);
                        } else {
                            ServiceHistory::where('id', $isOk)->delete();
                            ServiceAccessory::where('id', $serviceAcc->id)->delete();
                            Service::where('id', $service->id)->delete();
                            return response()->json(["success" => false, "message" => "action failed, try again.SI:" . $scheduleServiceId]);
                        }
                    } else {
                        ServiceAccessory::where('id', $serviceAcc->id)->delete();
                        Service::where('id', $service->id)->delete();
                        return response()->json(["success" => false, "message" => "action failed, try again."]);
                    }
                } else {
                    return response()->json(["success" => false, "message" => "action failed, try again"]);
                }
            } catch (Illuminate\Database\QueryException $ex) {
                return response()->json(["success" => false, "message" => "action failed, try again"]);
            }

        } else {
            return response()->json(["success" => false, "message" => "customer details missing."]);
        }


    }
    public function AddServiceHistoryM($serviceId, $actionId, $engineerId, $reasonId, $note)
    {

        $create = ServiceHistory::create([
            'service_id' => $serviceId,
            'status_id' => $actionId,
            'sttus_status_id' => $reasonId,
            'user_id' => $engineerId,
            'action_description' => $note,

        ]);
        if ($create) {
            return $create->id;
        } else {
            return 0;
        }
    }
    public function getCustomer($contractId)
    {

        $Customer = null;
        try {
            $contract = Contract::where("CNRT_ID", $contractId)->first();
            $CustomerId = $contract->CNRT_CustomerID;
            $Customer = Client::where("CST_ID", $CustomerId)->first();
        } catch (Illuminate\Database\QueryException $ex) {

        }

        return $Customer;

    }
    public function GetAccountSettings(Request $request)
    {
        $accountsetting = Account_Setting::where("id", 1)->first();
        return $accountsetting;
    }
    public function GetServiceNumberM(Request $request)
    {

        $serviceId = "";
        $accountsetting = $this->GetAccountSettings($request);
        $call_ins = $accountsetting->serviceno_ins;
        if (!isset($call_ins)) {
            $call_ins = "Call";
        }
        $last = Service::latest()->first();
        if (is_null($last)) {
            $serviceId = $call_ins . "001";
        } else {
            $lastNumber = $last->service_no;
            $array = explode($call_ins, $lastNumber);
            $num = $array[1];
            $num = $num + 1;
            $serviceId = $call_ins . "00" . $num;

        }
        return $serviceId;

    }
    public function GetServiceProduct(Request $request)
    {

        $serviceAcc = array();

        $serviceId = $request->id;
        $serviceAcc = ServiceUnderProduct::where("serviceId", $serviceId)->get();
        foreach ($serviceAcc as $sc) {
            if ($sc->contractId > 0) {
                $sc->isContractedName = "Contracted";
            } else {
                $sc->isContractedName = "Non-Contracted";
            }

        }
        return $serviceAcc;

    }

    public function GetServiceAccessory(Request $request)
    {

        $serviceAcc = array();

        $serviceId = $request->id;
        $serviceAcc = ServiceAccessory::leftJoin("storeproduct", "storeproduct.id", "service_accessory.accessory_id")
            ->leftJoin("master_store_product_category", "master_store_product_category.id", "storeproduct.product_category")
            ->where("service_accessory.service_id", $serviceId)
            ->get(["service_accessory.*", "service_accessory.id as productId", "storeproduct.*", "master_store_product_category.*"]);
        return $serviceAcc;

    }
    function getProductName($id)
    {
        $productName = "";
        $product = ServiceAccessory::
            join("products", "products.Product_ID", "service_accessory.product_id")
            ->where("service_accessory.service_id", $id)->first();
        if (!is_null($product)) {
            foreach ($product as $p) {
                if ($productName != "") {
                    $productName = $product->Product_Name;
                } else {
                    $productName = $productName . "," . $product->Product_Name;
                }

            }
        }


        return $productName;

    }
    public function GetServiceHistory(Request $request)
    {
        $history = array();
        try {
            $serviceId = $request->id;
            $history = ServiceHistory::
                join("master_service_status", "master_service_status.Status_Id", "service_action_history.status_id")
                ->join("master_service_action_reason", "master_service_action_reason.id", "service_action_history.reason_id")
                ->join("users", "users.id", "service_action_history.user_id")
                ->where("service_action_history.service_id", $serviceId)
                ->orderBy("service_action_history.created_at", "DESC")
                ->get([
                    "service_action_history.created_at as historyDate",
                    "service_action_history.*",
                    "master_service_action_reason.*",
                    "master_service_status.*"
                ]);


        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(["success" => false, "history" => []]);
        }
        return response()->json(["success" => true, "history" => $history]);
    }

    public function ApplyServiceAction(Request $request, Service $service)
    {

        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "status_id" => "required",
                    "sub_status_id" => "required",
                ]
            );

            if ($validator->fails()) {
                return response()->json(["success" => false, "message" => "all * marked fields required.", "validation_error" => $validator->errors()]);
            }
            $engineerId = $request->user_id ?? Auth::user()->id;
            $sub_status_id = $request->sub_status_id;
            $actionId = $request->status_id;
            $note = $request->action_description;
            $serviceId = $request->service_id;

            $create = ServiceHistory::create([
                'service_id' => $serviceId,
                'status_id' => $actionId,
                'user_id' => $engineerId,
                'sub_status_id' => $sub_status_id,
                'action_description' => $actionId == 5 ? 'NA' : $note,
            ]);
            if ($create) {
                $condition = [
                    'service_status' => $actionId,
                    'service_sub_status' => $sub_status_id
                ];
                if ($actionId == 5) {
                    $closed_at = date("Y-m-d h:i:s");
                    $closeByName = $this->GetClosedByName($engineerId);
                    $condition = [
                        'service_status' => $actionId,
                        'ClosedBy' => $closeByName,
                        'closed_at' => $closed_at,
                        'service_category' => $request->service_category,
                        'close_note' => $request->action_description,
                        'expenses' => $request->expenses,
                        'charges' => $request->charges,
                    ];
                } else
                    if ($actionId == 4) {
                        $resolvedDate = date("Y-m-d h:i:s");
                        $condition = [
                            'service_status' => $actionId,
                            'service_sub_status' => $sub_status_id,
                            'resolved_datetime' => $resolvedDate
                        ];
                    }

                $update = $this->UpdateServiceCall($serviceId, $condition);
                if ($update) {
                    Session::flash("success", "action applied and status updated.");
                    return response()->json(['success' => true, 'message' => 'action applied and status updated.']);
                } else {
                    // Session::flash("success", "action failed, try again!");
                    ServiceHistory::where('id', $create->id)->delete();
                    return response()->json(['success' => false, 'message' => 'action failed, try again!']);
                }
            } else {
                // Session::flash("success", "action failed, try again!");
                return response()->json(['success' => false, 'message' => 'action failed, try again!']);
            }

        } catch (Exception $ex) {
            // Session::flash("success", "action failed, try again!");
            return response()->json(["success" => false, "message" => "action failed, try again!" . $ex->getMessage()]);
        }

    }
    public function UpdateServiceCall($id, $condition)
    {
        $update = Service::where("id", $id)
            ->update($condition);
        if (Auth::user()->role == 3) {
            Service::where('services.id', $id)->update(["notification_flag" => 1]);
        }
        if ($update) {
            return true;
        } else {
            return false;
        }
    }
    public function GetClosedByName($engineerId)
    {
        $closeName = "hellow shakhe";
        $user = User::where("users.id", $engineerId)->join("master_user_roles", "master_user_roles.id", "users.role")->first();
        if ($user) {
            $closeName = $user->name . " (" . $user->role_name . ")";
        }
        return $closeName;

    }
    public function GetReasonList(Request $request)
    {


        $reason = ActionReason::all();
        return $reason;

    }
    public function GetStatusList(Request $request)
    {


        $status = ServiceStatus::where("flag", 1)->get();
        return $status;

    }


    public function AssignEngineer(Request $request)
    {

        $engineerId = $request->employee_id;
        $serviceId = $request->service_id_assign;
        $userId = Auth::user()->id;
        $isAssigned = Service::where("id", $serviceId)
            ->update(['assigned_to' => $engineerId, 'service_status' => 6]);

        if ($isAssigned) {
            $create = ServiceHistory::create([
                'service_id' => $serviceId,
                'status_id' => 6,
                'user_id' => $userId,
                'sub_status_id' => 0,
                'action_description' => "Ticket Assigned to Engineer",
            ]);
            try {
                $subject = "Service Assigned to Engineer";
                $mailsetting = MailSetting::where("id", 1)->first();
                $accountsetting = Account_Setting::where("id", 1)->first();
                if ($mailsetting->call_forward_mail_allowed) {
                    $service = Service::join("master_issue_type", "master_issue_type.id", "services.issue_type")
                        ->join("master_service_type", "master_service_type.id", "services.service_type")
                        ->where("services.id", $serviceId)
                        ->first();

                    $Customer = $this->GetCustomerId($service->customer_id);
                    $body = "Dear " . $Customer['name'] . ",<br/><br/>";
                    $body .= $mailsetting->call_forward_template . "<br/><br/>";
                    $body .= "Assigned To : " . $service->issue_name . "<br/>";
                    $body .= "Service No. : " . $service->service_no . "<br/>";
                    $body .= "Service Date : " . date('d-m-Y', strtotime($service->service_date)) . "<br/>";
                    $body .= "Service Type : " . $service->type_name . "<br/>";
                    $body .= "Issue Type : " . $service->issue_name . "<br/>";

                    $body .= $service->service_note . "<br/>";
                    $body .= "<br/><br/>" . $accountsetting->mail_signature;
                    $mail = new MailController;
                    $mail->SendMail($Customer['CCP_Email'], $subject, $body);
                    $this->SendNotification($engineerId);
                }
            } catch (Exception $e) {

            }

            return response()->json(['success' => true, 'message' => 'engineer assigned.']);
        } else {
            return response()->json(['success' => false, 'message' => 'action failed, try again']);
        }

    }
    public function GetCustomerId($CustomerId)
    {
        $Customer = array();
        try {
            $Customer = Client::where("CST_ID", $CustomerId)
                ->join("users", "users.id", "clients.CST_ID")->first();

        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $Customer;

    }
    public function SendNotification($userId)
    {
        try {
            $title = "Notification";
            $message = "You have new call, please check";
            $user = User::where("id", $userId)->first();
            $user->notify(new SendPushNotification($title, $message));
        } catch (Exception $e) {

        }

    }
    public function GetEngineerList(Request $request)
    {
        $employee = array();
        try {
            $employee = Employee::join("master_designation", "master_designation.id", "employees.EMP_Designation")->get();
        } catch (Exception $ex) {
            return response()->json(["success" => true, "employee" => null]);
        }
        return response()->json(["success" => true, "employee" => $employee]);
    }
    public function service_status_count($staus, $fromdate, $todate)
    {
        $count = Service::select("*", "services.id as service_id")
            ->join("master_service_status", "master_service_status.Status_Id", "services.service_status")
            ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
            ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
            ->join("master_service_type", "master_service_type.id", "services.service_type")
            ->join("clients", "clients.CST_ID", "services.customer_id")
            ->leftJoin("users", "users.id", "services.assigned_to")
            ->when(Auth::user()->role == 3, function ($query) {
                $query->where('assigned_to', Auth::user()->id);
            })
            ->whereBetween(DB::raw('DATE_FORMAT(services.service_date, "%Y-%m-%d")'), [$fromdate, $todate])
            ->where('services.service_status', $staus)->count();
        return $count;
    }
    public function index(Request $request)
    {
        $dayFilter = $request->dayFilter ?? 180;
        $filter_type = $request->filter_type ?? '';
        $filter_service_type = $request->filter_service_type ?? '';
        $filter_issue_type = $request->filter_issue_type ?? '';
        $filter_status_type = $request->filter_status_type ?? '';
        $todate = date("Y-m-d");
        $fromdate = date('Y-m-d', strtotime($todate . '-' . $dayFilter . ' days'));
        if ($dayFilter == 0) {
            $fromdate = $todate;
        }
        if ($dayFilter == 1) {
            $todate = date('Y-m-d', strtotime($todate . '-1 days'));
            $fromdate = date('Y-m-d', strtotime($todate . '-1 days'));
        }
        // dd(Auth::user()->id);
        $services = Service::select("*", "services.id as service_id", "services.updated_at as last_updated")
            ->join("master_service_status", "master_service_status.Status_Id", "services.service_status")
            ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
            ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
            ->join("master_service_type", "master_service_type.id", "services.service_type")
            ->join("clients", "clients.CST_ID", "services.customer_id")
            ->leftJoin("users", "users.id", "services.assigned_to")
            ->orderby("services.updated_at", "DESC")
            ->whereBetween(DB::raw('DATE_FORMAT(services.updated_at, "%Y-%m-%d")'), [$fromdate, $todate])
            ->orderBy('services.updated_at', "DESC")
            ->filter($request->only('search', 'trashed', 'search_field', 'filter_status'))
            ->when(Auth::user()->role == 3, function ($query) {
                $query->where('assigned_to', Auth::user()->id);
            })
            ->when($filter_service_type, function ($query) use($filter_service_type) {
                $query->where('service_type', $filter_service_type);
            })
            ->when($filter_issue_type, function ($query) use($filter_issue_type) {
                $query->where('issue_type', $filter_issue_type);
            })
            ->when($filter_status_type, function ($query) use($filter_status_type) {
                $query->where('service_status', $filter_status_type);
            })
            ->when($filter_type !='', function ($query) use($filter_type) {
                if($filter_type == 0){
                    
                    $query->where('contract_id', 0);
                }
                if($filter_type == 1){
                    
                    $query->where('contract_id','!=' ,0);
                }
                
            })
            
            ->paginate(10)
            ->withQueryString();
        $new = $this->service_status_count(1, $fromdate, $todate);
        $open = $this->service_status_count(2, $fromdate, $todate);
        $pending = $this->service_status_count(3, $fromdate, $todate);
        $resolved = $this->service_status_count(4, $fromdate, $todate);
        $closed = $this->service_status_count(5, $fromdate, $todate);
        $assigned = $this->service_status_count(6, $fromdate, $todate);
        return view(
            'services.index',
            [
                'filters' => $request->all('search', 'trashed', 'search_field', 'filter_status'),
                'search_field' => $request->search_field ?? '',
                'filter_status' => $request->filter_status ?? '',
                'search' => $request->search ?? '',
                'services' => $services,
                'dayFilter' => $dayFilter,
                'filter_type'=>$filter_type,
                'filter_service_type'=>$filter_service_type,
                'filter_issue_type'=>$filter_issue_type,
                'filter_status_type'=>$filter_status_type,
                'new' => $new,
                'issue_type'=>IssueType::all(),
                'open' => $open,
                'pending' => $pending,
                'resolved' => $resolved,
                'closed' => $closed,
                'assigned' => $assigned,
                'service_types'=>ServiceType::all(),
                'service_status'=>ServiceStatus::all()
            ]
        );


    }
    public function schedulecreate(Request $request, ContractScheduleService $contractScheduleService)
    {
        $service = Service::all()->last();
        $code = "SRVS_" . date('Y') . "_1";
        if (!empty($service)) {
            $code = "SRVS_" . date('Y') . "_" . $service->id + 1;
        }
        return view(
            'services.create',
            [
                'issue_type' => IssueType::all(),
                'service_type' => ServiceType::all(),
                'priorities' => Priority::all(),
                'clients' => Client::all(),
                'serviceType' => ServiceType::all(),
                'contractScheduleService' => $contractScheduleService,
                'update' => false,
                'customer_id' => $contractScheduleService->contract->CNRT_CustomerID ?? 0,
                'service_no' => $code,
                'service' => new Service(),
                'sitelocation' => AreaName::all(),
            ]
        );

    }
    public function create(Request $request)
    {
        $service = Service::all()->last();
        $code = "SRVS_" . date('Y') . "_1";
        if (!empty($service)) {
            $code = "SRVS_" . date('Y') . "_" . $service->id + 1;
        }


        return view(
            'services.create',
            [
                'issue_type' => IssueType::all(),
                'service_type' => ServiceType::all(),
                'priorities' => Priority::all(),
                'clients' => Client::all(),
                'serviceType' => ServiceType::all(),
                'contractScheduleService' => null,
                'customer_id' => 0,
                'update' => false,
                'service_no' => $code,
                'service' => new Service(),
                'sitelocation' => AreaName::all(),
            ]
        );

    }
    public function GetContractNumber($serviceId)
    {

    }
    public function GetServiceFieldReport(Request $request)
    {

        $report = array();
        try {
            $id = $request->id;
            $report = ServiceFieldReport::join("services", "services.id", "service_fieldreport.ServiceId")
                ->join("clients", "clients.CST_ID", "services.customer_id")
                ->where("services.id", $id)->first();
            return response()->json(["success" => true, "report" => $report]);
        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(["success" => false, "report" => []]);
        }

    }
    public function GetServiceCallById(Request $request)
    {

        $service = array();
        try {
            $id = $request->id;
            $service = Service::join("clients", "clients.CST_ID", "services.customer_id")
                ->join("master_service_status", "master_service_status.Status_Id", "services.service_status")
                ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
                ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
                ->join("master_service_type", "master_service_type.id", "services.service_type")
                ->leftJoin("users", "users.id", "services.assigned_to")
                ->leftJoin("employees", "employees.EMP_ID", "services.assigned_to")
                ->leftJoin("master_designation", "master_designation.id", "employees.EMP_Designation")
                ->leftJoin("contracts", "contracts.CNRT_ID", "services.contract_id")
                ->leftJoin("master_contract_type", "master_contract_type.id", "contracts.CNRT_Type")
                ->leftJoin("customer_sites", "customer_sites.id", "contracts.CNRT_Site")
                ->leftJoin("master_site_area", "master_site_area.id", "customer_sites.AreaName")
                ->leftJoin("service_under_product", "service_under_product.serviceId", "services.id")
                ->where("services.id", $id)->first();
            if ($service) {
                $service->serviceDate = date('d-M-Y h:i a', strtotime($service->service_date));
                $service->StartDate = $service->accepted_datetime != null ? date('d-M-Y', strtotime($service->accepted_datetime)) : '';
                $service->CompletionDate = $service->resolved_datetime = null ? date('d-M-Y', strtotime($service->resolved_datetime)) : '';
                $service->area_name = $this->GetServiceAreaName($service->areaId);
                // $service->productName = $this->getProductName($id,$service);
            }


        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(["success" => false, "service" => []]);
        }
        return response()->json(["success" => true, "service" => $service]);
    }
    public function GetServiceAreaName($areaId)
    {

        $areaName = "";
        try {
            $area = AreaName::find($areaId);
            $areaName = $area->SiteAreaName;

        } catch (Exception $e) {

        }
        return $areaName;

    }
    public function AddServiceCallAccessory(Request $request)
    {

        try {
            $isInsert = 0;
            // DB::beginTransaction();
            if (isset($request->sparepart)) {
                $products = $request->sparepart;
                if (sizeof($products) > 0) {
                    foreach ($products as $product) {
                        if (isset($product['service_id'])) {
                            $serviceAcc = ServiceAccessory::create([
                                'service_id' => $product['service_id'],
                                'accessory_id' => $product['productId'],
                                'given_qty' => $product['quantity'],
                                'price' => $product['price'],
                                'Is_Paid' => 0,
                            ]);
                            if ($serviceAcc) {
                                $isInsert = 1;
                            }
                        }


                    }
                }

            }
            if ($isInsert == 1) {
                // DB::commit();
                return response()->json(["success" => true, "message" => "accessory added."]);
            } else {
                //DB::rollback();
                return response()->json(["success" => false, "message" => "action failed, try again."]);
            }
        } catch (Illuminate\Database\QueryException $ex) {
            //DB::rollback();
            // DB::commit();
            return response()->json(["success" => false, "message" => "11action failed, try again."]);
        }

    }
    public function update(Request $request, Service $service)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'issue_type' => "required",
                'service_type' => "required",
                'service_priority' => "required"
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors("all * marked fields required, check and try again.");
            // return response()->json(["success" => false, "message" => "", "validation_error" => $validator->errors()]);
        }
        try {
            $userId = $request->userId;
            $check = Service::where("id", $service->id)->where("service_no", $service->service_no)->count();
            if ($check > 0) {
                $update = Service::where("id", $service->id)->update([
                    'service_date' => date('Y-m-d H:i:s', strtotime($request->service_date)),
                    'contact_person' => $request->contact_person,
                    'contact_number1' => $request->contact_number1,
                    'contact_number2' => $request->contact_number2,
                    'contact_email' => $request->contact_email,
                    'areaId' => $request->areaId,
                    'site_google_link' => $request->site_google_link,
                    'site_address' => $request->site_address,
                    'issue_type' => $request->issue_type,
                    'service_type' => $request->service_type,
                    'service_priority' => $request->service_priority,
                    'service_note' => $request->service_note,
                    'product_sn' => $request->product_sn,
                    'product_description' => $request->product_description,
                    'product_type' => $request->product_type,
                    'product_name' => $request->product_name,
                ]);
                if ($update) {
                    if (Auth::user()->role == 3) {
                        Service::where('services.id', $service->id)->update(["notification_flag" => 1]);
                    }
                    $this->SendNewCallMail($service);
                    $userId = Auth::user()->id;
                    $history = ServiceHistory::create([
                        'service_id' => $service->id,
                        'status_id' => 1,
                        'user_id' => $userId,
                        'reason_id' => 1,
                        'action_description' => "Service details updated",
                    ]);
                    if ($history) {
                        DB::commit();
                        return Redirect("services")->with("success", "Service Update!");
                        // return response()->json(['success' => true, 'message' => 'Service Created.']);
                    } else {
                        DB::rollBack();
                        return back()
                            ->withInput()
                            ->withErrors("Action failed, try again0.");
                        //return response()->json(['success' => true, 'message' => 'Action failed, try again.']);
                    }
                } else {
                    return back()
                        ->withInput()
                        ->withErrors("Action failed, try again1.");
                }
            } else {
                return back()
                    ->withInput()
                    ->withErrors("Action failed, try again2.");
            }




        } catch (Exception $ex) {
            DB::commit();
            return back()
                ->withInput()
                ->withErrors("Action failed, try again." . $ex->getMessage());
        }

    }
    public function Print(Request $request, Service $service)
    {

        $services = Service::select("*", "services.id as service_id")
            ->join("master_service_status", "master_service_status.Status_Id", "services.service_status")
            ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
            ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
            ->join("master_service_type", "master_service_type.id", "services.service_type")
            ->leftJoin("master_site_area", "master_site_area.id", "services.areaId")
            ->join("clients", "clients.CST_ID", "services.customer_id")
            ->leftJoin("employees", "employees.Emp_ID", "services.assigned_to")
            ->where('services.id', $service->id)->first();
// dd($services);
        $product = ContractUnderProduct::where('contract_under_product.id', $service->product_id)->leftJoin("master_product_type", "master_product_type.id", "contract_under_product.product_type")->first();
        $contract = Contract::leftJoin("master_contract_type", "master_contract_type.id", "contracts.CNRT_Type")
            ->leftJoin("master_site_type", "master_site_type.id", "contracts.CNRT_SiteType")->where("CNRT_ID", $service->contract_id)->first();
        $timeline = ServiceHistory::leftJoin("master_service_status", "master_service_status.Status_Id", "service_action_history.status_id")
            ->leftJoin("master_service_sub_status", "master_service_sub_status.Sub_Status_Id", "service_action_history.sub_status_id")
            ->where("service_id", $service->id)
            ->orderBy("service_action_history.id", "DESC")
            ->get();
        $status_options = "<option value=''>Select Status</option>";
        $status = ServiceStatus::where("flag", 1)->get();
        foreach ($status as $st) {
            $selected = "";
            $sub_status = ServiceSubStatus::where("status_id", $st->Status_Id)->get();
            if ($services->service_status == $st->Status_Id) {
                $selected = "selected";
            }
            if (Auth::user()->role == 3 && $st->Status_Id == 5) {
                //     $status_options .= "<option data-sub_status='" . $sub_status . "' value=" . $st->Status_Id . " " . $selected . ">" . $st->Status_Name . "</option>";

            } else {
                $status_options .= "<option data-sub_status='" . $sub_status . "' value=" . $st->Status_Id . " " . $selected . ">" . $st->Status_Name . "</option>";
            }
        }
        $employees = Employee::where(["EMP_Status"=>1,"Access_Role"=>4,'deleted_at'=>null])->get();
        $employee_options = "<option value=''>Select Employee</option>";
        foreach ($employees as $employee) {
            $selected = "";
            if ($services->assigned_to == $employee->EMP_ID) {
                $selected = "selected";
            }
            $employee_options .= "<option value=" . $employee->EMP_ID . " " . $selected . ">" . $employee->EMP_Name . "</option>";
        }   
        // dd($status_options);

        $dc_products = ServiceDc::select(["dc_type.*", "clients.*", "services.*", "service_dc.id as dcp_id", "service_dc.*"])
            ->join("services", "services.id", "service_dc.service_id")
            ->leftJoin("dc_type", "dc_type.id", "service_dc.dc_type")
            ->leftJoin("clients", "clients.CST_ID", "services.customer_id")
            ->where("service_dc.service_id", $service->id)->get();
        // dd($dc_products);
        return view("services.print", [
            "product" => $product,
            "service" => $services,
            "service_id" => $service->id,
            "dc_products" => $dc_products,
            "contract" => $contract,
            'timeline' => $timeline,
            "employee_options" => $employee_options,
            'status_options' => $status_options,
        ]);
    }
    public function view(Request $request, Service $service)
    {
        // dd(config('app.timezone'));
        if (Auth::user()->role == 1) {
            Service::where('services.id', $service->id)->update(["notification_flag" => 0]);
        }
        $services = Service::select("*", "services.id as service_id")
            ->join("master_service_status", "master_service_status.Status_Id", "services.service_status")
            ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
            ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
            ->join("master_service_type", "master_service_type.id", "services.service_type")
            ->leftJoin("master_site_area", "master_site_area.id", "services.areaId")
            ->join("clients", "clients.CST_ID", "services.customer_id")
            ->leftJoin("employees", "employees.Emp_ID", "services.assigned_to")
            ->where('services.id', $service->id)->first();

        $product = ContractUnderProduct::where('contract_under_product.id', $service->product_id)->leftJoin("master_product_type", "master_product_type.id", "contract_under_product.product_type")->first();
        $contract = Contract::leftJoin("master_contract_type", "master_contract_type.id", "contracts.CNRT_Type")
            ->leftJoin("master_site_type", "master_site_type.id", "contracts.CNRT_SiteType")->where("CNRT_ID", $service->contract_id)->first();
        $timeline = ServiceHistory::leftJoin("master_service_status", "master_service_status.Status_Id", "service_action_history.status_id")
            ->leftJoin("master_service_sub_status", "master_service_sub_status.Sub_Status_Id", "service_action_history.sub_status_id")
            ->where("service_id", $service->id)
            ->orderBy("service_action_history.id", "DESC")
            ->get();
        $status_options = "<option value=''>Select Status</option>";
        $status = ServiceStatus::where("flag", 1)->get();
        foreach ($status as $st) {
            $selected = "";
            $sub_status = ServiceSubStatus::where("status_id", $st->Status_Id)->get();
            if ($services->service_status == $st->Status_Id) {
                $selected = "selected";
            }
            if (Auth::user()->role == 3 && ($st->Status_Id == 6|| $st->Status_Id == 5)) {
                //     $status_options .= "<option data-sub_status='" . $sub_status . "' value=" . $st->Status_Id . " " . $selected . ">" . $st->Status_Name . "</option>";

            } else {
                $status_options .= "<option data-sub_status='" . $sub_status . "' value=" . $st->Status_Id . " " . $selected . ">" . $st->Status_Name . "</option>";
            }
        }
        $employees = Employee::where(["EMP_Status"=>1,"Access_Role"=>4,'deleted_at'=>null])->get();
        $employee_options = "<option value=''>Select Employee</option>";
        foreach ($employees as $employee) {
            $selected = "";
            if ($services->assigned_to == $employee->EMP_ID) {
                $selected = "selected";
            }
            $employee_options .= "<option value=" . $employee->EMP_ID . " " . $selected . ">" . $employee->EMP_Name . "</option>";
        }
        // dd($status_options);

        $dc_products = ServiceDc::select(["dc_type.*", "clients.*", "services.*", "service_dc.id as dcp_id", "service_dc.*"])
            ->join("services", "services.id", "service_dc.service_id")
            ->leftJoin("dc_type", "dc_type.id", "service_dc.dc_type")
            ->leftJoin("clients", "clients.CST_ID", "services.customer_id")
            ->where("service_dc.service_id", $service->id)->get();

        return view("services.view", [
            "product" => $product,
            "service" => $services,
            "service_id" => $service->id,
            "dc_products" => $dc_products,
            "contract" => $contract,
            'timeline' => $timeline,
            "employee_options" => $employee_options,
            'status_options' => $status_options,
        ]);
    }
    public function edit(Request $request, Service $service)
    {
        $services = Service::select("*", "services.id as service_id")
            ->join("master_service_status", "master_service_status.Status_Id", "services.service_status")
            ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
            ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
            ->join("master_service_type", "master_service_type.id", "services.service_type")
            ->join("clients", "clients.CST_ID", "services.customer_id")
            ->leftJoin("users", "users.id", "services.assigned_to")
            ->where('services.id', $service->id)->first();

        $product = ContractUnderProduct::where('contract_under_product.id', $service->product_id)->leftJoin("master_product_type", "master_product_type.id", "contract_under_product.product_type")->first();
        $contract = Contract::leftJoin("master_contract_type", "master_contract_type.id", "contracts.CNRT_Type")
            ->leftJoin("master_site_type", "master_site_type.id", "contracts.CNRT_SiteType")->where("CNRT_ID", $service->contract_id)->get();


        return view(
            'services.create',
            [
                'issue_type' => IssueType::all(),
                'service_type' => ServiceType::all(),
                'priorities' => Priority::all(),
                'clients' => Client::all(),
                'serviceType' => ServiceType::all(),
                'update' => true,
                'service_no' => $service->service_no,
                'contractScheduleService' => new ContractScheduleService(),
                'customer_id' => 0,
                'service' => $services,
                'sitelocation' => AreaName::all(),
            ]
        );
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                "service_no" => "required",
                "service_date" => "required",
                'customer_id' => "required",
                'contact_person' => "required",
                'contact_number1' => "required",
                'service_type' => "required",
                'issue_type' => "required",
                'service_priority' => "required",
                'contractserviceid' => "required",
            ]
        );
        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator->errors());
            // return response()->json(["success" => false, "message" => "all * marked fields required.", "validation_error" => $validator->errors()]);
        }
        try {
            $userId = Auth::user()->id;
            $check = Service::where("service_no", $request->service_no)->count();
            if ($check == 0) {
                DB::beginTransaction();
                $service = Service::create([
                    'service_no' => $request->service_no,
                    'service_date' => date('Y-m-d H:i:s', strtotime($request->service_date)),
                    'customer_id' => $request->customer_id,
                    'contract_id' => $request->contract_id ?? 0,
                    'contact_person' => $request->contact_person,
                    'contact_number1' => $request->contact_number1,
                    'contact_number2' => $request->contact_number2,
                    'contact_email' => $request->contact_email,
                    'areaId' => $request->areaId,
                    'site_google_link' => $request->site_google_link,
                    'issue_type' => $request->issue_type,
                    'service_type' => $request->service_type,
                    'service_priority' => $request->service_priority,
                    'product_id' => $request->product_id,
                    'product_name' => $request->product_name,
                    'product_type' => $request->product_type,
                    'product_description' => $request->product_description,
                    'service_status' => 1,
                    'service_category' => isset($request->contract_id) && $request->contract_id == 0 ? 2 : 1,
                    'service_note' => $request->service_note,
                    'product_sn' => $request->product_sn,
                ]);
                if ($service) {
                    $history = ServiceHistory::create([
                        'service_id' => $service->id,
                        'status_id' => 1,
                        'user_id' => $userId,
                        'reason_id' => 1,
                        'action_description' => "New Ticket Created.",
                    ]);
                    if ($history) {
                        if ($request->contractserviceid > 0) {

                            $contractservice = ContractScheduleService::where(['id' => $request->contractserviceid])->first();
                            if (!empty($contractservice)) {
                                $contractservice->Service_Call_Id = $service->id;
                                $contractservice->Schedule_Status = 2;
                                $contractservice->save();
                            } else {
                                DB::rollBack();
                                return back()
                                    ->withInput()
                                    ->withErrors("Action failed, try again.");
                            }

                        }
                        DB::commit();
                        $this->SendNewCallMail($service);
                        return Redirect("services")->with("success", "Service added!");
                        // return response()->json(['success' => true, 'message' => 'Service Created.']);
                    } else {
                        DB::rollBack();
                        return back()
                            ->withInput()
                            ->withErrors("Action failed, try again.");
                        //return response()->json(['success' => true, 'message' => 'Action failed, try again.']);
                    }
                } else {
                    DB::rollBack();
                    return back()
                        ->withInput()
                        ->withErrors("Action failed, try again.");
                    // return response()->json(['success' => false, 'message' => 'Action failed, Try again.']);
                }
            } else {
                return back()
                    ->withInput()
                    ->withErrors('Dublicate service number.');
                // return response()->json(['success' => false, 'message' => 'Dublicate service number.']);
            }
        } catch (Exception $ex) {
            return back()
                ->withInput()
                ->withErrors($ex->getMessage());
            // return response()->json(['success' => false, 'message' => $ex->getMessage()]);
        }

    }
    public function SendNewCallMail($service)
    {
        try {
            $Customer = $this->GetCustomerId($service->customer_id);
            $mailsetting = MailSetting::where("id", 1)->first();
            $accountsetting = Account_Setting::where("id", 1)->first();
            $subject = "New Service Created";
            $body = "Dear " . $Customer['name'] . ",<br/><br/>";
            $body .= $mailsetting->call_register_template . "<br/><br/>";
            $body .= "Service No. : " . $service->service_no . "<br/>";
            $body .= "Service Date : " . date('d-m-Y', strtotime($service->service_date)) . "<br/>";
            $body .= "Service Type : " . $service->type_name . "<br/>";
            $body .= "Issue Type : " . $service->issue_name . "<br/>";

            $body .= $service->service_note . "<br/>";
            $body .= "<br/><br/>" . $accountsetting->mail_signature;
            $mail = new MailController;
            $mail->SendMail($Customer['CCP_Email'], $subject, $body);

        } catch (Exception $ex) {

        }

    }

    public function GetServiceNumber(Request $request)
    {

        $serviceId = "";
        $accountsetting = $this->GetAccountSettings($request);
        $call_ins = $accountsetting->serviceno_ins;

        if (!isset($call_ins)) {
            $call_ins = "Call";
        }

        $last = Service::latest()->first();
        if (is_null($last)) {
            $serviceId = $call_ins . "001";
        } else {
            $lastNumber = $last->service_no;
            $array = explode($call_ins, $lastNumber);
            $num = $array[1];
            $num = $num + 1;
            $serviceId = $call_ins . "00" . $num;
        }
        return $serviceId;

    }
    public function GetContractProductListService(Request $request)
    {
        $products = array();
        try {
            $Contract_ID = $request->Contract_ID;
            $products = ContractUnderProduct::where("contractId", $Contract_ID)->get();
            foreach ($products as $product) {
                $product->title = $product->product_name . "/" . $product->nrnumber;
                $product->value = $product->id;
                $product->Product_ID = $product->productId;
                $product->contractId = $Contract_ID;
            }
        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $products;
    }
    public function GetContractProductAccessory(Request $request)
    {
        $accessory = array();
        try {
            $Product_ID = $request->Product_ID;
            $Contract_ID = $request->Contract_ID;
            $accessory = ContractBaseAccessory::join("product_accessory", "product_accessory.PA_ID", "contract_base_accessory.accessoryId")
                ->where("contract_base_accessory.productId", $Product_ID)
                ->where("contract_base_accessory.contractId", $Contract_ID)->get();
            $accessory->title = "Select Accessory";
            $accessory->value = 0;
            foreach ($accessory as $acc) {
                $acc->title = $acc->PA_Name;
                $acc->value = $acc->PA_ID;

            }
        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $accessory;
    }
    public function GetContractProductAccessoryById(Request $request)
    {
        $accessory = array();
        try {
            $Product_ID = $request->Product_ID;
            $Accessory_ID = $request->Accessory_ID;
            $Contact_ID = $request->Contact_ID;
            $accessory = ContractBaseAccessory::where("productId", $Product_ID)
                ->where("contractId", $Contact_ID)
                ->where("accessoryId", $Accessory_ID)->first();

        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $accessory;
    }
    public function GetAllProductList(Request $request)
    {
        $products = array();
        try {
            $products = Product::join("master_product_type", "master_product_type.id", "products.type")
                ->where("Status", 1)->get();
            foreach ($products as $product) {
                $product->title = $product->Product_Name;
                $product->value = $product->Product_ID;
                $product->price = $product->Product_Price;
            }

        } catch (Illuminate\Database\QueryException $ex) {
            return $products;
        }
        return $products;
    }
    public function GetAllProductAccessory(Request $request)
    {
        $accessory = array();
        try {
            $Product_ID = $request->Product_ID;
            $accessory = Product_Accessory::where("Product_ID", $Product_ID)->get();
            foreach ($accessory as $acc) {
                $acc->title = $acc->PA_Name;
                $acc->value = $acc->PA_ID;
            }

        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $accessory;
    }
    public function GetAllProductAccessoryById(Request $request)
    {
        $accessory = array();
        try {
            $Product_ID = $request->Product_ID;
            $Accessory_ID = $request->Accessory_ID;
            $accessory = Product_Accessory::where("Product_ID", $Product_ID)->where("PA_ID", $Accessory_ID)->first();

        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $accessory;
    }

    public function GetCustomerList(Request $request)
    {
        $Customer = array();
        try {

            $Customer = Client::where("CST_Status", 1)->get();
            foreach ($Customer as $c) {
                $c->title = $c->CST_Name;
                $c->id = $c->CST_ID;
            }
        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $Customer;
    }
    public function GetCustomerById(Request $request)
    {
        $Customer = array();
        try {
            $CustomerId = $request->customer_id;
            $Customer = Client::where("CST_ID", $CustomerId)->first();

        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $Customer;
    }

    public function GetProductByContractId(Request $request)
    {
        $products = array();
        try {
            $products = Product::where("Status", 1)->get();
            foreach ($products as $product) {
                $product->title = $product->Product_Name;
                $product->value = $product->Product_ID;
                $product->price = $product->Product_Price;
            }

        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $products;
    }
    public function GetProductAccessory(Request $request)
    {
        $accessory = array();
        try {
            $Product_ID = $request->Product_ID;
            $accessory = Product_Accessory::where("Product_ID", $Product_ID)->get();
            foreach ($accessory as $acc) {
                $acc->label = $acc->PA_Name;
                $acc->id = $acc->PA_ID;
            }

        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $accessory;
    }

    public function GetPriority()
    {
        $priority = array();
        try {

            $priority = Priority::all();
            foreach ($priority as $p) {
                $p->title = $p->priority_name;
                $p->id = $p->id;
            }

        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $priority;

    }
    public function GetServiceType()
    {
        $servicetype = array();
        try {
            $servicetype = ServiceType::all();
            foreach ($servicetype as $type) {
                $type->title = $type->type_name;
                $type->id = $type->id;
            }
        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $servicetype;
    }

    public function GetIssueType()
    {
        $issuetype = array();
        try {
            $issuetype = IssueType::all();
            foreach ($issuetype as $type) {
                $type->title = $type->issue_name;
                $type->id = $type->id;
            }

        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $issuetype;
    }









}

