<?php

namespace App\Http\Controllers;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    
    public function GetRequestList(Request $request){
        $todate = $request->todate;
        $fromdate = $request->fromdate;
        $status = $request->status;
        if($status==-1){
            $customerrequests = ServiceRequest::leftJoin("master_issue_type","master_issue_type.id","newservicerequest.IssueType")
                ->leftJoin("master_service_type","master_service_type.id","newservicerequest.ServiceType")
                ->leftJoin("customers","customers.CST_ID","newservicerequest.Customer_Id")
                ->whereBetween(DB::raw('DATE_FORMAT(newservicerequest.created_at, "%Y-%m-%d")'),[$todate,$fromdate])
                ->get(["newservicerequest.id as requestId","newservicerequest.*","master_service_type.*","customers.*","master_issue_type.*"]);
                  foreach($customerrequests as $customerrequest){
                            $customerrequest->status =intval($customerrequest->status);
                        }
                return response()->json(['success' => true, 'message'=> '','requests'=>$customerrequests]); 
        } else {
            $customerrequests = ServiceRequest::leftJoin("master_issue_type","master_issue_type.id","newservicerequest.IssueType")
                ->leftJoin("master_service_type","master_service_type.id","newservicerequest.ServiceType")
                ->leftJoin("customers","customers.CST_ID","newservicerequest.Customer_Id")
                ->where("newservicerequest.status",$status)
                ->whereBetween(DB::raw('DATE_FORMAT(newservicerequest.created_at, "%Y-%m-%d")'),[$todate,$fromdate])
                ->get(["newservicerequest.id as requestId","newservicerequest.*","master_service_type.*","customers.*","master_issue_type.*"]);
               foreach($customerrequests as $customerrequest){
                            $customerrequest->status =intval($customerrequest->status);
                        }
                return response()->json(['success' => true, 'message'=> '','requests'=>$customerrequests]); 
        }
        
    }
    public function DeleteRequest(Request $request){
        $id = $request->id;
        $isdelete = ServiceRequest::where("id",$id)->delete();
        if ($isdelete){
            return response()->json(['success' => true, 'message'=> 'Deleted.']); 
        } else {
            return response()->json(['success' => false, 'message'=> 'Action failed, Try again.'.$id]); 
        }
    }
    public function UpdateRequest(Request $request) {
        $id = $request->id;
        $status = $request->status;

        $isupdate = ServiceRequest::where("id",$id)->update(['status'=>$status]);
        if ($isupdate) {
            return response()->json(['success' => true, 'message'=> 'Updated.']); 
        } else {
            return response()->json(['success' => false, 'message'=> 'Action failed, Try again.']); 
        }
    }
      
    
}

