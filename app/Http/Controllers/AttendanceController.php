<?php

namespace App\Http\Controllers;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\Account_Setting;
use App\Models\Attendance;
use App\Models\UserLeave;


class AttendanceController extends Controller
{
    public function __construct() {
        date_default_timezone_set("Asia/Kolkata");
    }
    public function UpdateLeaveRequest(Request $request){

        $status = $request->status;
        $note = $status == 3 ? "Leave Application Approved" : "Leave Application Rejected";
        $id = $request->id;
        $update = UserLeave::where("id",$id)->update(["Leave_Status"=>$status,"Update_Note"=>$note]);
        if($update){
            return response()->json(['success' => true, 'message'=> 'Status Updated']);
        } else {
            return response()->json(['success' => false, 'message'=> 'Failed to Update Status.']);
        }
        
    }
    public function GetLeaveApplicationAdmin(Request $request){
        try{ 
            $fromdate =$request->fromdate;
            $todate =$request->todate;
            $status = $request->status;
            if($status==-1){
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
                    ->orWhere("user_leave.Leave_Status","=",$status)
                    ->get();
                foreach($userLeave as $leave){
                    $fromd = Carbon::parse($leave->From_Date);
                    $tod = Carbon::parse($leave->To_Date);
                    $diff = $fromd->diffInDays($tod);
                    $leave->days = $diff;   
                }    
            }
            
            return response()->json(['success' => true, 'message'=> $fromdate."---".$todate,'leaves'=>$userLeave]);
        }catch(Exception $e){
            return response()->json(['success' => false, 'message'=> $ex->errorInfo,'leaves'=>[]]); 
        }
        

    }
    public function GetLeaveApplication(Request $request){
        try{
            $month =$request->month;
            $year =$request->year;
            $fd = $year."-".$month;
            $userId = $request->User_ID;
            if(!is_null($userId)){
                $userLeave = UserLeave::where("User_ID",$userId)
                ->where(DB::raw('DATE_FORMAT(user_leave.created_at, "%Y-%m")'),$fd)
                ->get();
                return response()->json(['success' => true, 'message'=> $fd,'leaves'=>$userLeave]);
            } else {
                return response()->json(['success' => false, 'message'=> 'Valid data required'.$userId,'leaves'=>[]]); 
            }
        }catch(Exception $e){
            return response()->json(['success' => false, 'message'=> $ex->errorInfo,'leaves'=>null]); 
        }
        

    }

    public function SaveLeaveApplication(Request $request){
       
        $validator  =   Validator::make($request->all(),
            [
                "User_ID" => "required",
                "toDate"=>"required",
                "fromDate"=>"required",
                "message"=>"required",
            ]
        );
          
        if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"details missing.","validation_error" => $validator->errors()]);
        }

        $leave = UserLeave::create([
            'User_ID'=>$request->User_ID,
            'From_Date'=>Carbon::parse($request->fromDate)->format("Y-m-d"),
            'To_Date'=>Carbon::parse($request->toDate)->format("Y-m-d"),
            'Leave_Reason'=>$request->message,
            'Leave_Status'=>0,
            'Update_By'=>0,
            'Leave_Type'>0,
            'Update_Note'=>'',
        ]);
        if(!is_null($leave)){
            return response()->json(["success" => true, "message"=>"Leave Application Saved."]); 
        } else {
            return response()->json(["success" => false, "message"=>"something went wrong, try again."]); 
        }

    }
    public function GetAttendanceByDate(Request $request){
        try{
            $date = $request->att_date;
            $userId = $request->User_Id;
            if(!is_null($date) && !is_null($userId)){
                $attendance = Attendance::where("User_ID",$userId)
                ->where("Att_Date",Carbon::parse($date)->format("Y-m-d"))
                ->first();
                return response()->json(['success' => true, 'message'=> '','attendance'=>$attendance]);
            } else {
                return response()->json(['success' => false, 'message'=> 'Valid date required','attendance'=>[]]); 
            }
        }catch(Exception $e){
            return response()->json(['success' => false, 'message'=> $ex->errorInfo,'attendance'=>null]); 
        }
    }
    public function GetAttendanceById(Request $request){

        try{
            $ID = $request->ID;
            $attendance = Attendance::join("employees","employees.EMP_ID","attendance.User_ID")
            ->where("id",$ID)
            ->first();
            return response()->json(['success' => true, 'message'=> $ID,'attendance'=>$attendance]); 
        }catch(Exception $e){
            return response()->json(['success' => false, 'message'=> $e->errorInfo,'attendance'=>[]]); 
        }
        

    }
    public function GetAttendanceList(Request $request){

        $attendance= array();    
        $EMP_ID = $request->EMP_ID;
        $fromdate =$request->fromdate;
        $todate =$request->todate;
         try {
            if($EMP_ID == 0 || $EMP_ID == ""){
                $attendance = Attendance::join("employees","employees.EMP_ID","attendance.User_ID")
                ->whereBetween("Att_Date",[$fromdate,$todate])
                ->orderBy("attendance.Att_Date","DESC")
                ->get();
                if(!is_null($attendance)){
                    foreach($attendance as $att){
                        $att->att_date = Carbon::parse($att->Att_Date)->format("d-m-Y");
                        $intime = $att->Att_In!=null ? Carbon::parse($att->Att_In):null;
                        $outtime = $att->Att_Out !=null ?  Carbon::parse($att->Att_Out) : null;
                        $att->att_intime = $att->Att_In!=null ?  Carbon::parse(date($att->Att_In))->format("h:i:s a"): "00:00:00";
                        $att->att_outtime =  $att->Att_Out !=null ?  Carbon::parse(date($att->Att_Out))->format("h:i:s a"): "00:00:00";
                        $att->totalHours = $att->Att_In!=null ? $intime->diff($outtime)->format('%H:%I:%S'):0;
                        $att->Edit = "/attendance/attendance?id=".$att->id;
                        if($att->Att_In_Location == "null" || $att->Att_In_Location == ""){
                            $att->Map_Link_In = null;
                        } else {
                            $att->Map_Link_In = "https://maps.google.com/?q=".$att->Att_In_Location."&z=18";
                        }
                        if($att->Att_Out_Location == "null" || $att->Att_Out_Location == ""){
                            $att->Map_Link_Out = null;
                        } else {
                            $att->Map_Link_Out = "https://maps.google.com/?q=".$att->Att_Out_Location."&z=18";
                        }
                    }
                }
            } else {
                $attendance = Attendance::join("employees","employees.EMP_ID","attendance.User_ID")
                ->where("User_ID",$EMP_ID)
                ->whereBetween("Att_Date",[$fromdate,$todate])
                ->orderBy("attendance.Att_Date","DESC")
                ->get();
                if(!is_null($attendance)){
                    foreach($attendance as $att){
                        $att->att_date = Carbon::parse($att->Att_Date)->format("d-m-Y");
                        $intime = $att->Att_In!=null ? Carbon::parse($att->Att_In):null;
                        $outtime = $att->Att_Out !=null ?  Carbon::parse($att->Att_Out) : null;
                        $att->att_intime = $att->Att_In!=null ?  Carbon::parse(date($att->Att_In))->format("h:i:s a"): "00:00:00";
                        $att->att_outtime =  $att->Att_Out !=null ?  Carbon::parse(date($att->Att_Out))->format("h:i:s a"): "00:00:00";
                        $att->totalHours = $att->Att_In!=null ? $intime->diff($outtime)->format('%H:%I:%S'):0;
                        $att->Edit = "/attendance/attendance?id=".$att->id;
                    }
                }
            }
            
           
            } catch (Illuminate\Database\QueryException $ex){
                return response()->json(['success' => false, 'message'=> $ex->errorInfo,'attendance'=>[]]); 
            }
            return response()->json(['success' => true, 'message'=> '','attendance'=>$attendance]); 
        }

    public function GetEngineerAttendance(Request $request) {
        $attendance= array();    
        $userId = $request->userId;
        $month =$request->month;
        $year =$request->year;
        $fd = $year."-".$month;
         try {
            $attendance = Attendance::where("User_ID",$userId)
            ->where(DB::raw('DATE_FORMAT(attendance.Att_Date, "%Y-%m")'),$fd)
            ->orderBy("attendance.Att_Date","DESC")
            ->get();
            foreach($attendance as $att){
                $att->att_date = Carbon::parse($att->Att_Date)->format("d-m-Y");
                $att->att_intime = Carbon::parse(date($att->Att_In))->format("h:i a");
                $att->att_outtime = Carbon::parse(date($att->Att_Out))->format("h:i a");
                $att->att_remark = "remark";
            }
        } catch (Illuminate\Database\QueryException $ex){
            return response()->json(['success' => false, 'message'=> $ex->errorInfo,'attendance'=>[]]); 
        }
        return response()->json(['success' => true, "months"=>$fd, 'message'=> '','attendance'=>$attendance]); 
    }
    public function AddPunchAdmin(Request $request){
        
        try{

            $attendance = Attendance::where("User_ID",$request->EMP_ID)
            ->where("Att_Date",Carbon::parse($request->EMP_AttDate)->format("Y-m-d"))->first();
            if(!is_null($attendance)){
                $attendance = Attendance::where('User_ID',$request->EMP_ID)->update([
                    'Att_Date'=>Carbon::parse($request->Att_Date)->format("Y-m-d"),
                    'Att_In'=>date('Y-m-d H:i:s', strtotime($request->Att_In)),
                    'Att_In_Location'=>null,
                    'Att_Out'=>date('Y-m-d H:i:s', strtotime($request->Att_Out)),
                    'Att_Out_Location'=>null,
                ]);
                if($attendance){
                    return response()->json(['success' => true, 'message'=> 'Punch Marked',]); 
                    
                }else {
                    return response()->json(['success' => false, 'message'=> 'Action failed, Try again.']); 
                }
            } else {
                $attendance = Attendance::create([
                    'User_ID'=>$request->EMP_ID,
                    'Att_Date'=>Carbon::parse($request->Att_Date)->format("Y-m-d"),
                    'Att_In'=>date('Y-m-d H:i:s', strtotime($request->Att_In)),
                    'Att_In_Location'=>null,
                    'Att_Out'=>date('Y-m-d H:i:s', strtotime($request->Att_Out)),
                    'Att_Out_Location'=>null,
                ]);
                if($attendance){
                    return response()->json(['success' => true, 'message'=> 'Punch Marked',]); 
                    
                }else {
                    return response()->json(['success' => false, 'message'=> 'Action failed, Try again.']); 
                }
            }
            
       }catch(Illuminate\Database\QueryException $ex){
           return response()->json(['success' => false, 'message'=>$ex->errorInfo]);
       }
       }
    public function AddPunch(Request $request){
        
       $validator  =   Validator::make($request->all(),
            [
                "User_ID" => "required",
                "type"=>"required",
            ]
        );
          
        if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"user details missing.","validation_error" => $validator->errors()]);
        }
        try{
            $attendance = Attendance::where("User_ID",$request->User_ID)
            ->where("Att_Date",Carbon::parse($request->Att_Date)->format("Y-m-d"))->first();
            if(!is_null($attendance)){
                $attendance = Attendance::where("User_ID",$request->User_ID)
                        ->where("Att_Date",Carbon::parse($request->Att_Date)->format("Y-m-d"))->update([
                    'Att_Out'=>Carbon::Now(),//Carbon::parse($request->Att_Out)->format("Y-m-d h:i:s"),
                    'Att_Out_Location'=>$request->Att_Out_Location,
                ]);
                if($attendance){
                    return response()->json(['success' => true, 'message'=> 'Punch Marked',]); 
                    
                }else {
                    return response()->json(['success' => false, 'message'=> 'Action failed, Try again.']); 
                }
            } else {
                $attendance = Attendance::create([
                    'User_ID'=>$request->User_ID,
                    'Att_Date'=>Carbon::parse($request->Att_Date)->format("Y-m-d"),
                    'Att_In'=>Carbon::Now(), //Carbon::parse($request->Att_In)->format("Y-m-d h:i:s"),
                    'Att_In_Location'=>$request->Att_In_Location,
                    'Att_Out'=>null,
                    'Att_Out_Location'=>null,
                ]);
                if($attendance){
                    return response()->json(['success' => true, 'message'=> 'Punch Marked',]); 
                    
                }else {
                    return response()->json(['success' => false, 'message'=> 'Action failed, Try again.']); 
                }
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
   
      
      
    
}

