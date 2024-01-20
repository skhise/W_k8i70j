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
use App\Models\VisitType;
use App\Models\VisitStatus;
use App\Models\Visits;


class VisitController extends Controller
{


    public function GetVisitById(Request $request)
    {
        $validator  =   Validator::make($request->all(),
        [
            'id'=>'required',
            
        ]
        ); 
        if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"visit details missing."]);
        }
        $visit =Visits::join("employees","employees.EMP_ID","visits.User_ID")
        ->leftJoin("master_visit_type","master_visit_type.id","visits.visitType")
        ->leftJoin("master_visit_status","master_visit_status.id","visits.visitStatus")
        ->where("visits.id",$request->id)->first(["*","visits.id as visit_id","master_visit_status.status_name as status_title","master_visit_type.type_name as type_title"]);
        return response()->json(["success" => true, "message"=>"","visit"=>$visit]);
 
    }
    function GetUserVisits(Request $request){

        $todate = $request->todate;
        $fromdate = $request->fromdate;
        
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
            $visits = Visits::where("User_ID",$request->EMP_ID)
            ->join("employees","employees.EMP_ID","visits.User_ID")
            ->leftJoin("master_visit_type","master_visit_type.id","visits.visitType")
            ->leftJoin("master_visit_status","master_visit_status.id","visits.visitStatus")
            ->whereBetween(DB::raw('DATE_FORMAT(visits.visitDate, "%Y-%m-%d")'),[$fromdate,$todate])
            ->get(["*","visits.id as visit_id","master_visit_status.status_name as status_title","master_visit_type.type_name as type_title"]);
            foreach($visits as $visit){
                $visit->edit = "/visit/edit-employee-visit?id=".$visit->visit_id;
            }
        }
       
        return response()->json(["success" => true, "message"=>"","visits"=>$visits]);
    }

    function GetUserVisitsById(Request $request){
        $validator  =   Validator::make($request->all(),
        [
            'User_ID'=>'required',
            'month'=>'required',
            'year'=>'required',
        ]
        );
        $month =$request->month;
        $year =$request->year;
        $month = $month<9 ? "0".$month :$month;
        $fd = $year."-".$month;
        if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"user details missing"]);
        }
        $visits = Visits::where("User_ID",$request->User_ID)
                ->leftJoin("master_visit_type","master_visit_type.id","visits.visitType")
                ->leftJoin("master_visit_status","master_visit_status.id","visits.visitStatus")
                ->where(DB::raw('DATE_FORMAT(visits.visitDate, "%Y-%m")'),$fd)
                ->get();
        return response()->json(["success" => true, "message"=>$month,"visits"=>$visits]);
    }
    function NewVisit(Request $request){
        $validator  =   Validator::make($request->all(),
        [
            'fromLocation'=>'required',
            'toLocation'=>'required',
            'visitType'=>'required',
            'totalKm'=>'required',
            'visitRemark'=>'required',
            'otherInfo'=>'required',
            'visitStatus'=>'required',
            'userId'=>'required',
            'toLat'=>'required',
            'toLng'=>'required',
            'fromLng'=>'required',
            'fromLat'=>'required',
            'visitDate'=>'required',
            'isUpdate'=>'required',
            'visit_id'=>'required'
        ]
        );
    
        if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"all * marked details required.","validation_error" => $validator->errors()]);
        }
        if($request->isUpdate){
            $update = Visits::where("User_ID",$request->userId)
            ->where("id",$request->visit_id)
            ->update([
                'fromLocation'=>$request->fromLocation,
                'fromLat'=>$request->fromLat,
                'fromLng'=>$request->fromLng,
                'toLocation'=>$request->toLocation,
                'toLat'=>$request->toLat,
                'toLng'=>$request->toLng,
                'totalKm'=>$request->totalKm,
                'visitDate'=>Carbon::parse($request->visitDate)->format("Y-m-d"),
                'visitType'=>$request->visitType,
                'visitRemark'=>$request->visitRemark,
                'otherInfo'=>$request->otherInfo,
                'visitStatus'=>$request->visitStatus,
                'visitCharges'=>$request->visitCharges ? $request->visitCharges : 0
    
            ]);
            if($update){
                return response()->json(["success" => true, "message"=>"Visit Updated!"]);
            } else {
                return response()->json(["success" => false, "message"=>"update action failed, Try again."]);
            }
        } else {
            $visit = Visits::create([
                'User_ID'=>$request->userId,
                'fromLocation'=>$request->fromLocation,
                'fromLat'=>$request->fromLat,
                'fromLng'=>$request->fromLang,
                'toLocation'=>$request->toLocation,
                'toLat'=>$request->toLat,
                'toLng'=>$request->toLang,
                'totalKm'=>$request->totalKm,
                'visitDate'=>Carbon::parse($request->visitDate)->format("Y-m-d"),
                'visitType'=>$request->visitType,
                'visitRemark'=>$request->visitRemark,
                'otherInfo'=>$request->otherInfo,
                'visitStatus'=>$request->visitStatus,
                'visitCharges'=>$request->visitCharges ? $request->visitCharges : 0
    
            ]);
            if($visit){
                return response()->json(["success" => true, "message"=>"Visit Saved!"]);
            } else {
                return response()->json(["success" => false, "message"=>"action failed, try again."]);
            }
        }
        

    }
    function GetVisitData(Request $request){
        $visittype = VisitType::all(["*","master_visit_type.type_name as title"]);
        $visitstatus = VisitStatus::all(["*","master_visit_status.status_name as title"]);
        return response()->json(['success' => true, 'message'=> '','visittype'=>$visittype,'visitstatus'=>$visitstatus]);
    }
    function GetVisitType(Request $request){
        $visittype = VisitType::all();
        return response()->json(['success' => true, 'message'=> '','visittype'=>$visittype]);
    }
    function GetVisitStatus(Request $request){

        $visitstatus = VisitStatus::all();
        return response()->json(['success' => true, 'message'=> '','visitstatus'=>$visitstatus]);

    }

}