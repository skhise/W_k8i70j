<?php

namespace App\Http\Controllers;

use App\Exports\ContractExport;
use App\Exports\DcExport;
use App\Exports\QuotExport;
use App\Exports\ServiceExport;
use App\Exports\ServiceStatusExport;
use App\Exports\SweviceExport;
use App\Exports\UsersExport;
use App\Models\Attendance;
use App\Models\Client;
use App\Models\ContractScheduleService;
use App\Models\ContractStatus;
use App\Models\ContractUnderProduct;
use App\Models\DcType;
use App\Models\ProductType;
use App\Models\Quotation;
use App\Models\QuotationStatus;
use App\Models\QuotationType;
use App\Models\ServiceDc;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ContractSiteType;
use App\Models\ContractType;
use App\Models\Schedule;
use App\Models\Product_Accessory;
use App\Models\ContractBaseProduct;
use App\Models\ContractBaseAccessory;
use App\Models\ContractScheduleModel;
use Illuminate\Support\Facades\Hash;
use App\Models\ServiceType;
use App\Models\IssueType;
use App\Models\Service;
use App\Models\Priority;
use App\Models\ServiceAccessory;
use App\Models\ServiceHistory;
use App\Models\ActionReason;
use App\Models\ServiceStatus;
use App\Models\ServiceFieldReport;
use App\Models\SystemLog;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Storage;
use Illuminate\Support\Facades\Auth;


class ReportController extends Controller
{

    public $status = [
        "1" => '<div class="badge badge-success badge-shadow">Active</div>',
        "2" => '<div class="badge badge-info badge-shadow">Renewal</div>',
        "3" => '<div class="badge badge-danger badge-shadow">Expired</div>',
        "4" => '<div class="badge badge-danger badge-shadow">Deactivated</div>',
    ];

    function Attendance(Request $request)
    {

        $todate = date("Y-m-d");
        $fromdate = $todate;

        $attendance = Attendance::select(["users.*", "attendance.*"])
            ->join("users", "users.id", "attendance.User_ID")
            ->whereBetween(DB::raw('DATE_FORMAT(attendance.created_at, "%Y-%m-%d")'), [$fromdate, $todate])
            ->orderBy('attendance.id', 'desc')
            ->paginate(10);
        $employee = Employee::where(["EMP_Status" => 1, "Access_Role" => 4, 'deleted_at' => null])->get();
        return view("reports.attendance.attendance", [
            "employees" => $employee,
            "selected_employee" => 0,
            "attendance" => $attendance,
        ]);
    }
    public function Atte_Data(Request $request)
    {
        $attendance = null;
        $date_range = $request->date_range;
        $user_id = $request->user_id;
        $today = date("Y-m-d");
        $todate = date("Y-m-d");
        $fromdate = date('Y-m-d', strtotime($todate . '-' . $date_range . ' days'));
        $date_range = $date_range == "" ? 0 : $date_range;
        if ($date_range == 0) {
            $fromdate = $todate;
        }
        if ($date_range == 1) {
            $todate = date('Y-m-d', strtotime($today . '-1 days'));
            $fromdate = date('Y-m-d', strtotime($today . '-1 days'));
        }

        try {
            $attendance = Attendance::select(["users.*", "attendance.*"])
                ->join("users", "users.id", "attendance.User_ID")
                ->whereBetween(DB::raw('DATE_FORMAT(attendance.created_at, "%Y-%m-%d")'), [$fromdate, $todate])
                ->when($user_id != "", function ($query) use ($user_id) {
                    $query->where("attendance.User_ID", $user_id);
                })
                ->orderBy('attendance.id', 'desc')
                ->paginate(10);
        } catch (Exception $exp) {
        }

        if ($request->ajax()) {
            return view('reports.attendance.atten_pagination', compact('attendance', 'date_range'));
        }
        return view('reports.attendance.attendance', compact('attendance'));
    }
    function Logs(Request $request)
    {

        $todate = date("Y-m-d");
        $fromdate = $todate;

        $systemlogs = SystemLog::select(["users.*", "systemlogs.*"])
            ->join("users", "users.id", "systemlogs.loginId")
            ->whereBetween(DB::raw('DATE_FORMAT(systemlogs.created_at, "%Y-%m-%d")'), [$fromdate, $todate])
            ->orderBy('systemlogs.id', 'desc')
            ->paginate(10);
        return view("reports.logs", [
            "systemlogs" => $systemlogs,
        ]);
    }
    public function Logs_Data(Request $request)
    {
        $systemlogs = null;
        $date_range = $request->date_range;
        $today = date("Y-m-d");
        $todate = date("Y-m-d");
        $fromdate = date('Y-m-d', strtotime($todate . '-' . $date_range . ' days'));
        $date_range = $date_range == "" ? 0 : $date_range;
        if ($date_range == 0) {
            $fromdate = $todate;
        }
        if ($date_range == 1) {
            $todate = date('Y-m-d', strtotime($today . '-1 days'));
            $fromdate = date('Y-m-d', strtotime($today . '-1 days'));
        }

        try {
            $systemlogs = SystemLog::join("users", "users.id", "systemlogs.loginId")
                ->when($date_range != "" && $date_range != -1, function ($query) use ($todate, $fromdate) {
                    return $query->whereBetween(DB::raw('DATE_FORMAT(systemlogs.created_at, "%Y-%m-%d")'), [$fromdate, $todate]);

                })
                ->orderBy('systemlogs.id', 'desc')
                ->paginate(10);
        } catch (Exception $exp) {
        }
        if ($request->ajax()) {
            return view('reports.log_pagination', compact('systemlogs', 'date_range'));
        }
        return view('reports.logs', compact('systemlogs'));
    }
    function dc_index(Request $request)
    {
        $dc_products = ServiceDc::select(["contracts.*", "dc_type.*", "clients.*", "services.*", "service_dc.id as dcp_id", "service_dc.*"])
            ->join("services", "services.id", "service_dc.service_id")
            ->leftJoin("dc_type", "dc_type.id", "service_dc.dc_type")
            ->leftJoin("clients", "clients.CST_ID", "services.customer_id")
            ->leftJoin("contracts", "contracts.CNRT_ID", "services.contract_id")
            ->when(isset($request->customer_id), function ($query) use ($request) {
                $query->where("services.customer_id", $request->customer_id);
            })
            ->when(isset($request->type), function ($query) use ($request) {
                $query->where("service_dc.dc_type", $request->type);
            })
            ->paginate(10)
            ->withQueryString();
        // dd($dc_products);
        return view("reports.dc_report", [
            "service_dcs" => $dc_products,
            'clients' => Client::all(),
            'customer_id' => isset($request->customer_id) ? $request->customer_id : 0,
            'dc_type' => isset($request->type) ? $request->type : 0,
            'type' => DcType::all()
        ]);
    }
    function dc_export(Request $request)
    {
        $dc_products = ServiceDc::select(["contracts.*", "dc_type.*", "clients.*", "services.*", "service_dc.id as dcp_id", "service_dc.*"])
            ->join("services", "services.id", "service_dc.service_id")
            ->leftJoin("dc_type", "dc_type.id", "service_dc.dc_type")
            ->leftJoin("clients", "clients.CST_ID", "services.customer_id")
            ->leftJoin("contracts", "contracts.CNRT_ID", "services.contract_id")
            ->when(isset($request->customer_id), function ($query) use ($request) {
                $query->where("services.customer_id", $request->customer_id);
            })
            ->when(isset($request->type), function ($query) use ($request) {
                $query->where("service_dc.dc_type", $request->type);
            })
            ->paginate(10)
            ->withQueryString();
        $items = $dc_products->map(function ($quot) {
            return [
                'client_name' => $quot->CST_Name, // Replace with actual field or accessor
                'contract_no' => $quot->CNRT_Number, // Replace with actual field or accessor
                'service_no' => $quot->service_no, // Replace with actual field or accessor
                'total_qty' => $quot->totalProduct($quot->dcp_id), // Custom accessor or method
                'total_amount' => $quot->dc_amount, // Custom accessor or method
                'issue_date' => $quot->issue_date, // Custom accessor or method
                'type' => $quot->dc_type_name, // Example field
            ];
        })->toArray();

        $fileName = 'report_file' . time() . '.csv';

        return Excel::download(new DcExport($items), $fileName)->deleteFileAfterSend(true);
    }
    function quotation_index(Request $request)
    {
        $service_quots = Quotation::select(["master_quotation_status.*", "master_quotation_type.*", "clients.*", "quotation.id as dcp_id", "quotation.*"])
            ->leftJoin("master_quotation_type", "master_quotation_type.id", "quotation.quot_type")
            ->leftJoin("master_quotation_status", "master_quotation_status.id", "quotation.quot_status")
            ->leftJoin("clients", "clients.CST_ID", "quotation.customer_id")
            ->when(isset($request->customer_id), function ($query) use ($request) {
                $query->where("quotation.customer_id", $request->customer_id);
            })
            ->when(isset($request->status), function ($query) use ($request) {
                $query->where("quotation.quot_status", $request->status);
            })
            ->when(isset($request->type), function ($query) use ($request) {
                $query->where("quotation.quot_type", $request->custtypeomer_id);
            })
            ->paginate(10)
            ->withQueryString();
        // dd($dc_products);
        return view(
            "reports.quot_report",
            [
                "service_quots" => $service_quots,
                'clients' => Client::all(),
                'customer_id' => isset($request->customer_id) ? $request->customer_id : 0,
                'quot_status' => isset($request->status) ? $request->status : 0,
                'quot_type' => isset($request->type) ? $request->type : 0,
                'status' => QuotationStatus::all(),
                'type' => QuotationType::all()
            ]
        );
    }
    public function cr_export(Request $request)
    {
        $customer = $request->customer;
        $status = $request->status;

        $contracts = Contract::join("master_contract_type", "master_contract_type.id", "contracts.CNRT_Type")
            ->join("master_site_type", "master_site_type.id", "contracts.CNRT_SiteType")
            ->join("master_contract_status", "master_contract_status.id", "contracts.CNRT_Status")
            ->leftJoin("clients", "clients.CST_ID", "contracts.CNRT_CustomerID")
            ->leftJoin("master_site_area", "master_site_area.id", "contracts.CNRT_Site")
            ->when($customer != 0, function ($query) use ($customer) {
                $query->where("CNRT_CustomerID", $customer);
            })
            ->when($status != 0 && $status != "", function ($query) use ($status) {
                $query->where("CNRT_Status", $status);
            })
            ->orderBy('contracts.updated_at', "DESC")->get(['CNRT_Number', "contract_type_name", "CST_Name", "CNRT_RefNumber", "SiteAreaName", "CNRT_Charges", "CNRT_Charges_Paid", "CNRT_Charges_Pending", "CNRT_StartDate", "CNRT_EndDate", "contract_status_name"]);
        $items[] = $contracts;

        $fileName = 'report_file' . time() . '.csv';

        return Excel::download(new ContractExport($items), $fileName)->deleteFileAfterSend(true);
        // return Excel::download(new ContractExport($items), $fileName, null, [\Maatwebsite\Excel\Excel::XLSX]);

        // return response()->json(["file" => $file, "filename" => $fileName]);
    }
    public function crs_index(Contract $contract)
    {
        $contract_obj = Contract::leftJoin("master_contract_type", "master_contract_type.id", "contracts.CNRT_Type")
            ->leftJoin("master_site_type", "master_site_type.id", "contracts.CNRT_SiteType")
            ->leftJoin("master_contract_status", "master_contract_status.id", "contracts.CNRT_Status")
            ->leftJoin("clients", "clients.CST_ID", "contracts.CNRT_CustomerID")
            ->where("CNRT_ID", $contract->CNRT_ID)->first();
        $issueOptions = '<option value="">Select Type</option>';
        $issue_types = IssueType::all();
        foreach ($issue_types as $issue_type) {
            $issueOptions .= '<option value="' . $issue_type->id . '">' . $issue_type->issue_name . '</option>';
        }
        $serviceTypeOptions = '<option value="">Select Type</option>';
        $service_types = ServiceType::all();
        foreach ($service_types as $service_type) {
            $serviceTypeOptions .= '<option value="' . $service_type->id . '">' . $service_type->type_name . '</option>';
        }
        $productOptions = '<option value="">Select Product</option>';
        $products = ContractUnderProduct::where("contractId", $contract->CNRT_ID)->get();
        foreach ($products as $product) {
            $productOptions .= '<option value="' . $product->id . '">' . $product->nrnumber . '/' . $product->product_name . '</option>';
        }
        $services_schedule = ContractScheduleService::select("master_service_status.*", "contract_under_product.*", "contract_schedule_service.id as cupId", "contract_schedule_service.*", "master_issue_type.*", "master_service_type.*")->where("contract_schedule_service.contractId", $contract->CNRT_ID)
            ->leftJoin("master_issue_type", "master_issue_type.id", "contract_schedule_service.issueType")
            ->leftJoin("contract_under_product", "contract_under_product.id", "contract_schedule_service.product_Id")
            ->leftJoin("master_service_type", "master_service_type.id", "contract_schedule_service.serviceType")
            ->leftJoin("master_service_status", "master_service_status.Status_Id", "contract_schedule_service.Schedule_Status")
            ->where("contract_schedule_service.Schedule_Status", 7)->get();

        $ongoing_services = Service::select("master_service_status.*", "contract_under_product.*", "services.id as cupId", "services.*", "master_issue_type.*", "master_service_type.*")
            ->where("services.contract_id", operator: $contract->CNRT_ID)
            ->leftJoin("contract_under_product", "contract_under_product.id", "services.product_id")
            ->leftJoin("master_issue_type", "master_issue_type.id", "services.issue_type")
            ->leftJoin("master_service_type", "master_service_type.id", "services.service_type")
            ->leftJoin("master_service_status", "master_service_status.Status_Id", "services.service_status")
            ->get();
        // dd($ongoing_services);
        return view('reports.contract_summery', [
            'contract' => $contract_obj,
            'project_count' => 0,
            'status' => $this->status,
            'productType' => ProductType::all(),
            'issueType' => $issueOptions,
            'serviceType' => $serviceTypeOptions,
            'checklists' => $contract->checklist,
            'renewals' => $contract->renewals,
            'productOption' => $productOptions,
            'products' => ContractUnderProduct::where("contractId", $contract->CNRT_ID)->get(),
            'services' => $services_schedule,
            'ongoing_services' => $ongoing_services

        ]);
    }
    public function cr_index(Request $request)
    {
        $clients = Client::all();
        $status = ContractStatus::all();
        return view(
            'reports.contract',
            [
                "clients" => $clients,
                "status" => $status,
                "customer" => "",
                "contracts" => array(),
                "sstatus" => ""
            ]
        );
    }
    public function cr_data(Request $request)
    {
        $contracts = null;
        try {
            $customer = $request->customer;
            // dd($customer);
            $status = $request->status;
            $sstatus = $status;
            $contracts = Contract::join("master_contract_type", "master_contract_type.id", "contracts.CNRT_Type")
                ->join("master_site_type", "master_site_type.id", "contracts.CNRT_SiteType")
                ->join("master_contract_status", "master_contract_status.id", "contracts.CNRT_Status")
                ->leftJoin("clients", "clients.CST_ID", "contracts.CNRT_CustomerID")
                ->leftJoin("master_site_area", "master_site_area.id", "contracts.CNRT_Site")
                ->when($customer != 0, function ($query) use ($customer) {
                    $query->where("CNRT_CustomerID", $customer);
                })
                ->when($status != 0 && $status != "", function ($query) use ($status) {
                    $query->where("CNRT_Status", $status);
                })
                ->orderBy('contracts.updated_at', "DESC")
                ->paginate(10);
            // ->toSql();
            // echo $contracts;
            // die;
        } catch (Exception $exp) {

        }

        $status = $this->status;
        if ($request->ajax()) {
            return view('reports.cr_pagination', compact('contracts', 'status'));
        }
        $clients = Client::all();
        $status = ContractStatus::all();
        return view('reports.contract', compact('contracts', 'status', "clients", "customer", "sstatus"));
    }
    public function crd_index(Request $request)
    {
        $clients = Client::all();
        $status = ContractStatus::all();
        return view(
            'reports.contract_due',
            [
                "clients" => $clients,
                "status" => $status,
                "customer" => "",
                "contracts" => array(),
                "sstatus" => ""
            ]
        );
    }
    public function crd_data(Request $request)
    {
        $contracts = null;
        try {
            $date_range = $request->duein;
            $today = date("Y-m-d");
            $fromdate = date("Y-m-d");
            $todate = date('Y-m-d', strtotime($fromdate . '+' . $date_range . ' days'));
            if ($date_range == 0) {
                $fromdate = $todate;
            }
            //   dd($fromdate."---".$todate);
            $contracts = Contract::join("master_contract_type", "master_contract_type.id", "contracts.CNRT_Type")
                ->join("master_site_type", "master_site_type.id", "contracts.CNRT_SiteType")
                ->join("master_contract_status", "master_contract_status.id", "contracts.CNRT_Status")
                ->leftJoin("clients", "clients.CST_ID", "contracts.CNRT_CustomerID")
                ->leftJoin("master_site_area", "master_site_area.id", "contracts.CNRT_Site")
                ->when($date_range != "" && $date_range != -1, function ($query) use ($todate, $fromdate) {
                    return $query->whereBetween(DB::raw('DATE_FORMAT(contracts.CNRT_EndDate, "%Y-%m-%d")'), [$fromdate, $todate]);

                })
                ->orderBy('contracts.updated_at', "DESC")
                ->paginate(10);
            // ->toSql();
            // echo $contracts;
            // die;
        } catch (Exception $exp) {

        }

        $status = $this->status;
        if ($request->ajax()) {
            return view('reports.crd_pagination', compact('contracts', 'status'));
        }
        $clients = Client::all();
        $status = ContractStatus::all();
        return view('reports.contract_due', compact('contracts', 'status', "clients", "customer", "sstatus"));
    }
    public function crd_data_export(Request $request)
    {
        $contracts = null;
        try {
            $date_range = $request->duein;
            $today = date("Y-m-d");
            $fromdate = date("Y-m-d");
            $todate = date('Y-m-d', strtotime($fromdate . '+' . $date_range . ' days'));
            if ($date_range == 0) {
                $fromdate = $todate;
            }
            //   dd($fromdate."---".$todate);
            $contracts = Contract::join("master_contract_type", "master_contract_type.id", "contracts.CNRT_Type")
                ->join("master_site_type", "master_site_type.id", "contracts.CNRT_SiteType")
                ->join("master_contract_status", "master_contract_status.id", "contracts.CNRT_Status")
                ->leftJoin("clients", "clients.CST_ID", "contracts.CNRT_CustomerID")
                ->leftJoin("master_site_area", "master_site_area.id", "contracts.CNRT_Site")
                ->when($date_range != "" && $date_range != -1, function ($query) use ($todate, $fromdate) {
                    return $query->whereBetween(DB::raw('DATE_FORMAT(contracts.CNRT_EndDate, "%Y-%m-%d")'), [$fromdate, $todate]);

                })
                ->orderBy('contracts.updated_at', "DESC")
                ->get(['service_no', 'contract_id', 'CNRT_Number', 'CST_Name', 'type_name', 'issue_name', 'contact_person', 'created_at', 'now()->diffInHours($service->accepted_datetime)', 'Status_Name', 'EMP_Name', 'resolved_datetime', 'now()->diffInHours($service->created_at)', 'resolved_datetime']);

            $items[] = $contracts;

            $fileName = 'report_file' . time() . '.csv';

            return Excel::download(new ContractDueExport($items), $fileName)->deleteFileAfterSend(true);

        } catch (Exception $exp) {

        }

        $status = $this->status;
        if ($request->ajax()) {
            return view('reports.crd_pagination', compact('contracts', 'status'));
        }
        $clients = Client::all();
        $status = ContractStatus::all();
        return view('reports.contract_due', compact('contracts', 'status', "clients", "customer", "sstatus"));
    }

    public function sr_export(Request $request)
    {
        try{
        
            $customer = $request->customer;
            $status = $request->status;
            $type = $request->type;
            $daterange = $request->daterange;
            $customerId = $request->customer;
            $service_type = $request->service_type;
            $status = $request->status;
            $date_range = $request->date_range;
            $today = date("Y-m-d");
            $todate = date("Y-m-d");
            $fromdate = date('Y-m-d', strtotime($todate . '-' . $date_range . ' days'));
            if ($date_range == 0) {
                $fromdate = $todate;
            }
            if ($date_range == 1) {
                $todate = date('Y-m-d', strtotime($today . '-1 days'));
                $fromdate = date('Y-m-d', strtotime($today . '-1 days'));
            }
    
            $services = Service::select(["*","services.id as service_id"])->join("master_service_status", "master_service_status.Status_Id", "services.service_status")
                ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
                ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
                ->join("master_service_type", "master_service_type.id", "services.service_type")
                ->join("clients", "clients.CST_ID", "services.customer_id")
                ->leftJoin("contracts", "contracts.CNRT_ID", "services.contract_id")
                ->leftJoin("employees", "employees.EMP_ID", "services.assigned_to")
                ->when($customerId != 0, function ($query) use ($customerId) {
                    return $query->where('clients.CST_ID', $customerId);
                })
                ->when($service_type != 0, function ($query) use ($service_type) {
                    return $query->where('services.service_type', $service_type);
                })
                ->when($type != "", function ($query) use ($type) {
                    if ($type == 0) {
                        return $query->where('services.contract_id', 0);
                    } else {
                        return $query->where('services.contract_id', '>=', $type);
                    }
    
                })
                ->when($status != 0, function ($query) use ($status) {
                    return $query->where('services.service_status', $status);
                })
                ->when($date_range != "" && $date_range != -1, function ($query) use ($todate, $fromdate) {
                    return $query->whereBetween(DB::raw('DATE_FORMAT(services.service_date, "%Y-%m-%d")'), [$fromdate, $todate]);
    
                })
                ->orderby("services.updated_at", "DESC")->get();
                
               
            $services->map(function ($service) {

                    $servicehistory = ServiceHistory::join("master_service_status", "master_service_status.Status_Id", "=", "service_action_history.status_id")
                    ->where("service_id", $service->service_id)
                    ->orderBy("service_action_history.id", "DESC")
                    ->limit(1)
                    ->first();
                   
                    $sn = $service->nrnumber ??  $service->product_sn;
                    $pname = $service->product_name;
                    $pfn = $sn != "" ? $sn."/".$pname : $pname;
                    $service->serviceno = $service->service_no;
                    $service->CNRTType = $service->contract_id >= 1 ? 'Contracted' : 'Non-Contracted';
                    $service->CNRTNumber = $service->CNRT_Number;
                    $service->CSTName = $service->CST_Name;
                    $service->typename = $service->type_name;
                    $service->product = $pfn;
                    $service->servicenote = $service->service_note;
                    $service->responsetime = $servicehistory->created_at ?? "";
                    $service->problemreported_by_engineer = $servicehistory->action_description ?? "";
                    $service->actiontakenbyengineer = $service->timelineNH();
                    $service->StatusName = $service->Status_Name;
                    $service->contactperson = $service->contact_person;
                    $service->EMPName = $service->EMP_Name;
                    $service->resolveddatetime = $service->resolved_datetime;
                    $service->createddiffhours = $service->created_at ? now()->diffInHours($service->created_at) : null;
                    $service->closedat = $service->closed_at;
                    $service->createdat = $service->created_at;
                    $service->expenses1 = $service->expenses;
                    $service->charges2 = $service->charges;
                    $service->closenote = $service->close_note;
                    return $service;
            });    

            $items[] = $services->toArray();
            // dd($items);
            $fileName = 'report_file' . time() . '.csv';
    
            return Excel::download(new ServiceExport($items), $fileName)->deleteFileAfterSend(true);
          
        } catch(Exception $exception){
            echo "".$exception->getMessage();
            return false;
        }
          // return Excel::download(new ContractExport($items), $fileName, null, [\Maatwebsite\Excel\Excel::XLSX]);

        // return response()->json(["file" => $file, "filename" => $fileName]);
    }
    public function srs_export(Request $request)
    {
        try{
            $customer = $request->customer;
            $status = $request->status;
            $type = $request->type;
            $daterange = $request->daterange;
            $customerId = $request->customer;
            $service_type = $request->service_type;
            $status = $request->status;
            $date_range = $request->date_range;
            $today = date("Y-m-d");
            $todate = date("Y-m-d");
            $fromdate = date('Y-m-d', strtotime($todate . '-' . $date_range . ' days'));
            if ($date_range == 0) {
                $fromdate = $todate;
            }
            if ($date_range == 1) {
                $todate = date('Y-m-d', strtotime($today . '-1 days'));
                $fromdate = date('Y-m-d', strtotime($today . '-1 days'));
            }
    
            $services = Service::join("master_service_status", "master_service_status.Status_Id", "services.service_status")
                ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
                ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
                ->join("master_service_type", "master_service_type.id", "services.service_type")
                ->join("clients", "clients.CST_ID", "services.customer_id")
                ->leftJoin("contracts", "contracts.CNRT_ID", "services.contract_id")
                ->leftJoin("employees", "employees.EMP_ID", "services.assigned_to")
                ->when($customerId != 0, function ($query) use ($customerId) {
                    return $query->where('clients.CST_ID', $customerId);
                })
                ->when($service_type != 0, function ($query) use ($service_type) {
                    return $query->where('services.service_type', $service_type);
                })
                ->when($type != "", function ($query) use ($type) {
                    if ($type == 0) {
                        return $query->where('services.contract_id', 0);
                    } else {
                        return $query->where('services.contract_id', '>=', $type);
                    }
    
                })
                ->when($status != 0, function ($query) use ($status) {
                    return $query->where('services.service_status', $status);
                })
                ->when($date_range != "" && $date_range != -1, function ($query) use ($todate, $fromdate) {
                    return $query->whereBetween(DB::raw('DATE_FORMAT(services.service_date, "%Y-%m-%d")'), [$fromdate, $todate]);
    
                })
                ->orderby("services.updated_at", "DESC")->get();
                
               
            $services->map(function ($service) {

                    $servicehistory = ServiceHistory::join("master_service_status", "master_service_status.Status_Id", "=", "service_action_history.status_id")
                    ->where("service_id", $service->service_id)
                    ->orderBy("service_action_history.id", "DESC")
                    ->limit(1)
                    ->first();
                    $sn = $service->nrnumber ??  $service->product_sn;
                    $pname = $service->product_name;
                    $pfn = $sn != "" ? $sn."/".$pname : $pname;
                    $service->serviceno = $service->service_no;
                    $service->CNRTType = $service->contract_id >= 1 ? 'Contracted' : 'Non-Contracted';
                    $service->CNRTNumber = $service->CNRT_Number;
                    $service->CSTName = $service->CST_Name;
                    $service->typename = $service->type_name;
                    $service->issuename = $service->issue_name;
                    $service->product = $pfn;
                    $service->servicenote = $service->service_note;
                    $service->responsetime = $servicehistory->created_at ?? "";
                    $service->problemreported_by_engineer = $servicehistory->action_description ?? "";
                    $service->actiontakenbyengineer = $service->timeline();
                    $service->StatusName = $service->Status_Name;
                    $service->EMPName = $service->EMP_Name;
                    $service->resolveddatetime = $service->resolved_datetime;
                    $service->createddiffhours = $service->created_at ? now()->diffInHours($service->created_at) : null;
                    $service->closedat = $service->closed_at;
                    $service->expenses1 = $service->expenses;
                    $service->charges2 = $service->charges;
                    $service->closenote = $service->close_note;
                    return $service;
            });    

            $items[] = $services->toArray();
            // dd($items);
            $fileName = 'report_file' . time() . '.csv';
    
            return Excel::download(new ServiceStatusExport($items), $fileName)->deleteFileAfterSend(true);
          
        } catch(Exception $exception){
            echo "".$exception->getMessage();
            return false;
        }
          // return Excel::download(new ContractExport($items), $fileName, null, [\Maatwebsite\Excel\Excel::XLSX]);

        // return response()->json(["file" => $file, "filename" => $fileName]);
    }
    public function str_index(Request $request)
    {
        $clients = Client::all();
        $status = ServiceStatus::all();
        $service_types = ServiceType::all();
        return view(
            'reports.service_report',
            [
                "clients" => $clients,
                "status" => $status,
                "customer" => "",
                "service_types" => $service_types,
                "service_type" => "",
                "services" => array(),
                "sstatus" => ""
            ]
        );
    }
    public function strs_index(Request $request)
    {
        $clients = Client::all();
        $status = ServiceStatus::all();
        $service_types = ServiceType::all();
        return view(
            'reports.service_status_report',
            [
                "clients" => $clients,
                "status" => $status,
                "customer" => "",
                "service_types" => $service_types,
                "service_type" => "",
                "services" => array(),
                "sstatus" => ""
            ]
        );
    }

    public function etr_index(Request $request)
    {
        $employee = Employee::where(["EMP_Status" => 1, "Access_Role" => 4, 'deleted_at' => null])->get();
        $status = ServiceStatus::all();
        $service_types = ServiceType::all();
        return view(
            'reports.engineer_report',
            [
                "employees" => $employee,
                "status" => $status,
                "selected_employee" => "0",
                "service_types" => $service_types,
                "service_type" => "",
                "services" => array(),
                "sstatus" => ""
            ]
        );
    }
    public function scr_data(Request $request)
    {

    }
    public function csr_index(Request $request)
    {
        $clients = Client::all();
        return view('reports.contract-service', [
            "clients" => $clients,
        ]);
    }
    public function easr_index(Request $request)
    {
        $engineer = Employee::where(["EMP_Status" => 1, "Access_Role" => 4, 'deleted_at' => null])->get();
        return view('reports.engineer-service-analysis', [
            "engineers" => $engineer,
        ]);
    }
    function GetServiceCountEng($engineer_id, $todate, $fromdate, $empId, $contract, $serviceType, $issueType, $status)
    {

        $services = Service::
            join("master_service_status", "master_service_status.Status_Id", "services.service_status")
            ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
            ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
            ->join("master_service_type", "master_service_type.id", "services.service_type")
            ->join("clients", "clients.CST_ID", "services.customer_id")
            ->leftJoin("users", "users.id", "services.assigned_to")
            ->when($engineer_id != 0 && $engineer_id != "", function ($query) use ($engineer_id) {
                $query->where("services.assigned_to", $engineer_id);
            })
            ->when($todate != "" && $fromdate != "", function ($query) use ($todate, $fromdate) {
                $query->whereBetween(DB::raw('DATE_FORMAT(services.service_date, "%Y-%m-%d")'), [$todate, $fromdate]);
            })
            ->when($issueType != "", function ($query) use ($issueType) {
                return $query->where('services.issue_type', $issueType);
            })
            ->when($serviceType != "", function ($query) use ($serviceType) {
                return $query->where('services.service_type', $serviceType);
            })
            ->when($contract == 0, function ($query) use ($contract) {
                return $query->where('services.contract_id', 0);
            })
            ->when(($contract != 0 && $contract != ""), function ($query) use ($contract) {
                return $query->where('services.contract_id', ">", 1);
            })
            ->when($empId != "", function ($query) use ($empId) {
                return $query->where('services.assigned_to', $empId);
            })
            ->when($status != "", function ($query) use ($status) {
                return $query->where('services.service_status', $status);
            })
            ->get();
        if (is_null($services)) {
            return 0;
        }
        return count($services);

    }
    function GetServiceCount($customer_id, $todate, $fromdate, $empId, $contract, $serviceType, $issueType, $status)
    {

        $services = Service::
            join("master_service_status", "master_service_status.Status_Id", "services.service_status")
            ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
            ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
            ->join("master_service_type", "master_service_type.id", "services.service_type")
            ->join("clients", "clients.CST_ID", "services.customer_id")
            ->leftJoin("users", "users.id", "services.assigned_to")
            ->when($customer_id != "0" && $customer_id != "", function ($query) use ($customer_id) {
                $query->where("services.customer_id", $customer_id);
            })
            ->when($todate != "" && $fromdate != "", function ($query) use ($todate, $fromdate) {
                $query->whereBetween(DB::raw('DATE_FORMAT(services.service_date, "%Y-%m-%d")'), [$fromdate, $todate]);
            })
            ->when($issueType != "", function ($query) use ($issueType) {
                return $query->where('services.issue_type', $issueType);
            })
            ->when($serviceType != "", function ($query) use ($serviceType) {
                return $query->where('services.service_type', $serviceType);
            })
            ->when($contract == 0, function ($query) use ($contract) {
                return $query->where('services.contract_id', 0);
            })
            ->when(($contract != 0 && $contract != ""), function ($query) use ($contract) {
                return $query->where('services.contract_id', "!=", 0);
            })
            ->when($empId != "", function ($query) use ($empId) {
                return $query->where('services.assigned_to', $empId);
            })
            ->when($status != "", function ($query) use ($status) {
                return $query->where('services.service_status', $status);
            })
            ->get();
        if (is_null($services)) {
            return 0;
        }
        return count($services);

    }
    public function GetUserEmployeeLogReport(Request $request)
    {
        $data = array();
        $employeeId = $request->engineerId;
        $todate = $request->todate;
        $fromdate = $request->fromdate;
        if ($todate == "" || $fromdate == "") {
            $data = SystemLog::join("employees", "employees.EMP_ID", "systemlogs.loginId")
                ->leftJoin("master_role_access", "master_role_access.id", "employees.Access_Role")
                ->where("systemlogs.loginId", $employeeId)
                ->get();
        } else {
            $data = SystemLog::join("employees", "employees.EMP_ID", "systemlogs.loginId")
                ->leftJoin("master_role_access", "master_role_access.id", "employees.Access_Role")
                ->where("systemlogs.loginId", $employeeId)
                ->whereBetween(DB::raw('DATE_FORMAT(systemlogs.created_at, "%Y-%m-%d")'), [$fromdate, $todate])
                ->get(["systemlogs.*", "master_role_access.access_role_name", "employees.EMP_ID", "employees.EMP_Name", "employees.EMP_Email", "employees.EMP_MobileNumber"]);
        }

        return $data;

    }
    public function GetAnalysisReport(Request $request)
    {


        $date_range = $request->dayFilter;
        $today = date("Y-m-d");
        $todate = date("Y-m-d");
        $fromdate = date('Y-m-d', strtotime($todate . '-' . $date_range . ' days'));
        if ($date_range == 0) {
            $fromdate = $todate;
        }
        if ($date_range == 2) {
            $todate = date('Y-m-d', strtotime($today . '-1 days'));
            $fromdate = date('Y-m-d', strtotime($today . '-1 days'));
        }
        if ($date_range == -1) {
            $todate = "";
            $fromdate = "";
        }
        // dd($todate."--".$fromdate);
        $customer_id = $request->cust_id;
        $employees = Employee::orderby("EMP_ID", 'ASC')->get();

        $employee = array();
        $employeeData = array();
        foreach ($employees as $emp) {
            array_push($employee, $emp->EMP_Name);
            $count = $this->GetServiceCount($customer_id, $todate, $fromdate, $emp->EMP_ID, "", "", "", "");
            array_push($employeeData, $count);
        }


        $contractType = array("Contracted", "Non Contracted");
        $contractTypeData = array(15, 10);
        $countContracted = $this->GetServiceCount($customer_id, $todate, $fromdate, "", 1, "", "", "");
        $countNonContracted = $this->GetServiceCount($customer_id, $todate, $fromdate, "", 0, "", "", "");

        $contractTypeArr = array(array("label" => "Contracted", "y" => $countContracted), array("label" => "Non Contracted", "y" => $countNonContracted));
        $serviceType = array();
        $serviceTypeData = array();

        $serviceTypes = ServiceType::orderby("id", 'ASC')->get();
        foreach ($serviceTypes as $st) {
            array_push($serviceType, $st->type_name);
            $count = $this->GetServiceCount($customer_id, $todate, $fromdate, "", "", $st->id, "", "");
            array_push($serviceTypeData, $count);
        }

        $issueType = array();
        $issueTypeData = array();

        $issueTypes = IssueType::orderby("id", 'ASC')->get();
        foreach ($issueTypes as $it) {
            array_push($issueType, $it->issue_name);
            $count = $this->GetServiceCount($customer_id, $todate, $fromdate, "", "", "", $it->id, "");
            array_push($issueTypeData, $count);
        }
        $countArray = array();
        $serviceStatus = ServiceStatus::orderby("Status_Id", 'ASC')->get();
        foreach ($serviceStatus as $ss) {
            $count = $this->GetServiceCount($customer_id, $todate, $fromdate, "", "", "", "", $ss->Status_Id);
            //$obj = ."=>".$count;
            $countArray[$ss->Status_Name] = $count;
        }



        return response()->json([
            "success" => true,
            "employee" => $employee,
            "employeeData" => $employeeData,
            "contractType" => $contractType,
            "contractTypeData" => $contractTypeData,
            "serviceType" => $serviceType,
            "serviceTypeData" => $serviceTypeData,
            "issueType" => $issueType,
            "issueTypeData" => $issueTypeData,
            "countArray" => $countArray,
            "contractTypeArr" => $contractTypeArr,
        ]);

    }
    public function GetEngineerAnalysisReport(Request $request)
    {


        $todate = $request->todate;
        $fromdate = $request->fromdate;
        $engineer_id = $request->engineer;

        $employees = Employee::orderby("EMP_ID", 'ASC')
            ->when($engineer_id != 0, function ($query) use ($engineer_id) {
                return $query->where('EMP_ID', $engineer_id);
            })->get();

        $employee = array();
        $employeeData = array();
        foreach ($employees as $emp) {
            array_push($employee, $emp->EMP_Name);
            $count = $this->GetServiceCountEng($engineer_id, $todate, $fromdate, $emp->EMP_ID, "", "", "", "");
            array_push($employeeData, $count);
        }


        $contractType = array("Contracted", "Non Contracted");
        $contractTypeData = array(15, 10);
        $countContracted = $this->GetServiceCountEng($engineer_id, $todate, $fromdate, "", 1, "", "", "");
        $countNonContracted = $this->GetServiceCountEng($engineer_id, $todate, $fromdate, "", 0, "", "", "");

        $contractTypeArr = array(array("label" => "Contracted", "y" => $countContracted), array("label" => "Non Contracted", "y" => $countNonContracted));
        $serviceType = array();
        $serviceTypeData = array();

        $serviceTypes = ServiceType::orderby("id", 'ASC')->get();
        foreach ($serviceTypes as $st) {
            array_push($serviceType, $st->type_name);
            $count = $this->GetServiceCountEng($engineer_id, $todate, $fromdate, "", "", $st->id, "", "");
            array_push($serviceTypeData, $count);
        }

        $issueType = array();
        $issueTypeData = array();

        $issueTypes = IssueType::orderby("id", 'ASC')->get();
        foreach ($issueTypes as $it) {
            array_push($issueType, $it->issue_name);
            $count = $this->GetServiceCountEng($engineer_id, $todate, $fromdate, "", "", "", $it->id, "");
            array_push($issueTypeData, $count);
        }
        $countArray = array();
        $serviceStatus = ServiceStatus::orderby("Status_Id", 'ASC')->get();
        foreach ($serviceStatus as $ss) {
            $count = $this->GetServiceCountEng($engineer_id, $todate, $fromdate, "", "", "", "", $ss->Status_Id);
            //$obj = ."=>".$count;
            $countArray[$ss->Status_Name] = $count;
        }


        return response()->json([
            "success" => true,
            "employee" => $employee,
            "employeeData" => $employeeData,
            "contractType" => $contractType,
            "contractTypeData" => $contractTypeData,
            "serviceType" => $serviceType,
            "serviceTypeData" => $serviceTypeData,
            "issueType" => $issueType,
            "issueTypeData" => $issueTypeData,
            "countArray" => $countArray,
            "contractTypeArr" => $contractTypeArr,
        ]);

    }
    public function GetStatusListAll(Request $request)
    {

        $status = ServiceStatus::where("flag", "!=", "3")->get();
        return $status;

    }
    public function GetServicePaymentReportByService(Request $request)
    {
        $customerId = $request->customerId;
        $paymentMode = $request->paymentMode;
        $todate = $request->todate;
        $fromdate = $request->fromdate;

        $services = array();
        if ($todate == "" || $fromdate == "") {
            $services = ServiceFieldReport::
                join("services", "services.id", "service_fieldreport.ServiceId")
                ->join("master_service_status", "master_service_status.Status_Id", "services.service_status")
                ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
                ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
                ->join("master_service_type", "master_service_type.id", "services.service_type")
                ->join("clients", "clients.CST_ID", "services.customer_id")
                ->when($customerId != 0, function ($query) use ($customerId) {
                    return $query->where('clients.CST_ID', $customerId);
                })
                ->when($paymentMode != "", function ($query) use ($paymentMode) {
                    return $query->where('service_fieldreport.PaymentMode', $paymentMode);
                })

                ->orderby("services.updated_at", "DESC")
                ->get(["service_fieldreport.*", "services.*", "clients.*", "services.id as service_id", "master_service_type.*", "master_issue_type.*", "services.*", "master_service_status.*", "master_service_priority.*"]);
            foreach ($services as $service) {
                $service->View = "/service/view-service?id=" . $service->service_id;
            }
        } else {
            $services = ServiceFieldReport::
                join("services", "services.id", "service_fieldreport.ServiceId")
                ->join("master_service_status", "master_service_status.Status_Id", "services.service_status")
                ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
                ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
                ->join("master_service_type", "master_service_type.id", "services.service_type")
                ->join("clients", "clients.CST_ID", "services.customer_id")
                ->leftJoin("users", "users.id", "services.assigned_to")
                ->whereBetween(DB::raw('DATE_FORMAT(service_fieldreport.payment_date, "%Y-%m-%d")'), [$fromdate, $todate])
                ->when($customerId != 0, function ($query) use ($customerId) {
                    return $query->where('clients.CST_ID', $customerId);
                })
                ->when($paymentMode != "", function ($query) use ($paymentMode) {
                    return $query->where('service_fieldreport.PaymentMode', $paymentMode);
                })
                ->orderby("services.updated_at", "DESC")
                ->get(["service_fieldreport.*", "services.*", "clients.*", "services.id as service_id", "master_service_type.*", "master_issue_type.*", "services.*", "master_service_status.*", "master_service_priority.*"]);

        }

        return $services;
    }
    public function GetCustomerReport(Request $request)
    {

        $customers = array();
        $area = $request->area;
        $refBy = $request->refBy;

        try {
            // $customers = Customer::leftJoin("employees","employees.EMP_ID","clients.Ref_Employee")
            // ->when($refBy!=0,function($query) use ($refBy){
            //     return $query->where('clients.Ref_Employee',$refBy);
            // })
            // ->get();

            $customers = Client::leftJoin("customer_sites", "customer_sites.CustomerId", "clients.CST_ID")
                ->leftJoin("employees", "employees.EMP_ID", "clients.Ref_Employee")
                ->leftJoin("master_site_area", "master_site_area.id", "customer_sites.AreaName")
                ->when($refBy != 0, function ($query) use ($refBy) {
                    return $query->where('clients.Ref_Employee', $refBy);
                })
                ->when($area != 0, function ($query) use ($area) {
                    return $query->where('customer_sites.AreaName', $area);
                })
                ->get();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        return $customers;

    }
    public function GetContractReport(Request $request)
    {

        $contracts = array();
        $customerId = $request->customerId;
        $contractStatus = $request->contractStatus;
        $contractType = $request->contractType;

        try {
            $contracts = Contract::join("master_contract_type", "master_contract_type.id", "contracts.CNRT_Type")
                ->join("master_site_type", "master_site_type.id", "contracts.CNRT_SiteType")
                ->join("master_contract_status", "master_contract_status.id", "contracts.CNRT_Status")
                ->join("clients", "clients.CST_ID", "contracts.CNRT_CustomerID")
                ->join("customer_sites", "customer_sites.id", "contracts.CNRT_Site")
                ->when($customerId != 0, function ($query) use ($customerId) {
                    return $query->where('clients.CST_ID', $customerId);
                })
                ->when($contractType != 0, function ($query) use ($contractType) {
                    return $query->where('contracts.CNRT_Type', $contractType);
                })
                ->when($contractStatus != 0, function ($query) use ($contractStatus) {
                    return $query->where('contracts.CNRT_Status', $contractStatus);
                })
                ->get();
            foreach ($contracts as $contract) {
                $contract->Edit = "/contract/edit-contract?id=" . $contract->CNRT_ID;
                $contract->View = "/contract/view-contract?CNRT_ID=" . $contract->CNRT_ID;
            }

        } catch (QueryException $ex) {
            return $ex->errorInfo;
        }
        return $contracts;

    }

    public function GetServiceCallReport(Request $request)
    {

        $customerId = $request->customer;
        $service_type = $request->service_type;
        $type = $request->type;
        $status = $request->status;
        $date_range = $request->date_range;
        $today = date("Y-m-d");
        $todate = date("Y-m-d");
        $fromdate = date('Y-m-d', strtotime($todate . '-' . $date_range . ' days'));
        if ($date_range == 0) {
            $fromdate = $todate;
        }
        if ($date_range == 1) {
            $todate = date('Y-m-d', strtotime($today . '-1 days'));
            $fromdate = date('Y-m-d', strtotime($today . '-1 days'));
        }

        $services = array();
        $services = Service::select("*", "services.id as service_id", "contract_under_product.*")
            ->join("master_service_status", "master_service_status.Status_Id", "services.service_status")
            ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
            ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
            ->join("master_service_type", "master_service_type.id", "services.service_type")
            ->join("clients", "clients.CST_ID", "services.customer_id")
            ->leftJoin("contracts", "contracts.CNRT_ID", "services.contract_id")
            ->leftJoin("contract_under_product", "contract_under_product.id", "services.product_id")
            ->leftJoin("employees", "employees.EMP_ID", "services.assigned_to")
            ->when($customerId != 0, function ($query) use ($customerId) {
                return $query->where('clients.CST_ID', $customerId);
            })
            ->when($service_type != 0, function ($query) use ($service_type) {
                return $query->where('services.service_type', $service_type);
            })
            ->when($type != "", function ($query) use ($type) {
                if ($type == 0) {
                    return $query->where('services.contract_id', 0);
                } else {
                    return $query->where('services.contract_id', '>=', $type);
                }

            })
            ->when($status != 0, function ($query) use ($status) {
                return $query->where('services.service_status', $status);
            })
            ->when($date_range != "" && $date_range != -1, function ($query) use ($todate, $fromdate) {
                return $query->whereBetween(DB::raw('DATE_FORMAT(services.service_date, "%Y-%m-%d")'), [$fromdate, $todate]);

            })

            ->orderby("services.updated_at", "DESC")
            ->paginate(10);

        $clients = Client::all();
        $status = ServiceStatus::all();
        $service_types = ServiceType::all();
        if ($request->ajax()) {
            return view('reports.str_pagination', compact('services', 'status'));
        }
        return view(
            'reports.service_report',
            [
                "clients" => $clients,
                "status" => $status,
                "customer" => $customerId,
                "date_range" => $date_range,
                "service_types" => $service_types,
                "service_type" => $service_type,
                "contracts" => array(),
                "services" => $services,
                "sstatus" => $request->status,
            ]
        );
    }
    public function GetServiceCallReportStatus(Request $request)
    {

        $customerId = $request->customer;
        $service_type = $request->service_type;
        $type = $request->type;
        $status = $request->status;
        $date_range = $request->date_range;
        $today = date("Y-m-d");
        $todate = date("Y-m-d");
        $fromdate = date('Y-m-d', strtotime($todate . '-' . $date_range . ' days'));
        if ($date_range == 0) {
            $fromdate = $todate;
        }
        if ($date_range == 1) {
            $todate = date('Y-m-d', strtotime($today . '-1 days'));
            $fromdate = date('Y-m-d', strtotime($today . '-1 days'));
        }

        $services = array();
        $services = Service::select("*", "services.id as service_id", "contract_under_product.*")
            ->join("master_service_status", "master_service_status.Status_Id", "services.service_status")
            ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
            ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
            ->join("master_service_type", "master_service_type.id", "services.service_type")
            ->join("clients", "clients.CST_ID", "services.customer_id")
            ->leftJoin("contracts", "contracts.CNRT_ID", "services.contract_id")
            ->leftJoin("contract_under_product", "contract_under_product.id", "services.product_id")
            ->leftJoin("employees", "employees.EMP_ID", "services.assigned_to")
            ->when($customerId != 0, function ($query) use ($customerId) {
                return $query->where('clients.CST_ID', $customerId);
            })
            ->when($service_type != 0, function ($query) use ($service_type) {
                return $query->where('services.service_type', $service_type);
            })
            ->when($type != "", function ($query) use ($type) {
                if ($type == 0) {
                    return $query->where('services.contract_id', 0);
                } else {
                    return $query->where('services.contract_id', '>=', $type);
                }

            })
            ->when($status != 0, function ($query) use ($status) {
                return $query->where('services.service_status', $status);
            })
            ->when($date_range != "" && $date_range != -1, function ($query) use ($todate, $fromdate) {
                return $query->whereBetween(DB::raw('DATE_FORMAT(services.service_date, "%Y-%m-%d")'), [$fromdate, $todate]);

            })

            ->orderby("services.updated_at", "DESC")
            ->paginate(10);

        $clients = Client::all();
        $status = ServiceStatus::all();
        $service_types = ServiceType::all();
        if ($request->ajax()) {
            return view('reports.strs_pagination', compact('services', 'status'));
        }
        return view(
            'reports.service_status_report',
            [
                "clients" => $clients,
                "status" => $status,
                "customer" => $customerId,
                "date_range" => $date_range,
                "service_types" => $service_types,
                "service_type" => $service_type,
                "contracts" => array(),
                "services" => $services,
                "sstatus" => $request->status,
            ]
        );
    }
    public function EngineerServiceAnalysis(Request $request)
    {

        $customerId = $request->customer;
        $service_type = $request->service_type;
        $type = $request->type;
        $status = $request->status;
        $date_range = $request->date_range;
        $today = date("Y-m-d");
        $todate = date("Y-m-d");
        $fromdate = date('Y-m-d', strtotime($todate . '-' . $date_range . ' days'));
        if ($date_range == 0) {
            $fromdate = $todate;
        }
        if ($date_range == 1) {
            $todate = date('Y-m-d', strtotime($today . '-1 days'));
            $fromdate = date('Y-m-d', strtotime($today . '-1 days'));
        }

        $services = array();
        $services = Service::select("*", "services.id as service_id")
            ->join("master_service_status", "master_service_status.Status_Id", "services.service_status")
            ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
            ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
            ->join("master_service_type", "master_service_type.id", "services.service_type")
            ->join("clients", "clients.CST_ID", "services.customer_id")
            ->leftJoin("contracts", "contracts.CNRT_ID", "services.contract_id")
            ->leftJoin("employees", "employees.EMP_ID", "services.assigned_to")
            ->when($customerId != 0, function ($query) use ($customerId) {
                return $query->where('clients.CST_ID', $customerId);
            })
            ->when($service_type != 0, function ($query) use ($service_type) {
                return $query->where('services.service_type', $service_type);
            })
            ->when($type != "", function ($query) use ($type) {
                if ($type == 0) {
                    return $query->where('services.contract_id', 0);
                } else {
                    return $query->where('services.contract_id', '>=', $type);
                }

            })
            ->when($status != 0, function ($query) use ($status) {
                return $query->where('services.service_status', $status);
            })
            ->when($date_range != "" && $date_range != -1, function ($query) use ($todate, $fromdate) {
                return $query->whereBetween(DB::raw('DATE_FORMAT(services.service_date, "%Y-%m-%d")'), [$fromdate, $todate]);

            })

            ->orderby("services.updated_at", "DESC")
            ->paginate(10);

        $clients = Client::all();
        $status = ServiceStatus::all();
        $service_types = ServiceType::all();
        if ($request->ajax()) {
            return view('reports.str_pagination', compact('services', 'status'));
        }
        return view(
            'reports.service_report',
            [
                "clients" => $clients,
                "status" => $status,
                "customer" => $customerId,
                "date_range" => $date_range,
                "service_types" => $service_types,
                "service_type" => $service_type,
                "contracts" => array(),
                "services" => $services,
                "sstatus" => $request->status,
            ]
        );
    }
    public function GetEngineerCallReport(Request $request)
    {

        $engineerId = $request->employee;
        $service_type = $request->service_type;
        $status = $request->status;
        $date_range = $request->date_range;
        $today = date("Y-m-d");
        $todate = date("Y-m-d");
        $fromdate = date('Y-m-d', strtotime($todate . '-' . $date_range . ' days'));
        if ($date_range == 0) {
            $fromdate = $todate;
        }
        if ($date_range == 1) {
            $todate = date('Y-m-d', strtotime($today . '-1 days'));
            $fromdate = date('Y-m-d', strtotime($today . '-1 days'));
        }

        $services = array();
        $services = Service::select("*", "services.id as service_id")
            ->join("master_service_status", "master_service_status.Status_Id", "services.service_status")
            ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
            ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
            ->join("master_service_type", "master_service_type.id", "services.service_type")
            ->join("clients", "clients.CST_ID", "services.customer_id")
            ->leftJoin("contracts", "contracts.CNRT_ID", "services.contract_id")
            ->leftJoin("employees", "employees.EMP_ID", "services.assigned_to")
            ->when($engineerId != 0, function ($query) use ($engineerId) {
                return $query->where('services.assigned_to', $engineerId);
            })
            ->when($service_type != 0, function ($query) use ($service_type) {
                return $query->where('services.service_type', $service_type);
            })
            ->when($status != 0, function ($query) use ($status) {
                return $query->where('services.service_status', $status);
            })
            ->when($date_range != "" && $date_range != -1, function ($query) use ($todate, $fromdate) {
                return $query->whereBetween(DB::raw('DATE_FORMAT(services.service_date, "%Y-%m-%d")'), [$fromdate, $todate]);

            })

            ->orderby("services.updated_at", "DESC")
            ->paginate(10);

        $clients = Client::all();
        $status = ServiceStatus::all();
        $service_types = ServiceType::all();
        if ($request->ajax()) {
            return view('reports.str_pagination', compact('services', 'status'));
        }
        return view(
            'reports.service_report',
            [
                "clients" => $clients,
                "status" => $status,
                "customer" => $customerId,
                "date_range" => $date_range,
                "service_types" => $service_types,
                "service_type" => $service_type,
                "contracts" => array(),
                "services" => $services,
                "sstatus" => $request->status,
            ]
        );
    }
    public function GetServiceCallReportByService(Request $request)
    {


        $customerId = $request->customerId;
        $serviceStatus = $request->serviceStatus;
        $serviceType = $request->serviceType;
        $todate = $request->todate;
        $fromdate = $request->fromdate;
        $employeeId = $request->engineerId;
        $services = array();
        if ($todate == "" || $fromdate == "") {
            $services = Service::
                join("master_service_status", "master_service_status.Status_Id", "services.service_status")
                ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
                ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
                ->join("master_service_type", "master_service_type.id", "services.service_type")
                ->join("clients", "clients.CST_ID", "services.customer_id")
                ->leftJoin("service_under_product", "service_under_product.serviceId", "services.id")
                ->leftJoin("users", "users.id", "services.assigned_to")
                ->when($customerId != 0, function ($query) use ($customerId) {
                    return $query->where('clients.CST_ID', $customerId);
                })
                ->when($serviceStatus != 0, function ($query) use ($serviceStatus) {
                    return $query->where('services.service_status', $serviceStatus);
                })
                ->when($serviceType != 0, function ($query) use ($serviceType) {
                    return $query->where('services.service_type', $serviceType);
                })
                ->when($employeeId != 0, function ($query) use ($employeeId) {
                    return $query->where('services.assigned_to', $employeeId);
                })
                ->orderby("services.updated_at", "DESC")
                ->get(["service_under_product.*", "clients.*", "services.id as service_id", "users.name as assignedName", "users.name", "master_service_type.*", "master_issue_type.*", "services.*", "master_service_status.*", "master_service_priority.*"]);
            foreach ($services as $service) {
                $service->View = "/service/view-service?id=" . $service->service_id;
            }
        } else {
            $services = Service::
                join("master_service_status", "master_service_status.Status_Id", "services.service_status")
                ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
                ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
                ->join("master_service_type", "master_service_type.id", "services.service_type")
                ->join("clients", "clients.CST_ID", "services.customer_id")
                ->leftJoin("users", "users.id", "services.assigned_to")
                ->leftJoin("service_under_product", "service_under_product.serviceId", "services.id")
                ->whereBetween(DB::raw('DATE_FORMAT(services.service_date, "%Y-%m-%d")'), [$todate, $fromdate])
                ->when($customerId != 0, function ($query) use ($customerId) {
                    return $query->where('clients.CST_ID', $customerId);
                })
                ->when($serviceStatus != 0, function ($query) use ($serviceStatus) {
                    return $query->where('services.service_status', $serviceStatus);
                })
                ->when($employeeId != 0, function ($query) use ($employeeId) {
                    return $query->where('services.assigned_to', $employeeId);
                })
                ->when($serviceType != 0, function ($query) use ($serviceType) {
                    return $query->where('services.service_type', $serviceType);
                })
                ->orderby("services.updated_at", "DESC")
                ->get(["service_under_product.*", "clients.*", "services.id as service_id", "users.name as assignedName", "users.name", "master_service_type.*", "master_issue_type.*", "services.*", "master_service_status.*", "master_service_priority.*"]);
            foreach ($services as $service) {
                $service->View = "/service/view-service?id=" . $service->service_id;
            }
        }

        return $services;
    }


}

