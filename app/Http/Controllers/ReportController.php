<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ContractStatus;
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


class ReportController extends Controller
{

    public $status = [
        "1" => '<div class="badge badge-success badge-shadow">Active</div>',
        "2" => '<div class="badge badge-info badge-shadow">Renewal</div>',
        "3" => '<div class="badge badge-danger badge-shadow">Expired</div>',
        "4" => '<div class="badge badge-danger badge-shadow">Deactivated</div>',
    ];
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
                ->paginate(5);
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
    public function csr_data(Request $request)
    {

    }
    public function csr_index(Request $request)
    {
        $clients = Client::all();
        return view('reports.contract-service', [
            "clients" => $clients,
        ]);
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
            ->when($customer_id != "", function ($query) use ($customer_id) {
                $query->where("services.customer_id", $customer_id);
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


        $todate = $request->todate;
        $fromdate = $request->fromdate;
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

        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $contracts;

    }

    public function GetServiceCallReport(Request $request)
    {


        $customerId = $request->customerId;
        $contractId = $request->contractId;
        $employeeId = $request->employeeId;
        $todate = $request->todate;
        $fromdate = $request->fromdate;
        $services = array();
        if ($todate == "" || $fromdate == "") {
            $services = Service::
                join("master_service_status", "master_service_status.Status_Id", "services.service_status")
                ->join("master_service_priority", "master_service_priority.id", "services.service_priority")
                ->join("master_issue_type", "master_issue_type.id", "services.issue_type")
                ->join("master_service_type", "master_service_type.id", "services.service_type")
                ->join("clients", "clients.CST_ID", "services.customer_id")
                ->leftJoin("users", "users.id", "services.assigned_to")
                ->when($customerId != 0, function ($query) use ($customerId) {
                    return $query->where('clients.CST_ID', $customerId);
                })
                ->when($contractId != 0, function ($query) use ($contractId) {
                    return $query->where('services.contract_id', $contractId);
                })
                ->when($employeeId != 0, function ($query) use ($employeeId) {
                    return $query->where('services.assigned_to', $employeeId);
                })
                ->orderby("services.updated_at", "DESC")
                ->get(["clients.*", "services.id as service_id", "users.name as assignedName", "users.name", "master_service_type.*", "master_issue_type.*", "services.*", "master_service_status.*", "master_service_priority.*"]);
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
                ->whereBetween(DB::raw('DATE_FORMAT(services.service_date, "%Y-%m-%d")'), [$todate, $fromdate])
                ->when($customerId != 0, function ($query) use ($customerId) {
                    return $query->where('clients.CST_ID', $customerId);
                })
                ->when($contractId != 0, function ($query) use ($contractId) {
                    return $query->where('services.contract_id', $contractId);
                })
                ->when($employeeId != 0, function ($query) use ($employeeId) {
                    return $query->where('services.assigned_to', $employeeId);
                })
                ->orderby("services.updated_at", "DESC")
                ->get(["clients.*", "services.id as service_id", "users.name as assignedName", "users.name", "master_service_type.*", "master_issue_type.*", "services.*", "master_service_status.*", "master_service_priority.*"]);
            foreach ($services as $service) {
                $service->View = "/service/view-service?id=" . $service->service_id;
            }
        }

        return $services;
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

