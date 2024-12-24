<?php

namespace App\Http\Controllers;

use App\Models\AccessMaster;
use App\Models\Client;
use App\Models\Designation;
use App\Models\Generate;
use App\Models\LocationHistory;
use Exception;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class EmployeeController extends Controller
{
    public $status = [
        "1" => '<div class="badge badge-success badge-shadow">Active</div>',
        "2" => '<div class="badge badge-danger badge-shadow">De-Active</div>',
    ];
    //
    public function deleteEmp(Request $request, Employee $employee)
    {
        $delete = $employee->delete();
        if ($delete) {
            $action = "Employee Deleted,  Employee Name:" . $employee->EMP_Name;
            $log = App(\App\Http\Controllers\LogController::class);
            $log->SystemLog(Auth::user()->id, $action);
            return redirect()->route('employees')->with("success", "Deleted!");
        }
        return back()->withErrors("Action failed, try again.");
    }
    public function DeleteEmployee(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "Service information missing.", "validation_error" => $validator->errors()]);
        }
        try {
            $isok = $this->CheckIfServiceCall($request->id);
            if ($isok) {
                $employee = Employee::find($request->id);
                $isDelete = Employee::find($request->id)->delete();
                if ($isDelete) {
                    $isd = $this->DeleteUser($request->id);
                    if ($isd) {
                        $action = "Employee Deleted, Name:" . $employee->EMP_Name . ",Email:" . $employee->EMP_Email;
                        $log = App(\App\Http\Controllers\LogController::class);
                        $log->SystemLog($request->loginId, $action);
                        return response()->json(["success" => true, "message" => "Employee Deleted."]);
                    }
                    return response()->json(["success" => true, "message" => "Action failed, try again."]);
                } else {
                    return response()->json(["success" => true, "message" => "Action failed, try again."]);
                }

            } else {
                $update = Employee::find($request->id)->update(['EMP_Status' => 0]);
                if ($update) {
                    return response()->json(["success" => true, "message" => "Employee marked as deleted."]);
                } else {
                    return response()->json(["success" => true, "message" => "Action failed, try again."]);
                }
            }
        } catch (Exception $ex) {
            $log = App(\App\Http\Controllers\LogController::class);
            $log->SystemLog($request->loginId, $ex->getMessage());
        }



    }
    public function DeleteUser($id)
    {
        $isDelete = User::find($id)->delete();
        if ($isDelete) {
            return true;
        } else {
            return false;
        }
    }
    public function StatusChange(Request $request)
    {
        // dd($request->status);
        $user = User::where("id", $request->userId);
        if ($user) {
            $employee = Employee::where(["EMP_ID"=>$request->userId])->update(['EMP_Status' => $request->status]);
            $user->update(['status' => $request->status]);
            return true;
        } else {
            return false;
        }
    }
    public function CheckIfServiceCall($Emp_Id)
    {
        $count = Service::where("assigned_to", $Emp_Id)->count();
        if ($count) {
            return false;
        }
        return true;

    }
    public function getAllUsers(Request $request)
    {
        $employees = array();
        try {

            $employees = Employee::join("master_designation", "master_designation.id", "employees.EMP_Designation")
                ->join("users", "users.id", "employees.EMP_ID")
                ->leftJoin("master_role_access", "master_role_access.id", "employees.Access_Role")
                ->where("EMP_Status", 1)
                ->orderBy("employees.EMP_ID", "DESC")->get();
            foreach ($employees as $employee) {
                $employee->Edit = "/employees/view?id=" . $employee->EMP_ID;
                $employee->View = "/employees/view?id=" . $employee->EMP_ID;
            }

        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return json_encode($employees);
    }
    public function index(Request $request)
    {
        return view("employees.index", [
            'filters' => $request->all('search', 'trashed', 'search_field', 'filter_status'),
            'search_field' => $request->search_field ?? '',
            'filter_status' => $request->filter_status ?? '',
            'filter_role' => $request->filter_role ?? '',
            "status" => $this->status,
            'roles' => AccessMaster::where('use_status',1)->get(),
            'search' => $request->search ?? '',
            'employees' => Employee::join("master_designation", "master_designation.id", "employees.EMP_Designation")
                ->join("users", "users.id", "employees.EMP_ID")
                ->leftJoin("master_role_access", "master_role_access.id", "employees.Access_Role")
                ->where("EMP_Status", 1)
                ->orderBy("employees.EMP_ID", "DESC")
                ->filter($request->only('search', 'trashed', 'search_field', 'filter_status','filter_role'))
                ->paginate(10)
                ->withQueryString()
        ]);
    }
    public function view(Request $request, Employee $employee)
    {

        $id = $employee->EMP_ID;

        $employees = Employee::join("master_designation", "master_designation.id", "employees.EMP_Designation")
            ->join("users", "users.id", "employees.EMP_ID")
            ->leftJoin("master_role_access", "master_role_access.id", "employees.Access_Role")
            ->where("employees.EMP_ID", $id)
            ->first(["employees.*", "master_designation.*", "users.*", "master_role_access.id as access_role_id", "master_role_access.access_role_name"]);
        // dd($employees);
        return view("employees.view", ["employee" => $employees, "status" => $this->status]);
    }
    public function edit(Request $request, Employee $employee)
    {
        // dd($contract->CNRT_EndDate);
        return view('employees.create', [
            'update' => true,
            'roles' => AccessMaster::where('use_status',1)->get(),
            'designations' => Designation::all(),
            'employee' => $employee,
        ]);
    }
    public function location(Request $request)
    {
        // dd($contract->CNRT_EndDate);
        $employees = Employee::where(['Access_Role'=>4])->get();
        return view('employees.location', [
            'employees'=>$employees
        ]);
    }
    public function getLocation($userId){

        try{
            $location = LocationHistory::where('User_ID', $userId)->orderBy('id', 'desc')->first();
            return response()->json(["status" => true, "location" => $location]);
        }catch(Exception $exp){
            dd($exp->getMessage());
            return response()->json(["status" => false, "message" => "something went wrong, try again."]);

        }

    }
    public function update(Request $request, Employee $employee)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "EMP_Name" => "required",
                "EMP_Designation" => "required",
                "Access_Role" => "required",
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator->messages());
        }
        try {
            $user_status = User::where("id", $employee->EMP_ID)->where("role", "3")->first();
            if (!is_null($user_status)) {
                try {
                    $employee_up = Employee::where('EMP_ID', $employee->EMP_ID)->update([
                        'EMP_Name' => $request->EMP_Name,
                        'EMP_Designation' => $request->EMP_Designation,
                        "EMP_Email" => $request->EMP_Email,
                        "EMP_Qualification" => $request->EMP_Qualification,
                        "EMP_MobileNumber" => $request->EMP_MobileNumber,
                        "EMP_CompanyMobile" => $request->EMP_CompanyMobile,
                        "EMP_Address" => $request->EMP_Address,
                        "EMP_TechnicalAbilities" => $request->EMP_TechnicalAbilities,
                        "Access_Role" => $request->Access_Role
                    ]);
                    if ($employee_up) {
                        $action = "Employee Updated, Name:" . $employee->EMP_Name . ",Email:" . $employee->EMP_Email;
                        $log = App(\App\Http\Controllers\LogController::class);
                        $log->SystemLog(null, $action);
                        return Redirect("employees")->with("success", "Employee Updated!");
                        //  return response()->json(['success' => true, 'message' => 'Employee Updated.']);
                    } else {
                        return back()
                            ->withInput()
                            ->withErrors("Action failed, Try again");
                        // return response()->json(['success' => false, 'message' => 'Action failed, Try again.']);
                    }
                } catch (Exception $ex) {
                    return back()
                        ->withInput()
                        ->withErrors($ex->getMessage());
                }

            } else {
                return back()
                    ->withInput()
                    ->withErrors("Employee not found!");
                // return response()->json(['success' => false, 'message' => 'Employee not found!']);
            }

        } catch (Exception $ex) {
            return back()
                ->withInput()
                ->withErrors($ex->getMessage());
        }

        //return response()->json($engineer);
    }
    public function create(Request $request)
    {


        
        return view('employees.create', [
            'update' => false,
            'roles' => AccessMaster::where('use_status',1)->get(),
            'designations' => Designation::all(),
            'employee' => new Employee(),
        ]);
    }
    public function store(Request $request)
    {
        $message = [
            "EMP_Name.required" => "The name required.",
            "EMP_Email.required" => "The email required.",
            "EMP_MobileNumber.required" => "The mobile required.",
            "password.required" => "The password required.",
            "EMP_Designation.required" => "The designation required.",
            "email.required" => "The password required.",
            "email.unique" => "The email address has already been used.",

        ];
        $validator = Validator::make(
            $request->all(),
            [
                "EMP_Name" => "required",
                "EMP_Email" => "required",
                "EMP_Designation" => "required",
                "EMP_MobileNumber" => "required",
                "password" => "required|min:6",
                "email" => "required|email|unique:users",
            ],
            // $message
        );

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator->messages());
            // return response()->json(["success" => false, "message" => $validator->errors()->first(), "validation_error" => $validator->errors()]);
        }
        try {


            $email_status = User::where("email", $request->email)->first();
            $id = 0;
            $password = Hash::make($request->password);
            if (is_null($email_status)) {
                $upload = "";
                if (isset($request->EMP_CPRUpload) && $request->EMP_CPRUpload != "") {
                    $upload = $this->uploadCPR($request);
                }
                $uploadProfile = "";
                if (isset($request->EMP_Profile_Path) && $request->EMP_Profile_Path != "") {
                    $uploadProfile = $this->uploadProfile($request);
                }
                try {
                    DB::beginTransaction();
                    $user = User::create([
                        "name" => $request->EMP_Name,
                        "email" => $request->email,
                        "password" => $password,
                        "role" => 3,
                        "Status" => 1
                    ]);
                    if (!is_null($user)) {
                        $id = $user->id;

                        $employee = Employee::create([
                            'EMP_ID' => $user->id,
                            'EMP_Name' => $request->EMP_Name,
                            'EMP_Designation' => $request->EMP_Designation,
                            "EMP_Email" => $request->EMP_Email,
                            "EMP_Qualification" => $request->EMP_Qualification,
                            "EMP_MobileNumber" => $request->EMP_MobileNumber,
                            "EMP_CompanyMobile" => $request->EMP_CompanyMobile,
                            "EMP_Address" => $request->EMP_Address,
                            "EMP_TechnicalAbilities" => $request->EMP_TechnicalAbilities,
                            "EMP_Code" => $request->EMP_Code,
                            "EMP_CPRUpload" => $upload,
                            "Profile_Image" => $uploadProfile,
                            "EMP_Status" => 1,
                            "EMP_Created_By" => $request->created_by,
                            "Access_Role" => $request->Access_Role,
                            "password" => $request->password
                        ]);
                        if ($employee) {
                            try {
                                $action = "Employee Added, Name:" . $request->Employee_Name . " Email:" . $request->EMP_Email;
                                $log = App(\App\Http\Controllers\LogController::class);
                                $subject = "Login Details For IWS Services";
                                $mailsetting = MailSetting::where("id", 1)->first();
                                $accountsetting = Account_Setting::where("id", 1)->first();
                                if ($mailsetting->employee_add_mail_allowed) {
                                    $body = "Dear " . $request->Employee_Name . ",<br/><br/>";
                                    $body .= $mailsetting->employee_add_template . "<br/><br/>";
                                    $body .= "Login Email : " . $request->email . "<br/> Login Password : " . $request->password;
                                    $body .= "<br/><br/>" . $accountsetting->mail_signature;
                                    $mail = new MailController;
                                    $mail->SendMail($request->email, $subject, $body);
                                }

                                $log->SystemLog(null, $action);
                                DB::commit();
                                return Redirect("employees")->with("success", "Employee added!");
                            } catch (Exception $exp) {
                                DB::rollBack();
                                return back()
                                    ->withInput()
                                    ->withErrors($exp->getMessage());
                            }

                            // return response()->json(['success' => true, 'message' => 'Employee Created.']);
                        } else {
                            DB::rollBack();
                            return back()
                                ->withInput()
                                ->withErrors("Action failed, try again");
                            // return response()->json(['success' => false, 'message' => 'Action failed, Try again.']);
                        }


                    } else {
                        return back()
                            ->withInput()
                            ->withErrors("Action failed, Try again");
                        // return response()->json(['success' => false, 'message' => 'Action failed, Try again.']);
                    }
                } catch (Exception $ex) {
                    DB::rollBack();
                    return back()
                        ->withInput()
                        ->withErrors($ex->errorInfo);
                    // return response()->json(['success' => false, 'message' => $ex->errorInfo]);
                }

            } else {
                return response()->json(['success' => false, 'message' => 'User already added with the email!']);
            }
        } catch (Illuminate\Database\QueryException $ex) {
            User::where('id', $id)->delete();
            return response()->json(['success' => false, 'message' => $ex->errorInfo]);
        }

        //return response()->json($engineer);
    }

    public function CPRUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "cpr" => "required",
                "path" => "required",
                "EMP_Name" => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "* marked fields required.", "validation_error" => $validator->errors()]);
        }
        $upload = $this->uploadCPR($request);
        if ($upload != "") {
            $update = Employee::where("EMP_ID", $request->EMP_ID)
                ->update([
                    'EMP_CPRNumber' => $request->cpr,
                    'EMP_CPRUpload' => $upload,
                ]);
            if ($upload) {
                return response()->json(["success" => true, "message" => "updated"]);
            } else {
                return response()->json(["success" => false, "message" => "update failed, try again."]);
            }
        } else {
            return response()->json(["success" => false, "message" => "update failed, try again."]);
        }




    }
    public function uploadCPR($request)
    {
        $imagesName = "";
        if ($request->has('path')) {
            $image = $request->path;
            $empName = str_replace(' ', '', $request->EMP_Name);
            $image_path = "/images/Employee/CPR/cpr_" . $empName . '.png';
            $imagesName = "/app/public" . $image_path;
            $path = storage_path() . $imagesName;
            if (file_exists($path)) {
                unlink($path);
            }
            $img = substr($image, strpos($image, ",") + 1);
            $data = base64_decode($img);
            //  print_r($img);
            //exit;
            $success = file_put_contents($path, $data);
            if ($success) {
                $imagesName = "/storage" . $image_path;
            } else {
                $imagesName = "";
            }

        } else {
            $imagesName = "";
        }
        return $imagesName;
    }
    public function PicUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "EMP_Name" => "required",
                "EMP_Profile_Path" => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "* marked fields required.", "validation_error" => $validator->errors()]);
        }
        $upload = $this->uploadProfile($request);
        if ($upload != "") {
            $update = Employee::where("EMP_ID", $request->EMP_ID)
                ->update([
                    'Profile_Image' => $upload,
                ]);
            if ($upload) {
                return response()->json(["success" => true, "message" => "updated"]);
            } else {
                return response()->json(["success" => false, "message" => "update failed, try again."]);
            }
        } else {
            return response()->json(["success" => false, "message" => "update failed, try again."]);
        }

    }
    public function uploadProfile($request)
    {
        $imagesName = "";
        if ($request->has('EMP_Profile_Path')) {
            $image = $request->EMP_Profile_Path;
            $empName = str_replace(' ', '', $request->EMP_Name);
            $image_path = "/images/Employee/Avatars/Avatar_" . $empName . '.png';
            $imagesName = "/app/public" . $image_path;
            $path = storage_path() . $imagesName;
            if (file_exists($path)) {
                unlink($path);
            }
            $img = substr($image, strpos($image, ",") + 1);
            $data = base64_decode($img);
            $success = file_put_contents($path, $data);
            if ($success) {
                $imagesName = "/storage" . $image_path;
            } else {
                $imagesName = "";
            }
        } else {
            $imagesName = "";
        }
        return $imagesName;
    }
    public function ResetPassword(Request $request, Employee $employee)
    {
        $password = Hash::make($request->password);
        $update = User::where("id", $request->employee_id)
            ->update([
                "password" => $password
            ]);
        if ($update) {
            $user = User::where("id", $request->employee_id)->first();
            $action = "Password Reset, User Email:" . $user->email;
            $log = App(\App\Http\Controllers\LogController::class);
            $log->SystemLog($request->loginId, $action);
            return response()->json(["success" => true, "message" => "password updated."]);
        } else {
            return response()->json(["success" => false, "message" => "password update failed, try again."]);
        }
    }
    public function DeActivate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "mode" => "required",
                "EMP_ID" => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "* marked fields required.", "validation_error" => $validator->errors()]);
        }
        $log = App(\App\Http\Controllers\LogController::class);
        $update = User::where("id", $request->EMP_ID)
            ->update([
                "status" => $request->mode
            ]);
        if ($update) {

            $status = $request->mode == 0 ? "Deactivated" : "Activated";
            $user = User::where("id", $request->EMP_ID)->first();
            $action = "User Status changed for Email: " . $user->email . ", Status " . $status;
            $log = App(\App\Http\Controllers\LogController::class);
            $log->SystemLog($request->loginId, $action);
            return response()->json(["success" => true, "message" => "updated."]);
        } else {
            return response()->json(["success" => false, "message" => "password update failed, try again."]);
        }
    }
    function deleteEngineer(Request $request)
    {

        $engId = $request->engId;
        $loginId = $request->loginId;
        if ($engId != 0 && $loginId != 0 && $engId != "" && $loginId != "") {
            $isuniq = Engineer::join("users", "users.id", "engineers.User_Id")->where("engineers.User_Id", $engId)->where("engineers.Client_Id", $loginId)->first();
            if (!is_null($isuniq)) {
                $isdelete1 = Engineer::where("engineers.User_Id", $engId)->where("engineers.Client_Id", $loginId)->delete();
                if ($isdelete1) {
                    $isdelete2 = User::where("id", $engId)->delete();
                    if ($isdelete2) {

                        return response()->json(['success' => true, 'message' => 'Engineer deleted.']);
                    } else {
                        $restoreDataId = Engineer::withTrashed()->find("User_Id", $loginId);
                        if ($restoreDataId && $restoreDataId->trashed()) {
                            $restoreDataId->restore();
                        }
                        return response()->json(["code" => 500, 'success' => false, 'message' => 'Action failed, Try again.']);
                    }
                } else {

                }
            } else {
                return response()->json(["code" => 500, 'success' => false, 'message' => 'Engineer not found, Try again.']);
            }
        } else {
            return response()->json(['success' => false, 'message' => "Invalid inputs, Try again."]);
        }
    }

}