<?php
namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ContactPerson;
use App\Models\Employee;
use Exception;
use Illuminate\Database\QueryException;
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
use Redirect;
use Throwable;

class ClientController extends Controller
{
    private $status_code = 200;
    public $status = [
        "1" => '<div class="badge badge-success badge-shadow">Active</div>',
        "2" => '<div class="badge badge-danger badge-shadow">De-Active</div>',
    ];
    public function __construct()
    {


    }
    public function index(Request $request)
    {

        return view("clients.index", [
            'filters' => $request->all('search', 'trashed', 'search_field', 'filter_status'),
            'search_field' => $request->search_field ?? '',
            'filter_status' => $request->filter_status ?? '',
            'status'=>$this->status,
            'search' => $request->search ?? '',
            'clients' => Client::orderBy('updated_at', "DESC")
                ->filter($request->only('search', 'trashed', 'search_field', 'filter_status'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn($client) => [
                    'id' => $client->CST_ID,
                    'client_code' => $client->CST_Code,
                    'CST_Status' => $client->CST_Status,
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
            'contacts' => ContactPerson::where('CST_ID', $client->CST_ID)->get(),
            'customer_type' => "",
            'type' => "",
            'project_count' => 0,

        ]);
    }
    public function DeleteContact(Request $request, ContactPerson $contactPerson)
    {
        $contactPerson = ContactPerson::where('CNT_ID', $contactPerson->CNT_ID)->delete();
        return redirect()->back()->with('success', 'Deleted.');

    }

    public function delete(Client $client)
    {
        $contracts = $client->contracts;
        if (count($contracts) == 0) {
            $client->delete();
            return redirect()->back()->with('success', 'Deleted.');
        } else {
            return redirect()->back()->with('error', 'Can\'t delete, Client have active contracts.');
        }
    }
    public function update(Request $request, Client $client)
    {
        $request->validate([
            "Customer_Name" => ["required|unique:clients,CST_Name"],
            "CCP_Mobile" => ["required"],
            'updated_by' => ['required'],
        ], [
            'CCP_Name.required' => 'Contcat person name required!',
            'CCP_Mobile.required' => 'Contcat person phone required!',
            'CCP_Email.email' => 'Valid email required!'
        ]);

        $update = $client->update($request->all());
        if ($update) {
            return Redirect::route('clients')->with('success', 'Client updated.');
        }
        return redirect()->back()->with('error', 'Something went wrong, try again.');


    }
    public function edit(Client $client)
    {

        return view('clients.create', [
            'client_code' => $client->CST_Code,
            'update' => true,
            'client' => $client,
            "refrences" => Employee::all(),
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
            'client_code' => $code,
            'update' => false,
            'client' => new Client(),
            "refrences" => Employee::all(),
        ]);
    }
    function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "CST_Name" => "required|unique:clients,CST_Name",
                "CCP_Mobile" => "required",
            ],
            [
                'CST_Name.required' => 'Contcat person name required!',
                'CCP_Mobile.required' => 'Contcat person mobile required!',

            ]
        );
        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator->messages());
        }
        try {
            $uniqId = $this->GetCustomerCode();
            $isOk = 1;
            // dd($request->CNT_Name);
            // $CNT_Name = $request->CNT_Name ?? [];
            // foreach ($CNT_Name as $index => $row) {
            //     if (empty($CNT_Name[$index])) {
            //         $ok = 0;
            //         return back()
            //             ->withInput()
            //             ->withErrors("Contact person information missing.");
            //     }
            // }
            if ($isOk == 1) {

                $iscustomer = Client::where("CST_Code", $uniqId)->first();
                if (is_null($iscustomer)) {
                    try {
                        $ref = 0;
                        if ($request->Ref_Employee != "") {
                            $ref = $request->Ref_Employee;
                        }
                        DB::beginTransaction();
                        $customer = Client::create([
                            'CST_Code' => $uniqId,
                            'CST_Name' => $request->CST_Name,
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
                            'gst_no' => $request->gst_no,
                            'pan_no' => $request->pan_no,
                            "Ref_Employee" => $ref,
                        ]);
                        if ($customer) {

                            $CNT_Name = $request->CNT_Name ?? [];
                            $CNT_Mobile = $request->CNT_Mobile ?? [];
                            $CNT_Department = $request->CNT_Department ?? [];
                            $CNT_Email = $request->CNT_Email ?? [];
                            $CNT_Phone1 = $request->CNT_Phone1 ?? [];

                            foreach ($CNT_Name as $index => $row) {
                                $CNTName = $CNT_Name[$index];
                                $CNTMobile = $CNT_Mobile[$index];
                                $CNTDepartment = $CNT_Department[$index];
                                $CNTEmail = $CNT_Email[$index];
                                $CNTPhone1 = $CNT_Phone1[$index];

                                if ($CNTName != null) {
                                    ContactPerson::create([
                                        "CST_ID" => $customer->CST_ID,
                                        "CNT_Name" => $CNTName,
                                        "CNT_Mobile" => $CNTMobile,
                                        "CNT_Department" => $CNTDepartment,
                                        "CNT_Email" => $CNTEmail,
                                        "CNT_Phone1" => $CNTPhone1,
                                        "CNT_Phone2" => ''
                                    ]);
                                }
                            }
                            DB::commit();
                            return Redirect("clients")->with("success", "Client added!");
                        } else {
                            DB::rollBack();
                            return back()
                                ->withInput()
                                ->withErrors("Actin failed, Try again. 1");
                        }
                    } catch (Throwable $e) {
                        DB::rollBack();
                        return back()
                            ->withInput()
                            ->withErrors("Actin failed, Try again. " . $e->getMessage());
                    }
                } else {
                    return back()
                        ->withInput()
                        ->withErrors("Duplicate customer code.");
                }
            } else {
                return back()
                    ->withInput()
                    ->withErrors("Check contact person information");
            }


        } catch (Exception $ex) {
            return back()
                ->withInput()
                ->withErrors($ex->getMessage());
        }
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
    public function add_cp(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "CNT_Name" => "required",
                "CNT_Mobile" => "required",
                "CNT_ID" => "required"


            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "all * marked fields required.", "validation_error" => $validator->errors()]);
        }
        if ($request->CNT_ID == 0) {
            $customerContact = ContactPerson::create([
                "CST_ID" => $id,
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
        } else if ($request->CNT_ID > 0) {
            $customerContact = ContactPerson::where("CNT_ID", $request->CNT_ID)->where("CST_ID", $id)->update([
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
        $last = Client::latest()->first();
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



        } catch (QueryException $ex) {
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
