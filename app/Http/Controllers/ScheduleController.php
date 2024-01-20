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
use Illuminate\Support\Facades\Hash;
use App\Models\ServiceType;
use App\Models\IssueType;
use App\Models\Service;
use App\Models\Priority;
use App\Models\ServiceAccessory;
use App\Models\ServiceHistory;
use App\Models\ActionReason;
use App\Models\ServiceStatus;
use Carbon\Carbon;


class ScheduleController extends Controller
{
    public function GetScheduleList(Request $request) {
        $contractsSchedule= array();    
         try {
            $todate = $request->todate;
            $fromdate = $request->fromdate;
            $dateFilter = $request->dateFilter;
            $today = date("Y-m-d");
            if($dateFilter == -1){
                $contractsSchedule = ContractScheduleModel::
                    join("contract_under_product","contract_under_product.id",
                        "contract_schedule_service.Accessory_Id")
                    ->join("contracts","contracts.CNRT_ID","contract_schedule_service.Contract_Id")
                    ->join("customers","customers.CST_ID","contracts.CNRT_CustomerID")
                    ->leftJoin("master_service_status","contract_schedule_service.Schedule_Status","master_service_status.Status_Id")
                    ->leftJoin("master_service_type","master_service_type.id","contract_schedule_service.serviceType")
                    ->leftJoin("master_issue_type","master_issue_type.id","contract_schedule_service.issueType")
                    ->where("isManaged",0)
                    ->where('contract_schedule_service.Schedule_Date',"<",$today)
                    ->get(["master_issue_type.*","master_service_type.*","contract_schedule_service.id as scheduleId",
                    "contract_schedule_service.*","contracts.*","customers.*","master_service_status.*"]);
                    foreach($contractsSchedule as $cs) {
                        $cs->View = "/service/view-service?id=".$cs->Service_Call_Id;   
                        if($cs->Service_Call_Id!=0){
                            $this->getManagedServiceStatus($cs);
                        }
                    }
                    
            } else 
            if($todate=="" || $fromdate == ""){
            $contractsSchedule = ContractScheduleModel::
            join("contract_under_product","contract_under_product.id",
            "contract_schedule_service.Accessory_Id")
            ->join("contracts","contracts.CNRT_ID","contract_schedule_service.Contract_Id")
            ->join("customers","customers.CST_ID","contracts.CNRT_CustomerID")
            ->leftJoin("master_service_status","contract_schedule_service.Schedule_Status","master_service_status.Status_Id")
            ->leftJoin("master_service_type","master_service_type.id","contract_schedule_service.serviceType")
            ->leftJoin("master_issue_type","master_issue_type.id","contract_schedule_service.issueType")
            ->where("isManaged",0)
            ->get(["master_issue_type.*","master_service_type.*","contract_schedule_service.id as scheduleId",
            "contract_schedule_service.*","contracts.*","customers.*","master_service_status.*"]);
            foreach($contractsSchedule as $cs) {
                $cs->View = "/service/view-service?id=".$cs->Service_Call_Id;   
                if($cs->Service_Call_Id!=0){
                    $this->getManagedServiceStatus($cs);
                }
            }
            } else {
              //  $startDate = Carbon::createFromFormat('Y-m-d', $fromdate);
          //  $endDate = Carbon::createFromFormat('Y-m-d', $todate);
            
            $contractsSchedule = ContractScheduleModel::
            join("contract_under_product","contract_under_product.id",
            "contract_schedule_service.Accessory_Id")
            ->join("contracts","contracts.CNRT_ID","contract_schedule_service.Contract_Id")
            ->join("customers","customers.CST_ID","contracts.CNRT_CustomerID")
            ->leftJoin("master_service_status","contract_schedule_service.Schedule_Status","master_service_status.Status_Id")
            ->leftJoin("master_service_type","master_service_type.id","contract_schedule_service.serviceType")
            ->leftJoin("master_issue_type","master_issue_type.id","contract_schedule_service.issueType")
            ->whereBetween('contract_schedule_service.Schedule_Date',[$fromdate,$todate])
            ->where("isManaged",0)
            ->get(["master_issue_type.*","master_service_type.*","contract_schedule_service.id as scheduleId",
            "contract_schedule_service.*","contracts.*","customers.*","master_service_status.*"]);
            foreach($contractsSchedule as $cs) {
                $cs->View = "/service/view-service?id=".$cs->Service_Call_Id;   
                if($cs->Service_Call_Id!=0){
                    $this->getManagedServiceStatus($cs);
                }
            }
            
            }
            
            
             
        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $contractsSchedule;
    }
    public function getManagedServiceStatus($cs){
        $statusCode = Service::
        join("master_service_status","master_service_status.Status_Id","services.service_status")
        ->where("id",$cs->Service_Call_Id)
        ->first();
        if($statusCode->id>0) {
            $cs->MStatusName = $statusCode->Status_Name;
            $cs->MStatusColor = $statusCode->status_color;
        }
        return $cs;
        
    }
}

