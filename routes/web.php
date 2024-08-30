<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\DcController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PDFExportController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocMasterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware(['prevent-back-history', 'menu.permission'])->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/', [DashboardController::class, 'index']);
    });
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/reports/contract-report', [ReportController::class, 'cr_index'])->name('contract-report');
        Route::get('/reports/contract-report-data', [ReportController::class, 'cr_data'])->name('contract-report-data');
        Route::get('/reports/contract-report-export', [ReportController::class, 'cr_export'])->name('contract-report-export');
        Route::get('/reports/service-report-export', [ReportController::class, 'sr_export'])->name('service-report-export');
        Route::get('/reports/engineer-report-export', [ReportController::class, 'engineer_export'])->name('engineer-report-export');
        Route::get('/reports/quot-report-export', [ReportController::class, 'quot_export'])->name('quot-report-export');
        Route::get('/reports/dec-report-export', [ReportController::class, 'dc_export'])->name('dc-report-export');
        Route::get('/reports/contract-service-report', [ReportController::class, 'csr_index'])->name('contract-service-report');
        Route::get('/reports/dc-report', [ReportController::class, 'dc_index'])->name('dc-report');
        Route::get('/reports/quotation-report', [ReportController::class, 'quotation_index'])->name('quotation-report');

        Route::get('/reports/service-ticket-report', [ReportController::class, 'str_index'])->name('service-ticket-report');
        Route::get('/reports/service-ticket-report-data', [ReportController::class, 'GetServiceCallReport'])->name('service-ticket-report-data');
        
        Route::get('/reports/engineer-report', [ReportController::class, 'etr_index'])->name('engineer-report');
        
        Route::get('/reports/engineer-ticket-report-data', [ReportController::class, 'GetEngineerCallReport'])->name('engineer-ticket-report-data');

        Route::get('/reports/contract-service-report-data', [ReportController::class, 'csr_data'])->name('contract-service-report-data');

        Route::get('/reports/GetAnalysisReport', [ReportController::class, 'GetAnalysisReport'])->name('GetAnalysisReport');

        Route::get('/reports/engineer-service-analysis', [ReportController::class, 'easr_index'])->name('engineer-service-analysis');
        Route::get('/reports/GetEngineerAnalysisReport', [ReportController::class, 'GetEngineerAnalysisReport'])->name('GetEngineerAnalysisReport');
    });

    /*Clients Route*/
    Route::middleware('auth')->group(function () {
        Route::get('/clients', [ClientController::class, 'index'])->name('clients');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/clients/persons', [ClientController::class, 'index_persons'])->name('persons');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/clients/sites', [ClientController::class, 'index_sites'])->name('sites');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/clients/create', [ClientController::class, 'create'])->name('client.create');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('client.edit');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/clients/{client}/delete', [ClientController::class, 'delete'])->name('client.delete');
    });
    Route::middleware('auth')->group(function () {
        Route::post('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/clients/all', [ContractController::class, 'GetCustomerList'])->name('clients.all');
    });

    Route::post('clients/{id}/add_cp', [ClientController::class, 'add_cp'])
        ->name('clients.add_cp')
        ->middleware('auth');
    Route::middleware('auth')->group(function () {
        Route::get('/contacts/{contactPerson}/delete', [ClientController::class, 'DeleteContact'])->name('contacts.delete');
    });

    Route::post('clients', [ClientController::class, 'store'])
        ->name('clients.store')
        ->middleware('auth');

    Route::get('clients/{client}/view', [ClientController::class, 'view'])
        ->name('clients.view')
        ->middleware('auth');

    /*Contract Route*/

    Route::middleware('auth')->group(function () {
        Route::get('/contracts', [ContractController::class, 'index'])->name('contracts');
        Route::get('/contracts/create', [ContractController::class, 'create'])->name('contracts.create');
        Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.store');
        Route::post('/contracts/renewal', [ContractController::class, 'ContractRenew'])->name('contracts.renewal');
        Route::get('/contracts/{contract}/view', [ContractController::class, 'view'])->name('contracts.view');
        Route::get('/contracts/{contract}/edit', [ContractController::class, 'edit'])->name('contracts.edit');
        Route::post('/contracts/{contract}/update', [ContractController::class, 'update'])->name('contracts.update');
        Route::post('/contracts/{contract}/add_product', [ContractController::class, 'AddContractProduct'])->name('contracts.add_product');
        Route::post('/contracts/{contract}/update_product', [ContractController::class, 'UpdateContractProduct'])->name('contracts.update_product');
        Route::get('/contracts/customer_contract', [ContractController::class, 'GetContractByCustId'])->name('contracts.customer_contract');
        Route::get('/contracts/contract_by_id', [ContractController::class, 'GetContractById'])->name('contracts.contract_by_id');
        Route::get('/contracts/{contractUnderProduct}/delete', [ContractController::class, 'DeleteContractProduct'])->name('contract_product.delete');
        Route::post('/contracts/checklist/{contract}/store', [ContractController::class, 'checklistStore'])->name('checklist.store');
        Route::get('/contracts/checklist/{checklist}/delete', [ContractController::class, 'checklistdelete'])->name('checklist.delete');
        Route::post('/contracts/service/{contract}/store', [ContractController::class, 'serviceStore'])->name('contract_service.store');
        Route::post('/contracts/service/{contract}/update', [ContractController::class, 'serviceUpdate'])->name('contract_service.update');
        Route::get('/contracts/service/{contractScheduleService}/delete', [ContractController::class, 'servicedelete'])->name('contract_service.delete');
    });

    /*end contractt*/
    // services
    Route::middleware('auth')->group(function () {
        Route::get('/services', [ServiceController::class, 'index'])->name('services');
        Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
        Route::get('/services/{contractScheduleService}/create', [ServiceController::class, 'schedulecreate'])->name('services.schedulecreate');
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
        Route::get('/services/{service}/view', [ServiceController::class, 'view'])->name('services.view');
        Route::get('/services/{service}/delete', [ServiceController::class, 'delete'])->name('services.delete');
        Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
        Route::get('/services/{service}/print', [ServiceController::class, 'Print'])->name('services.print');
        Route::post('/services/{service}/update', [ServiceController::class, 'update'])->name('services.update');
        Route::post('/services/{service}/add_product', [ServiceController::class, 'AddServiceProduct'])->name('services.store_product');
        Route::get('/services/{service}/product_create', [ServiceController::class, 'ProductCreate'])->name('services.product_create');
        Route::get('/services/{serviceDc}/product_delete', [ServiceController::class, 'DeleteServiceDc'])->name('services.dc_delete');
        Route::get('/services/{serviceDc}/dc-view', [ServiceController::class, 'DcView'])->name('services.dc_view');
        Route::get('/services/{serviceDc}/dc-print', [ServiceController::class, 'DcPrint'])->name('services.dc_print');
        Route::get('/services/{serviceDcProduct}/dcp-delete', [ServiceController::class, 'DcpDelete'])->name('service_dcp.delete');
        Route::post('/services/{service}/status', [ServiceController::class, 'ApplyServiceAction'])->name('service_status.store');
        Route::post('/services/{service}/assign', [ServiceController::class, 'AssignEngineer'])->name('service_status.assign');
        Route::post('/services/{service}/accept-reject-call', [ServiceController::class, 'AcceptRejectCall'])->name('services.accept-reject-call');

    });
    //services end
    Route::middleware('auth')->group(function () {
        Route::get('/schedules', [ScheduleController::class, "index"])->name("schedules");
    });
    /* master routes*/
    Route::middleware('auth')->group(function () {
        Route::get('/masters', [MasterController::class, 'index'])->name('masters');
        Route::get('/masters/contract-type', [MasterController::class, 'ct_index'])->name('masters.contract-type');
        Route::post('/masters/contract-type', [MasterController::class, 'ct_saveupdate'])->name('masters.contract-type-store');
        Route::delete('/masters/contract-type', [MasterController::class, 'ct_delete'])->name('masters.contract-type-delete');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/masters/product-type', [MasterController::class, 'pt_index'])->name('masters.product-type');
        Route::post('/masters/product-type', [MasterController::class, 'pt_saveupdate'])->name('masters.product-type-store');
        Route::delete('/masters/product-type', [MasterController::class, 'pt_delete'])->name('masters.product-type-delete');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/masters/site-area', [MasterController::class, 'sa_index'])->name('masters.site-area');
        Route::post('/masters/site-area', [MasterController::class, 'sa_saveupdate'])->name('masters.site-area-store');
        Route::delete('/masters/site-area', [MasterController::class, 'sa_delete'])->name('masters.site-area-delete');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/masters/service-sub-status', [MasterController::class, 'sbs_index'])->name('masters.service-sub-status');
        Route::post('/masters/service-sub-status', [MasterController::class, 'sbs_saveupdate'])->name('masters.service-sub-status-store');
        Route::delete('/masters/service-sub-status', [MasterController::class, 'sbs_delete'])->name('masters.service-sub-status-delete');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/masters/service-type', [MasterController::class, 'sts_index'])->name('masters.service-type');
        Route::post('/masters/service-type', [MasterController::class, 'sts_saveupdate'])->name('masters.service-type-store');
        Route::delete('/masters/service-type', [MasterController::class, 'sts_delete'])->name('masters.service-type-delete');
    });
    /*end master routes*/

    Route::middleware('auth')->group(function () {
        Route::get('/dcmanagements', [DcController::class, 'index'])->name('dcmanagements');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/quotmanagements', [QuotationController::class, 'index'])->name('quotmanagements');
        Route::get('/quotmanagements/create', [QuotationController::class, 'create'])->name('quotmanagements.create');
        Route::post('/quotmanagements/store', [QuotationController::class, 'store'])->name('quotmanagements.store');
        Route::get('/quotmanagements/{quotation}/view', [QuotationController::class, 'View'])->name('quotmanagements.view');
        Route::get('/quotmanagements/{quotation}/delete', [QuotationController::class, 'Delete'])->name('quotmanagements.delete');
        Route::get('/quotmanagements/{quotation}/print', [QuotationController::class, 'Print'])->name('quotmanagements.print');
        Route::get('/quotmanagements/{quotation_product}/delete_qp', [QuotationController::class, 'DeleteQP'])->name('quotmanagements.delete_qp');

    });
    Route::middleware('auth')->group(function () {
        Route::get('/employees', [EmployeeController::class, 'index'])->name('employees');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/employee/create', [EmployeeController::class, 'create'])->name('employees.create');
        Route::get('employee/{employee}/view', [EmployeeController::class, 'view'])
            ->name('employees.view');

        Route::post('employees.store', [EmployeeController::class, 'store'])
            ->name('employees.store')
            ->middleware('auth');
        Route::post('employees.status_change', [EmployeeController::class, 'StatusChange'])
            ->name('employees.status_change')
            ->middleware('auth');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name("products");
        Route::get('/products/create', [ProductController::class, 'create'])->name("products.create");
        Route::get('/products/{product}/view', [ProductController::class, 'view'])->name("products.view");
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name("products.edit");
        Route::post('/products/{product}/update', [ProductController::class, 'update'])->name("products.update");
        Route::post('/products/store', [ProductController::class, 'store'])->name("products.store");
        Route::post('/products/{product}/upload', [ProductController::class, 'upload'])->name("products.upload");
        Route::get('/products/product_by_id', [ProductController::class, 'product_by_id'])->name("products.product_by_id");
        Route::get('/products/{productSerialNumber}/delete', [ProductController::class, 'DeleteProductSrNo'])->name("product_srno.delete");
        Route::post('/products/{product}/add-sn', [ProductController::class, 'AddProductSrNo'])->name("products.add-sn");
    });
    Route::get('employees/{employee}/edit', [EmployeeController::class, 'edit'])
        ->name('employees.edit')
        ->middleware('auth');
    Route::middleware('auth')->group(function () {
        Route::post('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::get('/employees/{employee}/delete', [EmployeeController::class, 'deleteEmp'])->name('employees.delete');
        Route::post('/employees/{employee}/password', [EmployeeController::class, 'ResetPassword'])->name('employees.setpassword');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/reports/invoice', [ReportController::class, 'invoice'])->name('reports.invoice');
    });

});
require __DIR__ . '/auth.php';