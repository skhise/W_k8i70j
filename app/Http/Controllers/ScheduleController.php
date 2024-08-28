<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Session;
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
use App\Models\ContractScheduleService;
use Illuminate\Support\Facades\Hash;
use App\Models\ServiceType;
use App\Models\IssueType;
use App\Models\Service;
use App\Models\Priority;
use App\Models\ServiceAccessory;
use App\Models\ServiceHistory;
use App\Models\ActionReason;
use App\Models\ServiceStatus;
use Carbon\Carbon;


class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $contractsSchedule = array();
        try {
            $today = date("Y-m-d");
            $contractsSchedule = ContractScheduleService::select(
                "master_issue_type.*",
                "master_service_type.*",
                "contract_schedule_service.id as cupId",
                "contract_schedule_service.*",
                "contracts.*",
                "clients.*",
                "master_service_status.*"
            )->
                join("contracts", "contracts.CNRT_ID", "contract_schedule_service.contractId")
                ->join("clients", "clients.CST_ID", "contracts.CNRT_CustomerID")

                ->leftJoin(
                    "contract_under_product",
                    "contract_under_product.id",
                    "contract_schedule_service.product_id"
                )
                ->leftJoin("master_service_status", "contract_schedule_service.Schedule_Status", "master_service_status.Status_Id")
                ->leftJoin("master_service_type", "master_service_type.id", "contract_schedule_service.serviceType")
                ->leftJoin("master_issue_type", "master_issue_type.id", "contract_schedule_service.issueType")
                ->where("isManaged", 0)
                ->orderBy("Schedule_Date", "DESC")
                ->paginate(10)
                ->withQueryString();
            foreach ($contractsSchedule as $cs) {
                $cs->View = "/service/view-service?id=" . $cs->Service_Call_Id;
                if ($cs->Service_Call_Id != 0) {
                    $this->getManagedServiceStatus($cs);
                }
            }



        } catch (Exception $ex) {
            Session::flash("error", "Something went wrong, try again.");
        }
        return view('schedules.index', [
            'filters' => $request->all('search', 'trashed', 'search_field', 'filter_status'),
            'search_field' => $request->search_field ?? '',
            'filter_status' => $request->filter_status ?? '',
            'search' => $request->search ?? '',
            "schedules" => $contractsSchedule,
        ]);
    }
    public function getManagedServiceStatus($cs)
    {
        $statusCode = Service::
            join("master_service_status", "master_service_status.Status_Id", "services.service_status")
            ->where("id", $cs->Service_Call_Id)
            ->first();
        $id = $statusCode->id ?? 0;     
        if ($id > 0) {
            $cs->MStatusName = $statusCode->Status_Name;
            $cs->MStatusColor = $statusCode->status_color;
        }
        return $cs;

    }
}

