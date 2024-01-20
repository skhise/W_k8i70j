<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\DateTime;
use App\Models\User;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Contract;
use App\Models\Service;
use App\Models\ContractScheduleModel;
use App\Models\ContractStatus;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\UserLeave;
use App\Models\EmployeeStatus;

class DashboardController extends Controller {
    
    
    private $status_code    =        200;
    
    public function __construct() {
        
        
    }
    public function GetDashboard(Request $request){
        
        $customers=0;
        $contracts=0;
        $services=0;
        $employes=0;  
        $closed_ticket=0;          
        try{
            $customers = Customer::all()->where("CST_Status","1")->count();
            $contracts = Contract::all()->where("CNRT_Status","!=",0)->count();
            $services = Service::all()->count();
            $employes = Employee::join("master_designation","master_designation.id","employees.EMP_Designation")
            ->join("users","users.id","employees.EMP_ID")
            ->leftJoin("master_role_access","master_role_access.id","employees.Access_Role")
            ->where("EMP_Status",1)->count();
            
            return response()->json(["success"=>true, "message"=> '',
            "customers"=>$customers,"employees"=>$employes,
            "services"=>$services,"contracts"=>$contracts]);
        }catch(Illuminate\Database\QueryException $ex){
            return response()->json(["success"=>false, "message"=> '',
            "customers"=>$customers,"employees"=>$employes,
            "services"=>$services,"contracts"=>$contracts]);
        }
        
    }
    public function GetLatestServices(Request $request){

        $services = Service::
            join("master_service_status","master_service_status.Status_Id","services.service_status")
        ->join("master_service_priority","master_service_priority.id","services.service_priority")
        ->join("master_issue_type","master_issue_type.id","services.issue_type")
        ->join("master_service_type","master_service_type.id","services.service_type")
        ->join("customers","customers.CST_ID","services.customer_id")
        ->leftJoin("users","users.id","services.assigned_to")
        ->orderby("services.updated_at","DESC")
        ->limit(5)
        ->get(["customers.*","services.id as service_id","users.name as assignedName","users.name","master_service_type.*","master_issue_type.*","services.*","master_service_status.*","master_service_priority.*"]);
        foreach($services as $service){
            $service->View = "/service/view-service?id=".$service->service_id;
        }
        return $services;
    }


    public function GetDashboardAttendance(Request $request){
        
        $present=0;
        $absent=0;
        $leave=0;
        $ow = 0;
        $todayDate = date("Y-m-d");
        $today = date('Y-m-d', strtotime($todayDate));
        try{
            $present = Attendance::where("Att_Date",$today)->get()->count();
            $leave = UserLeave::where("From_Date",">=",$today)->where("From_Date","<=",$today)->get()->count();
            $employes = Employee::all()->count();
            $absent = $employes-($present+$leave+$ow);
            
            return response()->json(["success"=>true, "message"=> '',
            "present"=>$present,"absent"=>$absent,
            "leave"=>$leave,"employees"=>$employes,"ow"=>$ow]);
        }catch(Illuminate\Database\QueryException $ex){
            return response()->json(["success"=>true, "message"=> '',
            "present"=>$present,"absent"=>$absent,
            "leave"=>$leave,"employees"=>$employes,"ow"=>$ow]);
        }
        
    }
    public function GetLatestPunch(Request $request){

        $punch = Attendance::join("employees","employees.EMP_ID","attendance.User_ID")
        ->orderby("attendance.updated_at","DESC")
        ->limit(10)
        ->get();
       
        return $punch;
    }
    
    public function GetEmployeeData(Request $request) {
        
        $data = array();
        $todayDate = date("Y-m-d");
        $today = date('Y-m-d', strtotime($todayDate));
        $weekof = 0;
        $present = Attendance::where("Att_Date",$today)->get()->count();
        $leave = UserLeave::where("From_Date",">=",$today)->where("From_Date","<=",$today)->get()->count();
        $employes = Employee::all()->count();
        $absent = $employes-($present+$leave+$weekof);
        $weekof = 0;
        $d = [
            "name"=>'Present',
            "value"=>$present
        ];
        array_push($data,$d);
        $d = [
            "name"=>'Absent',
            "value"=>$absent
        ];
        array_push($data,$d);
        $d = [
            "name"=>'Leave',
            "value"=>$leave
        ];
        array_push($data,$d);
        $d = [
            "name"=>'Week Off',
            "value"=>$weekof
        ];
        array_push($data,$d);
        return $data;    

    }
    public function GetContractData(Request $request) {
        
        $data = array();
        $status = ContractStatus::all();
        foreach($status as $s){
            $count = Contract::where("CNRT_Status",$s->id)->count();
            $d = [
                "name"=>$s->contract_status_name,
                "value"=>$count
            ];
            array_push($data,$d);
        }
        return $data;    

    }
    public function  GetScheduleCount(){

        $todayDate = date("Y-m-d");
        $days7datetime = date('Y-m-d', strtotime("+7 days"));
        $overdue=0;
        $today = 0;
        $Tomorrow = 0;
        $days7 = 0;
        $overdue = ContractScheduleModel::
                    join("product_accessory","product_accessory.PA_ID",
                    "contract_schedule_service.Accessory_Id")
                    ->join("products","products.Product_ID","product_accessory.Product_ID")
                    ->join("contracts","contracts.CNRT_ID","contract_schedule_service.Contract_Id")
                    ->join("customers","customers.CST_ID","contracts.CNRT_CustomerID")
                    ->join("master_service_status","contract_schedule_service.Schedule_Status","master_service_status.Status_Id")
                    ->where("isManaged",0)
                    ->where('contract_schedule_service.Schedule_Date',"<",$todayDate)
                    ->count();
        $today = ContractScheduleModel::
                    join("product_accessory","product_accessory.PA_ID",
                    "contract_schedule_service.Accessory_Id")
                    ->join("products","products.Product_ID","product_accessory.Product_ID")
                    ->join("contracts","contracts.CNRT_ID","contract_schedule_service.Contract_Id")
                    ->join("customers","customers.CST_ID","contracts.CNRT_CustomerID")
                    ->join("master_service_status","contract_schedule_service.Schedule_Status","master_service_status.Status_Id")
                    ->where("isManaged",0)
                    ->where('contract_schedule_service.Schedule_Date',"=",$todayDate)
                    ->count();

                    $tomorrow = Carbon::tomorrow();
                    $tmrw = $tomorrow->format('Y-m-d');            
        $Tomorrow = ContractScheduleModel::
                    join("product_accessory","product_accessory.PA_ID",
                    "contract_schedule_service.Accessory_Id")
                    ->join("products","products.Product_ID","product_accessory.Product_ID")
                    ->join("contracts","contracts.CNRT_ID","contract_schedule_service.Contract_Id")
                    ->join("customers","customers.CST_ID","contracts.CNRT_CustomerID")
                    ->join("master_service_status","contract_schedule_service.Schedule_Status","master_service_status.Status_Id")
                    ->where("isManaged",0)
                    ->where('contract_schedule_service.Schedule_Date',"=",$tmrw)
                    ->count();
        $days7 = ContractScheduleModel::
                    join("product_accessory","product_accessory.PA_ID",
                    "contract_schedule_service.Accessory_Id")
                    ->join("products","products.Product_ID","product_accessory.Product_ID")
                    ->join("contracts","contracts.CNRT_ID","contract_schedule_service.Contract_Id")
                    ->join("customers","customers.CST_ID","contracts.CNRT_CustomerID")
                    ->join("master_service_status","contract_schedule_service.Schedule_Status","master_service_status.Status_Id")
                    ->where("isManaged",0)
                    ->whereBetween('contract_schedule_service.Schedule_Date',[$todayDate,$days7datetime])
                    ->count();


                    return response()->json(["success"=>true, "message"=> '',
                    "overDue"=>$overdue,"Tomorrow"=>$Tomorrow,
                    "today"=>$today,"days7"=>$days7]);
                 
    }

}
