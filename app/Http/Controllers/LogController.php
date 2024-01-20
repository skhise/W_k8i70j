<?php

namespace App\Http\Controllers;
use App\Models\SystemLog;


class LogController extends Controller {
   
    public function SystemLog($loginId,$message){

        $log = SystemLog::create([
            "loginId"=>$loginId,
            "ActionDescription"=>$message    
        ]);
        if($log){
            return response()->json(["success" => true, "message"=>"log created"]);
        }
    }
      
      
    
}

