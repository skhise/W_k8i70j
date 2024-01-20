<?php
namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\DateTime;
use App\Models\User;
use App\Models\Customer;
use App\Models\CustomerContact;
use App\Models\CustomerSites;
use App\Models\AreaName;
use App\Models\MailSetting;
use App\Models\Contract;
use App\Models\Service;
use App\Models\Account_Setting;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    private $status_code = 200;

    public function __construct()
    {


    }
    public function index(Request $request)
    {

        return view("clients.index", [
            'filters' => $request->all('search', 'trashed', 'search_field'),
            'search_field' => $request->search_field ?? '',
            'search' => $request->search ?? '',
            'clients' => Client::orderBy('CST_ID', "DESC")
                ->filter($request->only('search', 'trashed', 'search_field'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn($client) => [
                    'id' => $client->CST_ID,
                    'client_code' => $client->CST_Code,
                    'phone' => $client->CCP_Mobile,
                    'email' => $client->CCP_Email,
                    'department' => $client->CCP_Department,
                    'client_name' => $client->CST_Name,
                    'deleted_at' => $client->deleted_at,
                ]),
        ]);

    }
    public function view(Client $client)
    {
        $client_type = "";
        if ($client->client_type == 1) {
            $client_type = "Business";
        }
        if ($client->client_type == 2) {
            $client_type = "Individual";
        }
        return view('clients/view', [
            'client' => $client,
            'contacts' => [],
            'customer_type' => "",
            'type' => "",
            'project_count' => 0,

        ]);
    }
    public function create(Request $request)
    {
        $client = Client::all()->last();
        $code = 1;
        if (!empty($client)) {
            $code = $client->id + 1;
        }
        return view('clients.create', [
            "states" => [],
            "country" => [],
            'client_code' => $code,
            'update' => false,
            'client' => new Client(),
            "customer_type" => [],
        ]);
    }
    public function GetAccountSettings()
    {
        $accountsetting = Account_Setting::where("id", 1)->first();
        return $accountsetting;
    }
    public function DeleteCustomer(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => "required",
                'CST_Name' => "required",

            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "Service information missing.", "validation_error" => $validator->errors()]);
        }
        $isService = $this->CheckIfServiceCall($request->id);
        $isContract = $this->CheckIfContract($request->id);
        if ($isService && $isContract) {
            $update = Customer::find($request->id)->update(['CST_Status' => 0]);
            if ($update) {
                $action = "Customer Deleted,  CST_Name:" . $request->CST_Name;
                $log = App(\App\Http\Controllers\LogController::class);
                $log->SystemLog($request->loginId, $action);
                return response()->json(["success" => true, "message" => "Customer Deleted."]);
            } else {
                return response()->json(["success" => true, "message" => "Action failed, try again."]);
            }

        } else {
            return response()->json(["success" => false, "message" => "Customer contract or service call is active."]);
        }
    }
    public function CheckIfServiceCall($id)
    {
        $count = Service::where("customer_id", $id)->count();
        if ($count) {
            return false;
        }
        return true;
    }
    public function CheckIfContract($id)
    {
        $count = Contract::where("CNRT_CustomerID", $id)->count();
        if ($count) {
            return false;
        }
        return true;

    }
    public function DeleteUser($Emp_Id)
    {
        $isDelete = User::find($Emp_Id)->delete();
        if ($isDelete) {
            return true;
        } else {
            return false;
        }
    }
    public function AddCustomerContact(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "CustomerId" => "required",
                "CNT_Name" => "required",
                "CNT_Mobile" => "required",


            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "all * marked fields required.", "validation_error" => $validator->errors()]);
        }
        $customerContact = CustomerContact::create([
            "CST_ID" => $request->CustomerId,
            'CNT_Name' => $request->CNT_Name,
            'CNT_Mobile' => $request->CNT_Mobile,
            'CNT_Department' => $request->CNT_Department,
            'CNT_Email' => $request->CNT_Email,
            'CNT_Phone1' => $request->CNT_Phone1,
            'CNT_Phone2' => ''
        ]);
        if ($customerContact) {
            return response()->json(["success" => true, "message" => "contact added."]);
        } else {
            return response()->json(["success" => false, "message" => "action failed, try again."]);
        }

    }
    public function UpdateCustomerContact(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "CustomerId" => "required",
                "ContactId" => "required",
                "CNT_Name" => "required",
                "CNT_Mobile" => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "all * marked fields required.", "validation_error" => $validator->errors()]);
        }
        $customerContact = CustomerContact::where("CNT_ID", $request->ContactId)->where("CST_ID", $request->CustomerId)->update([
            'CNT_Name' => $request->CNT_Name,
            'CNT_Mobile' => $request->CNT_Mobile,
            'CNT_Department' => $request->CNT_Department,
            'CNT_Email' => $request->CNT_Email,
            'CNT_Phone1' => $request->CNT_Phone1,
            'CNT_Phone2' => ''
        ]);
        if ($customerContact) {
            return response()->json(["success" => true, "message" => "Contact Updated."]);
        } else {
            return response()->json(["success" => false, "message" => "action failed, try again."]);
        }

    }
    public function AddCustomerSite(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "CustomerId" => "required",
                "SiteName" => "required",
                "SiteArea" => "required",


            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "all * marked fields required.", "validation_error" => $validator->errors()]);
        }
        $customerSite = CustomerSites::create([
            'CustomerId' => $request->CustomerId,
            'SiteNumber' => $request->SiteNumber,
            'SiteName' => $request->SiteName,
            'AreaName' => $request->SiteArea,
            'SiteOther' => $request->SiteOther,
        ]);
        if ($customerSite) {
            return response()->json(["success" => true, "message" => "site added."]);
        } else {
            return response()->json(["success" => false, "message" => "action failed, try again."]);
        }

    }
    public function UpdateCustomerSite(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "CustomerId" => "required",
                "SiteId" => "required",
                "SiteName" => "required",
                "SiteArea" => "required",


            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "all * marked fields required.", "validation_error" => $validator->errors()]);
        }
        $customerSite = CustomerSites::where("id", $request->SiteId)->where("CustomerId", $request->CustomerId)->update([
            'SiteNumber' => $request->SiteNumber,
            'SiteName' => $request->SiteName,
            'AreaName' => $request->SiteArea,
            'SiteOther' => $request->SiteOther,
        ]);
        if ($customerSite) {
            return response()->json(["success" => true, "message" => "Site Updated."]);
        } else {
            return response()->json(["success" => false, "message" => "action failed, try again."]);
        }

    }
    public function GetAreaNameMaster(Request $request)
    {
        $areaname = array();
        $areaname = AreaName::all();
        return $areaname;
    }
    public function GetCustomerSites(Request $request)
    {

        $customersites = array();
        try {
            $id = $request->id;
            $customersites = CustomerSites::
                join("customers", "customers.CST_ID", "customer_sites.CustomerId")
                ->join("master_site_area", "master_site_area.id", "customer_sites.AreaName")
                ->where("customers.CST_ID", $id)->get(["customer_sites.*", "customer_sites.id as SiteId", "customers.*", "master_site_area.*"]);
        } catch (Illuminate\Database\QueryException $ex) {
            $ex->errorInfo;
        }
        return $customersites;

    }
    public function GetCustomerContacts(Request $request)
    {

        $customercontacts = array();
        try {
            $id = $request->id;
            $customercontacts = Customer::join("customer_contact", "customer_contact.CST_ID", "customers.CST_ID")
                ->where("customers.CST_ID", $id)->get();
        } catch (Illuminate\Database\QueryException $ex) {
            $ex->errorInfo;
        }
        return $customercontacts;

    }
    function GetCustomers()
    {

        $customers = array();
        try {
            $customers = Customer::leftJoin("employees", "employees.EMP_ID", "customers.Ref_Employee")
                ->where("customers.CST_Status", "1")->orderBy("customers.CST_ID", "DESC")->get();
            foreach ($customers as $customer) {
                $customer->View = "/customers/view?id=" . $customer->CST_ID;
                $customer->Edit = "/customers/edit?id=" . $customer->CST_ID;
            }
        } catch (Illuminate\Database\QueryException $ex) {
            $ex->errorInfo;
        }
        return $customers;
    }
    public function GetCustomerCode()
    {

        $cust_code = "";
        $last = Customer::latest()->first();
        $accountsetting = $this->GetAccountSettings();
        $cust_code = $accountsetting->customer_ins;
        $cust_code = isset($cust_code) ? $cust_code : "CST";

        if (is_null($last)) {
            $cust_code = $cust_code . "001";
        } else {
            $lastNumber = $last->CST_Code;
            $array = explode($cust_code, $lastNumber);
            $num = $array[1];
            $num = $num + 1;
            $cust_code = $cust_code . "00" . $num;

        }
        return $cust_code;

    }
    function UpdateCustomer(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "CST_Code" => "required",
                "Customer_Name" => "required",
                "CCP_Name" => "required",
                "CCP_Mobile" => "required",

            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => $validator->errors()->first(), "validation_error" => $validator->errors()]);
        }
        try {
            $iscustomer = Customer::where("CST_ID", $request->CST_ID)->first();
            if (!is_null($iscustomer)) {
                $customer = Customer::where("CST_ID", $request->CST_ID)->update([
                    'CST_Name' => $request->Customer_Name,
                    'CST_Website' => $request->CST_Website,
                    'CST_OfficeAddress' => $request->CST_OfficeAddress,
                    'CST_SiteAddress' => $request->CST_SiteAddress,
                    'CST_Note' => $request->CST_Note,
                    'CCP_Name' => $request->CCP_Name,
                    'CCP_Mobile' => $request->CCP_Mobile,
                    'CCP_Department' => $request->CCP_Department,
                    'CCP_Email' => $request->CCP_Email,
                    'CCP_Phone1' => $request->CCP_Phone1,
                    'CCP_Phone2' => $request->CCP_Phone2,
                    "Ref_Employee" => $request->Ref_Employee,
                ]);
                if ($customer) {
                    $action = "Customer Updated, Id:" . $request->CST_ID . ", CST_Name:" . $request->Customer_Name;
                    $log = App(\App\Http\Controllers\LogController::class);
                    $log->SystemLog($request->loginId, $action);
                    return response()->json(["success" => true, "message" => "Customer updated."]);

                } else {
                    return response()->json(["success" => false, "message" => "Actin failed, Try again."]);
                }
            } else {
                return response()->json(["success" => false, "message" => "Customer not found."]);
            }



        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => false, 'message' => "Exception:" . $ex->errorInfo]);
        }
    }
    function addCustomer(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "CST_Code" => "required|unique:customers",
                "Customer_Name" => "required|unique:customers,CST_Name",
                "CCP_Name" => "required",
                "CCP_Mobile" => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => $validator->errors()->first(), "validation_error" => $validator->errors()]);
        }
        try {
            $uniqId = $this->GetCustomerCode();
            $isOk = 0;
            if (isset($request->contacts) && sizeof($request->contacts) > 0) {
                $contacts = $request->contacts;
                foreach ($contacts as $contact) {
                    if ($contact['CNT_Name'] == "" || $contact['CNT_Mobile'] == "") {
                        return response()->json(["success" => false, "message" => "customer contact information missing."]);
                    } else {
                        $isOk = 1;
                    }
                }
            } else if (isset($request->customersites) && sizeof($request->customersites) > 0) {
                $customersites = $request->customersites;
                foreach ($customersites as $customersite) {
                    if ($customersite['Site_Name'] == "") {
                        return response()->json(["success" => false, "message" => "customer site information missing."]);
                    } else {
                        $isOk = 1;
                    }
                }
            } else {
                $isOk = 1;
            }
            if ($isOk == 1) {

                $iscustomer = Customer::where("CST_Code", $uniqId)->first();
                if (is_null($iscustomer)) {
                    try {
                        $ref = 0;
                        if ($request->Ref_Employee != "") {
                            $ref = $request->Ref_Employee;
                        }
                        DB::beginTransaction();
                        $customer = Customer::create([
                            'CST_Code' => $uniqId,
                            'CST_Name' => $request->Customer_Name,
                            'CST_Website' => $request->CST_Website,
                            'CST_OfficeAddress' => $request->CST_OfficeAddress,
                            'CST_SiteAddress' => $request->CST_SiteAddress,
                            'CST_Note' => $request->CST_Note,
                            'CCP_Name' => $request->CCP_Name,
                            'CCP_Mobile' => $request->CCP_Mobile,
                            'CCP_Department' => $request->CCP_Department,
                            'CCP_Email' => $request->CCP_Email,
                            'CCP_Phone1' => $request->CCP_Phone1,
                            'CCP_Phone2' => $request->CCP_Phone2,
                            "Ref_Employee" => $ref,
                        ]);
                        if ($customer) {
                            $sites = 0;
                            $inS = 0;
                            if (isset($request->customersites) && sizeof($request->customersites) > 0) {
                                $customersites = $request->customersites;

                                foreach ($customersites as $customersite) {

                                    $contactF = CustomerSites::create([
                                        'CustomerId' => $customer->CST_ID,
                                        'SiteNumber' => $customersite['Site_Number'],
                                        'SiteName' => $customersite['Site_Name'],
                                        'AreaName' => $customersite['Site_Area'],
                                        'SiteOther' => $customersite['Site_Other'],
                                    ]);
                                    if ($contactF) {
                                        $inS++;
                                    }
                                }
                                if (sizeof($customersites) == $inS) {
                                    $sites = 1;
                                }
                            } else {
                                $sites = 1;
                            }
                            $address = 0;
                            $inC = 0;
                            if (isset($request->contacts) && sizeof($request->contacts) > 0) {
                                $contacts = $request->contacts;

                                foreach ($contacts as $contact) {

                                    $contactF = CustomerContact::create([
                                        'CST_ID' => $customer->CST_ID,
                                        'CNT_Name' => $contact['CNT_Name'],
                                        'CNT_Mobile' => $contact['CNT_Mobile'],
                                        'CNT_Department' => $contact['CNT_Department'],
                                        'CNT_Email' => $contact['CNT_Email'],
                                        'CNT_Phone1' => $contact['CNT_Phone1'],
                                        'CNT_Phone2' => ''
                                    ]);
                                    if ($contactF) {
                                        $inC++;
                                    }
                                }
                                if (sizeof($contacts) == $inC) {
                                    $address = 1;
                                }
                            } else {
                                $address = 1;
                            }
                            if ($sites == 1 && $address == 1) {
                                try {
                                    $action = "Customer created,Name:" . $request->Customer_Name . ", Email:" . $request->CCP_Email;
                                    $log = App(\App\Http\Controllers\LogController::class);
                                    $log->SystemLog($request->loginId, $action);
                                    DB::commit();
                                    return response()->json(["success" => true, "message" => "Customer created."]);
                                } catch (Exception $e) {
                                    DB::rollBack();
                                    return response()->json(["success" => false, "message" => "Actin failed, Try again."]);
                                }

                            } else {
                                DB::rollBack();
                            }
                        } else {
                            DB::rollBack();
                            return response()->json(["success" => false, "message" => "Actin failed, Try again."]);
                        }
                    } catch (Throwable $e) {
                        return response()->json(["success" => false, "message" => "Actin failed, Try again."]);
                    }


                } else {
                    return response()->json(["success" => false, "message" => "Duplicate customer code."]);
                }
            } else {
                return response()->json(["success" => false, "message" => "Customer contact details missing."]);
            }


        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => false, 'message' => "Exception:" . $ex->errorInfo]);
        }
    }
    function GetCustomerById(Request $request)
    {
        try {

            $custId = $request->ID;
            if ($custId != "" && $custId != 0) {
                $customer = Customer::where("CST_ID", $custId)
                    ->leftJoin("employees", "employees.EMP_ID", "customers.Ref_Employee")
                    ->first();
                return response()->json(['success' => true, 'message' => '', 'customer' => $customer]);
            } else {
                return response()->json(['success' => false, 'message' => 'Invalid request.', 'customer' => []]);
            }

        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => false, 'message' => '', 'customer' => null]);
        }
    }
}
