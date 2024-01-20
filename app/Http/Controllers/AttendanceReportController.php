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
use App\Models\ServiceFieldReport;
use App\Models\Attendance;
use App\Models\UserLeave;
use App\Models\Visits;
use App\Models\LocationHistory;
use Carbon\Carbon;


class AttendanceReportController extends Controller
{

    function GetLocationReport(Request $request){
        try{ 
            $fromdate =$request->fromdate;
            $todate =$request->todate;
            $EMP_ID = $request->EMP_ID;
            $locationHistory = LocationHistory::join("employees","employees.EMP_ID","employee_location_history.User_ID")
                ->whereBetween(DB::raw('DATE_FORMAT(employee_location_history.created_at, "%Y-%m-%d")'),[$fromdate,$todate])
                ->where("employee_location_history.last_lang","!=","null")
                ->where("employee_location_history.last_long","!=","null")      
                ->get();
            foreach($locationHistory as $location){
                if($location->last_lang == "null" || $location->last_long == "null"){
                    $location->Map_Link = null;
                } else {
                    $location->Map_Link = "https://maps.google.com/?q=".$location->last_lang.",".$location->last_long."&z=18";
                }
                
            }    
            return response()->json(['success' => true, 'message'=> $todate.'--'.$fromdate,'locationHistory'=>$locationHistory]);
                
        }catch(Exception $e){
            return response()->json(['success' => false, 'message'=> $ex->errorInfo,'locationHistory'=>[]]); 
        }
    }
    function GetVisitsReport(Request $request){

        $todate = $request->todate;
        $fromdate = $request->fromdate;
        $visits = array();
        if($request->EMP_ID == 0){
            $visits = Visits::join("employees","employees.EMP_ID","visits.User_ID")
                ->leftJoin("master_visit_type","master_visit_type.id","visits.visitType")
                ->leftJoin("master_visit_status","master_visit_status.id","visits.visitStatus")
                ->whereBetween(DB::raw('DATE_FORMAT(visits.visitDate, "%Y-%m-%d")'),[$fromdate,$todate])
                ->get(["*","visits.id as visit_id","master_visit_status.status_name as status_title","master_visit_type.type_name as type_title"]);
                foreach($visits as $visit){
                    $visit->edit = "/visit/edit-employee-visit?id=".$visit->visit_id;
                }
        } else {
            $visits = Visits::join("employees","employees.EMP_ID","visits.User_ID")
            ->leftJoin("master_visit_type","master_visit_type.id","visits.visitType")
            ->leftJoin("master_visit_status","master_visit_status.id","visits.visitStatus")
            ->where("User_ID",$request->EMP_ID)
            ->whereBetween(DB::raw('DATE_FORMAT(visits.visitDate, "%Y-%m-%d")'),[$fromdate,$todate])
            ->get(["*","visits.id as visit_id","master_visit_status.status_name as status_title","master_visit_type.type_name as type_title"]);
            foreach($visits as $visit){
                $visit->edit = "/visit/edit-employee-visit?id=".$visit->visit_id;
            }
        }
        
        return response()->json(["success" => true, "message"=>"","visits"=>$visits]);
    }
    public function GetLeaveReport(Request $request){
        try{ 
            $fromdate =$request->fromdate;
            $todate =$request->todate;
            $EMP_ID = $request->EMP_ID;
            if($EMP_ID == 0){
                $userLeave = UserLeave::join("employees","employees.EMP_ID","user_leave.User_ID")
                    ->whereBetween(DB::raw('DATE_FORMAT(user_leave.created_at, "%Y-%m-%d")'),[$fromdate,$todate])
                    ->get();
                foreach($userLeave as $leave){
                    $fromd = Carbon::parse($leave->From_Date);
                    $tod = Carbon::parse($leave->To_Date);
                    $diff = $fromd->diffInDays($tod);
                    $leave->days = $diff;   
                }    
            } else {
                $userLeave = UserLeave::join("employees","employees.EMP_ID","user_leave.User_ID")
                ->whereBetween(DB::raw('DATE_FORMAT(user_leave.created_at, "%Y-%m-%d")'),[$fromdate,$todate])
                ->where("employees.EMP_ID",$EMP_ID)      
                ->get();
            foreach($userLeave as $leave){
                $fromd = Carbon::parse($leave->From_Date);
                $tod = Carbon::parse($leave->To_Date);
                $diff = $fromd->diffInDays($tod);
                $leave->days = $diff;   
            }    
            }
            
            return response()->json(['success' => true, 'message'=> '','leaves'=>$userLeave]);
        }catch(Exception $e){
            return response()->json(['success' => false, 'message'=> $ex->errorInfo,'leaves'=>[]]); 
        }
        

    }
    function GetEmployeeAttendanceReport(Request $request){
        $attendance= array();    
        $EMP_ID = $request->EMP_ID;
        
         try {
            if($EMP_ID != 0){
                $attendance = Attendance::join("employees","employees.EMP_ID","attendance.User_ID")
                ->where("User_ID",$EMP_ID)
                ->orderBy("attendance.Att_Date","ASC")
                ->get();
                if(!is_null($attendance)){
                    foreach($attendance as $att){
                        
                        $att->start = date($att->Att_Date);
                        $att->end = date($att->Att_Date);
                        $intime = $att->Att_In!=null ? Carbon::parse($att->Att_In):null;
                        $outtime = $att->Att_Out !=null ?  Carbon::parse($att->Att_Out) : null;
                        $att_intime = $att->Att_In!=null ?  Carbon::parse(date($att->Att_In))->format("h:i A"): "00:00";
                        $att_outtime =  $att->Att_Out !=null ?  Carbon::parse(date($att->Att_Out))->format("h:i A"): "00:00";
                        $totalHours = $att->Att_In!=null ? "Hours: ".$intime->diff($outtime)->format('%H:%I'):"Hours:00:00";
                        $att->title = "In: ".$att_intime."\nOut: ".$att_outtime."\n".$totalHours;
                    }
                }
            } 
           
            } catch (Illuminate\Database\QueryException $ex){
                return response()->json(['success' => false, 'message'=> $ex->errorInfo,'attendance'=>[]]); 
            }
            return response()->json(['success' => true, 'message'=> 'EMP_ID:'.$EMP_ID,'attendance'=>$attendance]);  
    }
    function GetServiceCount($todate,$fromdate,$empId,$contract,$serviceType,$issueType,$status){

        
        $services = Service::
          join("master_service_status","master_service_status.Status_Id","services.service_status")
        ->join("master_service_priority","master_service_priority.id","services.service_priority")
        ->join("master_issue_type","master_issue_type.id","services.issue_type")
        ->join("master_service_type","master_service_type.id","services.service_type")
        ->join("customers","customers.CST_ID","services.customer_id")
        ->leftJoin("users","users.id","services.assigned_to")
        ->whereBetween(DB::raw('DATE_FORMAT(services.service_date, "%Y-%m-%d")'),[$todate,$fromdate])
        
        ->when($issueType!=0,function($query) use ($issueType){
            return $query->where('services.issue_type',$issueType);
        })
        ->when($serviceType!=0,function($query) use ($serviceType){
            return $query->where('services.service_type',$serviceType);
        })
        ->when($contract==0,function($query) use ($contract){
            return $query->where('services.contract_id',0);
        })
        ->when(($contract!=0 && $contract!=""),function($query) use ($contract){
            return $query->where('services.contract_id',">",1);
        })
        ->when($empId!="",function($query) use ($empId){
            return $query->where('services.assigned_to',$empId);
        })
        ->when($status!="",function($query) use ($status){
            return $query->where('services.service_status',$status);
        })
        ->get(["customers.*","services.id as service_id",
            "users.name as assignedName","users.name","master_service_type.*",
            "master_issue_type.*","services.*","master_service_status.*",
            "master_service_priority.*"]);
      if(is_null($services)){
        return 0;
      }  
      return count($services);

    }
    public function GetAnalysisReport(Request $request){


        $todate = $request->todate;
        $fromdate = $request->fromdate;
        $employees =  Employee::orderby("EMP_ID",'ASC')->get();

        $employee = array();
        $employeeData = array();
        foreach($employees as $emp){
            array_push($employee,$emp->EMP_Name);
            $count = $this->GetServiceCount($todate,$fromdate,$emp->EMP_ID,"","","","");
            array_push($employeeData,$count);
        }
        
        
        $contractType = array("Contracted","Non Contracted");
        $contractTypeData = array(15,10);
        $countContracted = $this->GetServiceCount($todate,$fromdate,"",1,"","","");
        $countNonContracted = $this->GetServiceCount($todate,$fromdate,"",0,"","","");

        $serviceType = array();
        $serviceTypeData = array();

        $serviceTypes =  ServiceType::orderby("id",'ASC')->get();
        foreach($serviceTypes as $st){
            array_push($serviceType,$st->type_name);
            $count = $this->GetServiceCount($todate,$fromdate,"","",$st->id,"","");
            array_push($serviceTypeData,$count);
        }
        
        $issueType = array();
        $issueTypeData = array();
        
        $issueTypes =  IssueType::orderby("id",'ASC')->get();
        foreach($issueTypes as $it){
            array_push($issueType,$it->issue_name);
            $count = $this->GetServiceCount($todate,$fromdate,"","","",$it->id,"");
            array_push($issueTypeData,$count);
        }
        $countArray = array();
        $serviceStatus =  ServiceStatus::orderby("Status_Id",'ASC')->get();
        foreach($serviceStatus as $ss){
            $count = $this->GetServiceCount($todate,$fromdate,"","","","",$ss->Status_Id);
            //$obj = ."=>".$count;
            $countArray[$ss->Status_Name]=$count;
        }
        
        
        
        return response()->json(["success" => true, 
        "employee"=>$employee,
        "employeeData"=>$employeeData,
        "contractType"=>$contractType,
        "contractTypeData"=>$contractTypeData,
        "serviceType"=>$serviceType,
        "serviceTypeData"=>$serviceTypeData,
        "issueType"=>$issueType,
        "issueTypeData"=>$issueTypeData,
        "countArray"=>$countArray,]);
        
    }
    public function GetStatusListAll(Request $request) {

        $status = ServiceStatus::where("flag","!=","3")->get();
        return $status;

    }
    public function GetServicePaymentReportByService(Request $request){
        $customerId=$request->customerId;
        $paymentMode=$request->paymentMode;
        $todate = $request->todate;
        $fromdate = $request->fromdate;
        
        $services = array();
        if($todate=="" || $fromdate == ""){
            $services = ServiceFieldReport::
            join("services","services.id","service_fieldreport.ServiceId")
            ->join("master_service_status","master_service_status.Status_Id","services.service_status")
        ->join("master_service_priority","master_service_priority.id","services.service_priority")
        ->join("master_issue_type","master_issue_type.id","services.issue_type")
        ->join("master_service_type","master_service_type.id","services.service_type")
        ->join("customers","customers.CST_ID","services.customer_id")
        ->when($customerId!=0,function($query) use ($customerId){
            return $query->where('customers.CST_ID',$customerId);
        })
        ->when($paymentMode!="",function($query) use ($paymentMode){
            return $query->where('service_fieldreport.PaymentMode',$paymentMode);
        })
        
        ->orderby("services.updated_at","DESC")
        ->get(["service_fieldreport.*","services.*","customers.*","services.id as service_id","master_service_type.*","master_issue_type.*","services.*","master_service_status.*","master_service_priority.*"]);
        foreach($services as $service){
            $service->View = "/service/view-service?id=".$service->service_id;
        }
        } else {
            $services = ServiceFieldReport::
            join("services","services.id","service_fieldreport.ServiceId")
            ->join("master_service_status","master_service_status.Status_Id","services.service_status")
        ->join("master_service_priority","master_service_priority.id","services.service_priority")
        ->join("master_issue_type","master_issue_type.id","services.issue_type")
        ->join("master_service_type","master_service_type.id","services.service_type")
        ->join("customers","customers.CST_ID","services.customer_id")
        ->leftJoin("users","users.id","services.assigned_to")
        ->whereBetween(DB::raw('DATE_FORMAT(service_fieldreport.payment_date, "%Y-%m-%d")'),[$todate,$fromdate])
        ->when($customerId!=0,function($query) use ($customerId){
            return $query->where('customers.CST_ID',$customerId);
        })
        ->when($paymentMode!="",function($query) use ($paymentMode){
            return $query->where('service_fieldreport.PaymentMode',$paymentMode);
        })
        ->orderby("services.updated_at","DESC")
        ->get(["service_fieldreport.*","services.*","customers.*","services.id as service_id","master_service_type.*","master_issue_type.*","services.*","master_service_status.*","master_service_priority.*"]);
        
        }
        
        return $services;
    }
    public function GetCustomerReport(Request $request){

        $customers= array();    
        $area = $request->area;
        $refBy = $request->refBy;
        
         try {
            // $customers = Customer::leftJoin("employees","employees.EMP_ID","customers.Ref_Employee")
            // ->when($refBy!=0,function($query) use ($refBy){
            //     return $query->where('customers.Ref_Employee',$refBy);
            // })
            // ->get();

            $customers = Customer::leftJoin("customer_sites","customer_sites.CustomerId","customers.CST_ID")
            ->leftJoin("employees","employees.EMP_ID","customers.Ref_Employee")
            ->leftJoin("master_site_area","master_site_area.id","customer_sites.AreaName")
            ->when($refBy!=0,function($query) use ($refBy){
                return $query->where('customers.Ref_Employee',$refBy);
            })
            ->when($area!=0,function($query) use ($area){
                return $query->where('customer_sites.AreaName',$area);
            })
            ->get();
        } catch (Illuminate\Database\QueryException $ex){
            return $ex->errorInfo;
        }
        return $customers;

    }
    public function GetContractReport(Request $request){

        $contracts= array();    
        $customerId = $request->customerId;
        $contractStatus = $request->contractStatus;
        $contractType = $request->contractType;
        
         try {
            $contracts = Contract::join("master_contract_type","master_contract_type.id","contracts.CNRT_Type")
            ->join("master_site_type","master_site_type.id","contracts.CNRT_SiteType")
            ->join("master_contract_status","master_contract_status.id","contracts.CNRT_Status")
            ->join("customers","customers.CST_ID","contracts.CNRT_CustomerID")
            ->join("customer_sites","customer_sites.id","contracts.CNRT_Site")
            ->when($customerId!=0,function($query) use ($customerId){
                return $query->where('customers.CST_ID',$customerId);
            })
            ->when($contractType!=0,function($query) use ($contractType){
                return $query->where('contracts.CNRT_Type',$contractType);
            })
            ->when($contractStatus!=0,function($query) use ($contractStatus){
                return $query->where('contracts.CNRT_Status',$contractStatus);
            })
            ->get();
            foreach($contracts as $contract) {
                $contract->Edit = "/contract/edit-contract?id=".$contract->CNRT_ID;
                $contract->View = "/contract/view-contract?CNRT_ID=".$contract->CNRT_ID;
            }
            
        } catch (Illuminate\Database\QueryException $ex){
            return $ex->errorInfo;
        }
        return $contracts;

    }

    public function GetServiceCallReport(Request $request){

            
            $customerId=$request->customerId;
            $contractId=$request->contractId;
            $employeeId=$request->employeeId;
            $todate = $request->todate;
            $fromdate = $request->fromdate;
            $services = array();
            if($todate=="" || $fromdate == ""){
                $services = Service::
                join("master_service_status","master_service_status.Status_Id","services.service_status")
            ->join("master_service_priority","master_service_priority.id","services.service_priority")
            ->join("master_issue_type","master_issue_type.id","services.issue_type")
            ->join("master_service_type","master_service_type.id","services.service_type")
            ->join("customers","customers.CST_ID","services.customer_id")
            ->leftJoin("users","users.id","services.assigned_to")
            ->when($customerId!=0,function($query) use ($customerId){
                return $query->where('customers.CST_ID',$customerId);
            })
            ->when($contractId!=0,function($query) use ($contractId){
                return $query->where('services.contract_id',$contractId);
            })
            ->when($employeeId!=0,function($query) use ($employeeId){
                return $query->where('services.assigned_to',$employeeId);
            })
            ->orderby("services.updated_at","DESC")
            ->get(["customers.*","services.id as service_id","users.name as assignedName","users.name","master_service_type.*","master_issue_type.*","services.*","master_service_status.*","master_service_priority.*"]);
            foreach($services as $service){
                $service->View = "/service/view-service?id=".$service->service_id;
            }
            } else {
                $services = Service::
                join("master_service_status","master_service_status.Status_Id","services.service_status")
            ->join("master_service_priority","master_service_priority.id","services.service_priority")
            ->join("master_issue_type","master_issue_type.id","services.issue_type")
            ->join("master_service_type","master_service_type.id","services.service_type")
            ->join("customers","customers.CST_ID","services.customer_id")
            ->leftJoin("users","users.id","services.assigned_to")
            ->whereBetween(DB::raw('DATE_FORMAT(services.service_date, "%Y-%m-%d")'),[$todate,$fromdate])
            ->when($customerId!=0,function($query) use ($customerId){
                return $query->where('customers.CST_ID',$customerId);
            })
            ->when($contractId!=0,function($query) use ($contractId){
                return $query->where('services.contract_id',$contractId);
            })
            ->when($employeeId!=0,function($query) use ($employeeId){
                return $query->where('services.assigned_to',$employeeId);
            })
            ->orderby("services.updated_at","DESC")
            ->get(["customers.*","services.id as service_id","users.name as assignedName","users.name","master_service_type.*","master_issue_type.*","services.*","master_service_status.*","master_service_priority.*"]);
            foreach($services as $service){
                $service->View = "/service/view-service?id=".$service->service_id;
            }
            }
            
            return $services;
    }
    public function GetServiceCallReportByService(Request $request){

            
        $customerId=$request->customerId;
        $serviceStatus=$request->serviceStatus;
        $serviceType=$request->serviceType;
        $todate = $request->todate;
        $fromdate = $request->fromdate;
        $employeeId=$request->engineerId;
        $services = array();
        if($todate=="" || $fromdate == ""){
            $services = Service::
            join("master_service_status","master_service_status.Status_Id","services.service_status")
        ->join("master_service_priority","master_service_priority.id","services.service_priority")
        ->join("master_issue_type","master_issue_type.id","services.issue_type")
        ->join("master_service_type","master_service_type.id","services.service_type")
        ->join("customers","customers.CST_ID","services.customer_id")
        ->leftJoin("users","users.id","services.assigned_to")
        ->when($customerId!=0,function($query) use ($customerId){
            return $query->where('customers.CST_ID',$customerId);
        })
        ->when($serviceStatus!=0,function($query) use ($serviceStatus){
            return $query->where('services.service_status',$serviceStatus);
        })
        ->when($serviceType!=0,function($query) use ($serviceType){
            return $query->where('services.service_type',$serviceType);
        })
        ->when($employeeId!=0,function($query) use ($employeeId){
            return $query->where('services.assigned_to',$employeeId);
        })
        ->orderby("services.updated_at","DESC")
        ->get(["customers.*","services.id as service_id","users.name as assignedName","users.name","master_service_type.*","master_issue_type.*","services.*","master_service_status.*","master_service_priority.*"]);
        foreach($services as $service){
            $service->View = "/service/view-service?id=".$service->service_id;
        }
        } else {
            $services = Service::
            join("master_service_status","master_service_status.Status_Id","services.service_status")
        ->join("master_service_priority","master_service_priority.id","services.service_priority")
        ->join("master_issue_type","master_issue_type.id","services.issue_type")
        ->join("master_service_type","master_service_type.id","services.service_type")
        ->join("customers","customers.CST_ID","services.customer_id")
        ->leftJoin("users","users.id","services.assigned_to")
        ->whereBetween(DB::raw('DATE_FORMAT(services.service_date, "%Y-%m-%d")'),[$todate,$fromdate])
        ->when($customerId!=0,function($query) use ($customerId){
            return $query->where('customers.CST_ID',$customerId);
        })
        ->when($serviceStatus!=0,function($query) use ($serviceStatus){
            return $query->where('services.service_status',$serviceStatus);
        })
        ->when($employeeId!=0,function($query) use ($employeeId){
            return $query->where('services.assigned_to',$employeeId);
        })
        ->when($serviceType!=0,function($query) use ($serviceType){
            return $query->where('services.service_type',$serviceType);
        })
        ->orderby("services.updated_at","DESC")
        ->get(["customers.*","services.id as service_id","users.name as assignedName","users.name","master_service_type.*","master_issue_type.*","services.*","master_service_status.*","master_service_priority.*"]);
        foreach($services as $service){
            $service->View = "/service/view-service?id=".$service->service_id;
        }
        }
        
        return $services;
}
      
    
}