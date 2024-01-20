<?php

namespace App\Http\Controllers;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User; 
use App\Models\SystemLog; 
use App\Models\MailSetting;
use App\Models\Account_Setting;
use App\Models\Service;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Hash;


class EmployeeController extends Controller
{
    //
    public function DeleteEmployee(Request $request)
    {
        $validator  =   Validator::make($request->all(),
        [
            'id' =>"required",
        ]
        );
        if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"Service information missing.","validation_error" => $validator->errors()]);
        }
        try{
            $isok  = $this->CheckIfServiceCall($request->id); 
            if($isok){
                $employee = Employee::find($request->id);
                $isDelete = Employee::find($request->id)->delete();
                if($isDelete){
                    $isd = $this->DeleteUser($request->id);
                    if($isd){
                        $action = "Employee Deleted, Name:".$employee->EMP_Name.",Email:".$employee->EMP_Email;
                        $log = App(\App\Http\Controllers\LogController::class);
                        $log->SystemLog($request->loginId,$action);
                        return response()->json(["success" => true, "message"=>"Employee Deleted."]);
                    }
                    return response()->json(["success" => true, "message"=>"Action failed, try again."]);
                } else {
                    return response()->json(["success" => true, "message"=>"Action failed, try again."]);
                }
                
            } else {
                $update = Employee::find($request->id)->update(['EMP_Status'=>0]);
                if($update){
                    return response()->json(["success" => true, "message"=>"Employee marked as deleted."]);
                } else {
                    return response()->json(["success" => true, "message"=>"Action failed, try again."]);
                }
            }
        }catch(Exception $ex){
            $log = App(\App\Http\Controllers\LogController::class);
            $log->SystemLog($request->loginId,$ex->getMessage());
        }
        
      
        
    }
    public function DeleteUser($id){
        $isDelete = User::find($id)->delete();
        if($isDelete){
            return true;
        } else {
            return false;
        }
    }
    public function CheckIfServiceCall($Emp_Id)
    {
        $count = Service::where("assigned_to",$Emp_Id)->count();
        if($count){
            return false;
        }
        return true;

    }
    public function getAllUsers(Request $request){
        $employees = array();    
         try {
              
            $employees = Employee::join("master_designation","master_designation.id","employees.EMP_Designation")
            ->join("users","users.id","employees.EMP_ID")
            ->leftJoin("master_role_access","master_role_access.id","employees.Access_Role")
            ->where("EMP_Status",1)
            ->orderBy("employees.EMP_ID","DESC")->get();
            foreach($employees as $employee){
                $employee->Edit = "/employees/view?id=".$employee->EMP_ID;
                $employee->View = "/employees/view?id=".$employee->EMP_ID;
            }
            
        } catch (Illuminate\Database\QueryException $ex){
            return $ex->errorInfo;
        } 
        return json_encode($employees);
    }
    public function GetEmployees(Request $request){
        $employees = array();    
         try {
              
            $employees = Employee::join("master_designation","master_designation.id","employees.EMP_Designation")
            ->join("users","users.id","employees.EMP_ID")
            ->leftJoin("master_role_access","master_role_access.id","employees.Access_Role")
            ->where("EMP_Status",1)
            ->orderBy("employees.EMP_ID","DESC")->get();
            foreach($employees as $employee){
                $employee->Edit = "/employees/view?id=".$employee->EMP_ID;
                $employee->View = "/employees/view?id=".$employee->EMP_ID;
            }
            
        } catch (Illuminate\Database\QueryException $ex){
            return $ex->errorInfo;
        } 
        return $employees;
    }
    public function GetEmployeeById(Request $request){
        $employee =array(); 
        try {
            $id = $request->Emp_ID;
            $employee = Employee::join("master_designation","master_designation.id","employees.EMP_Designation")
            ->join("users","users.id","employees.EMP_ID")
            ->leftJoin("master_role_access","master_role_access.id","employees.Access_Role")
            ->where("employees.EMP_ID",$id)
            ->first(["employees.*","master_designation.*","users.*","master_role_access.id as access_role_id","master_role_access.access_role_name"]);
           
        
        } catch (Illuminate\Database\QueryException $ex){
            return $ex->errorInfo;
            return response()->json(['success' =>false, "employee"=>[]]); 
        }
        return response()->json(['success' => true, "employee"=>$employee,"id"=>$id]); 
    }
    public function UpdateEmployee(Request $request){
        
        $validator  =       Validator::make($request->all(),
             [
                 "EMP_Name" =>"required",
                 "EMP_Designation" =>"required",
                 "EMP_AccessRole"=>"required",
             ]
         );
           
         if($validator->fails()) {
             return response()->json(["success" => false, "message"=>"all * marked fields required.","validation_error" => $validator->errors()]);
         }
          try{
           $user_status = User::where("id",$request->EMP_ID)->where("role","3")->first();
                  if(!is_null($user_status)){
                         try {
                              $employee = Employee::where('EMP_ID',$request->EMP_ID)->update([
                     'EMP_Name' => $request->EMP_Name,
                     'EMP_Designation' => $request->EMP_Designation,
                     "EMP_Email"=>$request->EMP_Email,
                     "EMP_CPRNumber"=>$request->EMP_CPRNumber,
                     "EMP_Qualification"=>$request->EMP_Qualification,
                     "EMP_MobileNumber"=>$request->EMP_MobileNumber,
                     "EMP_CompanyMobile"=>$request->EMP_CompanyMobile,
                    "EMP_Address"=>$request->EMP_Address,
                    "EMP_TechnicalAbilities"=>$request->EMP_TechnicalAbilities,
                    "Access_Role"=>$request->EMP_AccessRole
                   ]);
                    if($employee) {
                        $action = "Employee Updated, Name:".$request->EMP_Name.",Email:".$request->EMP_Email;
                        $log = App(\App\Http\Controllers\LogController::class);
                        $log->SystemLog($request->loginId,$action);
                        return response()->json(['success' => true, 'message'=> 'Employee Updated.']); 
                    } else {
                        return response()->json(['success' => false, 'message'=> 'Action failed, Try again.']); 
                    }
                         } catch(Illuminate\Database\QueryException $ex){
                             return response()->json(['success' => false, 'message'=>$ex->errorInfo]);
                         }
                  
                  } else {
                      return response()->json(['success' => false, 'message'=> 'Employee not found!']); 
                  }
             
         } catch (Illuminate\Database\QueryException $ex){
             return response()->json(['success' => false, 'message'=> $ex->errorInfo]);
         }
         
         //return response()->json($engineer);
       }
       public function CPRUpdate(Request $request)
       {
        $validator  =       Validator::make($request->all(),
        [
            "cpr" =>"required",
            "path" =>"required",
            "EMP_Name" =>"required",
        ]);
    if($validator->fails()) {
        return response()->json(["success" => false, "message"=>"* marked fields required.","validation_error" => $validator->errors()]);
    }
    $upload = $this->uploadCPR($request);
    if($upload!=""){
        $update = Employee::where("EMP_ID",$request->EMP_ID)
        ->update([
            'EMP_CPRNumber'=>$request->cpr,
            'EMP_CPRUpload'=>$upload,
        ]);
        if($upload){
            return response()->json(["success" => true, "message"=>"updated"]);
        } else {
            return response()->json(["success" => false, "message"=>"update failed, try again."]);
        }
    } else {
        return response()->json(["success" => false, "message"=>"update failed, try again."]);
    }
      
    


       }
       public function uploadCPR($request) {
        $imagesName = "";
        if($request->has('path')) {
            $image = $request->path;
            $empName = str_replace(' ', '',$request->EMP_Name);
            $image_path = "/images/Employee/CPR/cpr_".$empName. '.png';
            $imagesName = "/app/public".$image_path;
            $path = storage_path().$imagesName;
            if(file_exists($path)){
                unlink($path);
            }
            $img = substr($image, strpos($image, ",")+1);
            $data = base64_decode($img);
          //  print_r($img);
            //exit;
            $success= file_put_contents($path,$data);
            if($success){
                $imagesName= "/storage".$image_path;    
            } else {
                $imagesName="";
            }
       
        } else {
            $imagesName= "";    
        }
        return $imagesName;
    }
    public function PicUpdate(Request $request){
        $validator  =       Validator::make($request->all(),
        [
            "EMP_Name" =>"required",
            "EMP_Profile_Path"=>"required",
        ]);
        if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"* marked fields required.","validation_error" => $validator->errors()]);
        }
        $upload = $this->uploadProfile($request);
    if($upload!=""){
        $update = Employee::where("EMP_ID",$request->EMP_ID)
        ->update([
            'Profile_Image'=>$upload,
        ]);
        if($upload){
            return response()->json(["success" => true, "message"=>"updated"]);
        } else {
            return response()->json(["success" => false, "message"=>"update failed, try again."]);
        }
    } else {
        return response()->json(["success" => false, "message"=>"update failed, try again."]);
    }

    }
    public function uploadProfile($request) {
        $imagesName = "";
        if($request->has('EMP_Profile_Path')) {
            $image = $request->EMP_Profile_Path;
            $empName = str_replace(' ', '',$request->EMP_Name);
            $image_path = "/images/Employee/Avatars/Avatar_".$empName. '.png';
            $imagesName = "/app/public".$image_path;
            $path = storage_path().$imagesName;
            if(file_exists($path)){
                unlink($path);
            }
            $img = substr($image, strpos($image, ",")+1);
            $data = base64_decode($img);
            $success= file_put_contents($path,$data);
            if($success){
                $imagesName= "/storage".$image_path;    
            } else {
                $imagesName="";
            }
        } else {
            $imagesName= "";    
        }
        return $imagesName;
    }
    public function ResetPassword(Request $request){
        $validator  =       Validator::make($request->all(),
        [
            "NewPassword" =>"required",
            "EMP_ID"=>"required",
            
        ]);
        if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"* marked fields required.","validation_error" => $validator->errors()]);
        }
        $password = Hash::make($request->NewPassword);
        $update = User::where("id",$request->EMP_ID)
                    ->update([
                        "password"=>$password
                    ]);
            if($update){
                        $user = User::where("id",$request->EMP_ID)->first();
                        $action = "Password Reset, User Email:".$user->email;
                        $log = App(\App\Http\Controllers\LogController::class);
                        $log->SystemLog($request->loginId,$action);
                return response()->json(["success" => true, "message"=>"password updated."]);
            } else {
                return response()->json(["success" => false, "message"=>"password update failed, try again."]);
            }
    }
    public function DeActivate(Request $request){
        $validator  =       Validator::make($request->all(),
        [
            "mode" =>"required",
            "EMP_ID"=>"required",
        ]);
        if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"* marked fields required.","validation_error" => $validator->errors()]);
        }
        $log = App(\App\Http\Controllers\LogController::class);
        $update = User::where("id",$request->EMP_ID)
                    ->update([
                        "status"=>$request->mode
                    ]);
            if($update){
                
                $status = $request->mode == 0 ? "Deactivated" : "Activated";
                $user = User::where("id",$request->EMP_ID)->first();
                $action = "User Status changed for Email: ".$user->email .", Status ".$status;
                $log = App(\App\Http\Controllers\LogController::class);
                $log->SystemLog($request->loginId,$action);
                return response()->json(["success" => true, "message"=>"updated."]);
            } else {
                return response()->json(["success" => false, "message"=>"password update failed, try again."]);
            }
    }
    public function AddEmployee(Request $request){
        
       $validator  =       Validator::make($request->all(),
            [
                "Employee_Name" =>"required|unique:users,name",
                "EMP_Email"=>"required",
                "EMP_Designation_Id" =>"required",
                "EMP_MobileNumber" => "required",
                "password"   => "required|min:6", 
                "email"      => "required|email|unique:users",
            ]
        );
          
        if($validator->fails()) {
            return response()->json(["success" => false, "message"=>$validator->errors()->first(),"validation_error" => $validator->errors()]);
        }
         try{
             
             
                $email_status = User::where("email",$request->email)->first();
                $id=0;
                 $password = Hash::make($request->password);
                 if(is_null($email_status)){
                    $upload = "";
                    if($request->EMP_CPRUpload !=""){
                        $upload = $this->uploadCPR($request);
                    }
                    $uploadProfile = "";
                    if($request->EMP_Profile_Path !=""){
                        $uploadProfile = $this->uploadProfile($request);
                    }
                   
                    DB::beginTransaction();
                    $user = User::create([
                        "name"=>$request->Employee_Name,
                        "email"=>$request->email,
                        "password"=>$password,
                        "role"=>3,
                        "Status"=>1]);
                    if(!is_null($user)){
                        $id = $user->id;
                        try{
                             $employee = Employee::create([
                    'EMP_ID'=>$user->id,         
                    'EMP_Name' => $request->Employee_Name,
                    'EMP_Designation' => $request->EMP_Designation_Id,
                    "EMP_Email"=>$request->EMP_Email,
                    "EMP_Qualification"=>$request->EMP_Qualification,
                    "EMP_MobileNumber"=>$request->EMP_MobileNumber,
                    "EMP_CompanyMobile"=>$request->EMP_CompanyMobile,
                       "EMP_Address"=>$request->EMP_Address,
                       "EMP_TechnicalAbilities"=>$request->EMP_TechnicalAbilities,
                       "EMP_CPRNumber"=>$request->EMP_CPRNumber,
                       "EMP_CPRUpload"=>$upload,
                       "Profile_Image"=>$uploadProfile,
                       "EMP_Status"=>1,
                       "EMP_Created_By"=>$request->loginId,
                       "Access_Role"=>$request->EMP_AccessRole
                  ]); 
                   if($employee){
                    try{
                        $action = "Employee Added, Name:".$request->Employee_Name." Email:".$request->EMP_Email;
                        $log = App(\App\Http\Controllers\LogController::class);
                        $subject = "Login Details For IWS Services";
                        $mailsetting = MailSetting::where("id",1)->first();
                        $accountsetting = Account_Setting::where("id",1)->first();
                        if($mailsetting->employee_add_mail_allowed){
                            $body = "Dear ".$request->Employee_Name.",<br/><br/>";
                            $body .=$mailsetting->employee_add_template."<br/><br/>";
                            $body .= "Login Email : ".$request->email."<br/> Login Password : ".$request->password;
                            $body .="<br/><br/>".$accountsetting->mail_signature;
                            $mail = new MailController;
                            $mail->SendMail($request->email,$subject,$body);
                        }
                       
                    $log->SystemLog($request->loginId,$action);
                    }catch(Exception $e){

                    }
                    DB::commit();
                        return response()->json(['success' => true, 'message'=> 'Employee Created.']); 
                   }else {
                    DB::rollBack();
                       return response()->json(['success' => false, 'message'=> 'Action failed, Try again.']); 
                   }
                        }catch(Illuminate\Database\QueryException $ex){
                            DB::rollBack();
                            return response()->json(['success' => false, 'message'=>$ex->errorInfo]);
                        }
                  
                    }else {
                        return response()->json(['success' => false,'message'=> 'Action failed, Try again.']);
                    }
                    
                   
                 } else {
                     return response()->json(['success' => false, 'message'=> 'User already added with the email!']); 
                 }
        } catch (Illuminate\Database\QueryException $ex){
            User::where('id',$id)->delete();
            return response()->json(['success' => false, 'message'=> $ex->errorInfo]);
        }
        
        //return response()->json($engineer);
      }
      
      function deleteEngineer(Request $request){
          
          $engId = $request->engId;
          $loginId = $request->loginId;
          if($engId!=0 && $loginId!=0 && $engId!="" && $loginId!=""){
              $isuniq = Engineer::join("users","users.id","engineers.User_Id")->where("engineers.User_Id",$engId)->where("engineers.Client_Id",$loginId)->first();
              if(!is_null($isuniq)){
                  $isdelete1 = Engineer::where("engineers.User_Id",$engId)->where("engineers.Client_Id",$loginId)->delete();
                  if($isdelete1){
                      $isdelete2 = User::where("id",$engId)->delete();
                      if($isdelete2){
                        
                          return response()->json(['success' => true, 'message'=> 'Engineer deleted.']); 
                      } else {
                           $restoreDataId = Engineer::withTrashed()->find("User_Id",$loginId);
                            if($restoreDataId && $restoreDataId->trashed()){
                               $restoreDataId->restore();
                            }
                            return response()->json(["code"=>500,'success' => false, 'message'=> 'Action failed, Try again.']); 
                      }
                  } else {
                      
                  }
              } else {
                  return response()->json(["code"=>500,'success' => false, 'message'=> 'Engineer not found, Try again.']); 
              }
          }  else {
              return response()->json(['success' => false, 'message'=>"Invalid inputs, Try again."]);
          }
      }
    
}