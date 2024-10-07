<?php

namespace App\Http\Controllers;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\NewInquiry;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class EnquiryController extends Controller
{
    
    public function GetEnquiryList(Request $request){
        $todate = $request->todate;
        $fromdate = $request->fromdate;
        $status = $request->status;
        if($status == -1){
            $enquiries = NewInquiry::leftJoin("customers","customers.CST_ID","new_inquiry.Customer_Id")
                        ->whereBetween(DB::raw('DATE_FORMAT(new_inquiry.created_at, "%Y-%m-%d")'),[$todate,$fromdate])
                        ->get();
                          foreach($enquiries as $enquire){
                            $enquire->status =intval($enquire->status);
                        }
            return response()->json(['success' => true, 'message'=> '','enquiries'=>$enquiries]);
        } else {
            $enquiries = NewInquiry::leftJoin("customers","customers.CST_ID","new_inquiry.Customer_Id")
                        ->where("new_inquiry.status",$status)
                        ->whereBetween(DB::raw('DATE_FORMAT(new_inquiry.created_at, "%Y-%m-%d")'),[$todate,$fromdate])
                        ->get();
                          foreach($enquiries as $enquire){
                            $enquire->status =intval($enquire->status);
                        }
            return response()->json(['success' => true, 'message'=> '','enquiries'=>$enquiries]);

        }
         
    }
    public function DeleteEnquiry(Request $request){
        $id = $request->id;
        $isdelete = NewInquiry::where("id",$id)->delete();
        if ($isdelete){
            return response()->json(['success' => true, 'message'=> 'Deleted.']); 
        } else {
            return response()->json(['success' => false, 'message'=> 'Action failed, Try again.']); 
        }
    }
    public function UpdateEnquiry(Request $request) {
        $id = $request->id;
        $status = $request->status;
        $isupdate = NewInquiry::where("id",$id)->update(['status'=>$status]);
        if ($isupdate) {
            return response()->json(['success' => true, 'message'=> 'Updated.']); 
        } else {
            return response()->json(['success' => false, 'message'=> 'Action failed, Try again.']); 
        }
    }
      
    
}

