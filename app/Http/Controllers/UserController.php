<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\DateTime;
use App\Models\User;
use App\Models\LoginSessionHistory;
use App\Models\Employee;
use App\Models\Account_Setting;
use Illuminate\Support\Str;
class UserController extends Controller
{
    
    
    private $status_code    =        200;
    
    public function __construct() {
        
        
    }
    public function updateToken(Request $request){
        try{
            User::where("id",1)->update(['fcm_token'=>$request->token]);
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false
            ],500);
        }
    }
    
    public function userLoginNew(Request $request) {

        $validator  = Validator::make($request->all(),
            [
                "email"             =>          "required|email",
                "password"          =>          "required"
            ]
        ); 
        if($validator->fails()) {
            return ["status"=>false, "message"=>"Valid email and password required"];
        }
        // check if entered email exists in db
        $email_status  =  User::where("email", $request->email)->first();
       // if email exists then we will check password for the same email
        if(!is_null($email_status)) {
            $password_status    =   Hash::check($request->password, $email_status->password);
            
            // if password is correct
            if($password_status) {
                if($email_status->status == 1){
                    $user    =    $this->userDetail($request->email,$email_status->role,$email_status->id);
                   
                   if(!is_null($user)){
                    $user->companyname = $this->GetComapnyAccount();
                    $ipAddress = $request->ip;
                    $this->Login_Session_History($user,$ipAddress);
                    $token = Str::random(60);
                    $email_status->forceFill([
                        'api_token' => hash('sha256', $token),
                    ])->save();
                    return ["status"=>true, "message"=> 'You have logged in successfully',"user"=>$user];
                   }
                   return ["status"=>false, "message"=> 'invalid login details, try again.',"user"=>$user];
                } else {
                    return ["status"=>false, "message"=> 'Your account has been deactivated.',"user"=>$user];
                }
               
            }
            else {
                return ["status"=>false, "message"=>'Invalid email or password'];
            }
        }
        else {
            return ["status"=>false, "message"=> 'Invalid email or password'];
        }
    } 
    
    public function userLogin(Request $request) {

        $validator  = Validator::make($request->all(),
            [
                "email"             =>          "required|email",
                "password"          =>          "required"
            ]
        ); 
        if($validator->fails()) {
            return [400, "message"=>"Valid email and password required"];
        }
        // check if entered email exists in db
        $email_status  =  User::where("email", $request->email)->first();
       // if email exists then we will check password for the same email
        if(!is_null($email_status)) {
            $password_status    =   Hash::check($request->password, $email_status->password);
            
            // if password is correct
            if($password_status) {
                if($email_status->status == 1){
                    $user    =    $this->userDetail($request->email,$email_status->role,$email_status->id);
                   
                   if(!is_null($user)){
                    $user->companyname = $this->GetComapnyAccount();
                    $ipAddress = $request->ip;
                    $this->Login_Session_History($user,$ipAddress);
                    return [200, "message"=> 'You have logged in successfully',"user"=>$user];
                   }
                   return [400, "message"=> 'invalid login details, try again.',"user"=>$user];
                } else {
                    return [400, "message"=> 'Your account has been deactivated.',"user"=>$user];
                }
               
            }
            else {
                return [400, "message"=>'Invalid email or password'];
            }
        }
        else {
            return [400, "message"=> 'Invalid email or password'];
        }
    } 
    public function Login_Session_History($user,$ip){

        if($user->id>0){
            $session = LoginSessionHistory::create([
                "Role"=>$user->role,
                "User_Id"=>$user->id,
                "Login_Token"=>"",
                "Ip_Address" =>$ip
            ]);
        }
    }
    public function userDetail($email,$role,$id) {
        $user               =       array();
        if($email != "" && $role!="") {
            if($role == 1){
                $user           =       User::where("id", $id)->first();
                $user->Access_Role = 1;
                $user->access_role_name = "Admin";
                return $user;
            } else if($role == 2){
                $user           =     User::join("customers","customers.User_Id","users.id")->where("id", $id)->first();
                $user->loginDate = new \DateTime("NOW");
                return $user;
            } else {
                $user   =   User::where("id", $id)->first();
                $user   =   $this->getAccessRole($user,$id);   
                $user->loginDate = new \DateTime("NOW");
                
                return $user;
            }
           
        }
    }
    public function GetComapnyAccount(){
        $company = Account_Setting::where("id",1)->first();
        return $company->company_display_name;
    }
    public function Profile(Request $request) {
        $id =$request->userId;
        $user  =  User::where("id", $id)->first();
        if($user->role == 1){
            $user->Access_Role = 1;
            $user->access_role_name = "Admin";
        }  else if($user->role == 3) {
           $user = $this->getAccessRole($user,$id);
        } else {
            $user->Access_Role = 5;
            $user->access_role_name = "App User";
        }              
        $user->companyname = $this->GetComapnyAccount();
        return [200,"user"=>$user];
        
    }
    public function getAccessRole($user,$id){
        $data =  Employee::join("master_role_access","master_role_access.id","employees.Access_Role")
                ->where("EMP_ID", $id)->first();
                
        if(!is_null($data)){
            $user->Access_Role= $data->access_type;
            $user->access_role_name = $data->access_role_name;
            
        }
        return $user;
    }
    public function MarkOnLineOffline(Request $request){

        try {
            $id =$request->User_ID;
            $user  =  User::where("id", $id)->first();
            $user->isOnline = 1;
            $user->save();
        } catch(Exception $e){

        }
        
    }
}
