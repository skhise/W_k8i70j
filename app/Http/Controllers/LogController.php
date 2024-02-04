<?php

namespace App\Http\Controllers;

use App\Models\SystemLog;
use Illuminate\Support\Facades\Auth;


class LogController extends Controller
{

    public function SystemLog($loginId = null, $message)
    {

        $log = SystemLog::create([
            "loginId" => Auth::user()->id,
            "ActionDescription" => $message
        ]);
        if ($log) {
            return response()->json(["success" => true, "message" => "log created"]);
        }
    }



}

