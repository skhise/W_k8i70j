<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\DcController;
use App\Http\Controllers\RepairInwardController;
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
// Route::get('/master_setup_api', [ProfileController::class, 'master_setup'])->name('master_setup_api');
Route::get('/generate', [ProfileController::class, 'master_setup'])->name('generate');

Route::middleware(['prevent-back-history', 'menu.permission'])->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/', function() {
            // Redirect role 0 users to customers page
            if (Auth::user()->role == 0) {
                return redirect()->route('customers.index');
            }
            return redirect()->route('dashboard');
        });
    });

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/google-drive', [ProfileController::class, 'updateGoogleDriveCredentials'])->name('profile.update-google-drive');
        Route::get('/profile/google-auth', [ProfileController::class, 'generateGoogleRefreshToken'])->name('profile.google-auth');
        Route::get('/profile/google-auth/callback', [ProfileController::class, 'googleAuthCallback'])->name('profile.google-auth-callback');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/limit', [ProfileController::class, 'limit'])->name('limit');
        Route::post('/change-password', [ProfileController::class, 'change_password'])->name('profile.change-password');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/reports/contract-report', [ReportController::class, 'cr_index'])->name('contract-report');
        Route::get('/reports/{contract}/contract-report-summary', [ReportController::class, 'crs_index'])->name('contract-report-summary');
        Route::get('/reports/contract-report-data', [ReportController::class, 'cr_data'])->name('contract-report-data');
        Route::get('/reports/contract-report-export', [ReportController::class, 'cr_export'])->name('contract-report-export');
        Route::get('/reports/service-report-export', [ReportController::class, 'sr_export'])->name('service-report-export');
        Route::get('/reports/service-status-report-export', [ReportController::class, 'srs_export'])->name('service-status-report-export');
        Route::get('/reports/engineer-report-export', [ReportController::class, 'engineer_export'])->name('engineer-report-export');
         Route::get('/reports/dec-report-export', [ReportController::class, 'dc_export'])->name('dc-report-export');
        Route::get('/analysis/contract-service-report', [ReportController::class, 'csr_index'])->name('contract-service-report');
        Route::get('/reports/dc-report', [ReportController::class, 'dc_index'])->name('dc-report');
        Route::get('/reports/dc-report-data', [ReportController::class, 'dc_report_data'])->name('dc-report-data');
        Route::get('/reports/quotation-report', [ReportController::class, 'quotation_index'])->name('quotation-report');
        Route::get('/reports/quot-report-export', [QuotationController::class, 'quot_export'])->name('quot-report-export');
       
        Route::get('/reports/contract-due-report', [ReportController::class, 'crd_index'])->name('contract-due-report');
        Route::get('/reports/contract-due-report-data', [ReportController::class, 'crd_data'])->name('contract-due-report-data');
        Route::get('/reports/contract-due-report-export', [ReportController::class, 'crd_data_export'])->name('contract-due-report-data-export');
        
        Route::get('/reports/renewal-report', [ReportController::class, 'renewal_index'])->name('renewal-report');
        Route::get('/reports/renewal-report-data', [ReportController::class, 'renewal_data'])->name('renewal-report-data');
        Route::get('/reports/renewal-report-export', [ReportController::class, 'renewal_export'])->name('renewal-report-export');


        Route::get('/reports/service-ticket-report', [ReportController::class, 'str_index'])->name('service-ticket-report');
        Route::get('/reports/service-ticket-report-data', [ReportController::class, 'GetServiceCallReport'])->name('service-ticket-report-data');

        Route::get('/reports/service-status-report', [ReportController::class, 'strs_index'])->name('service-status-report');
        Route::get('/reports/service-status-report-data', [ReportController::class, 'GetServiceCallReportStatus'])->name('service-status-report-data');

        Route::get('/reports/engineer-report', [ReportController::class, 'etr_index'])->name('engineer-report');

        Route::get('/reports/engineer-ticket-report-data', [ReportController::class, 'GetEngineerCallReport'])->name('engineer-ticket-report-data');

        Route::get('/analysis/contract-service-report-data', [ReportController::class, 'csr_data'])->name('contract-service-report-data');

        Route::get('/analysis/GetAnalysisReport', [ReportController::class, 'GetAnalysisReport'])->name('GetAnalysisReport');

        Route::get('/analysis/engineer-service-analysis', [ReportController::class, 'easr_index'])->name('engineer-service-analysis');
        Route::get('/analysis/GetEngineerAnalysisReport', [ReportController::class, 'GetEngineerAnalysisReport'])->name('GetEngineerAnalysisReport');

        Route::get('/reports/logs', [ReportController::class, 'Logs'])->name('logs');
        Route::get('/reports/logs_data', [ReportController::class, 'Logs_Data'])->name('logs_data');
        Route::get('/reports/logs-export', [ReportController::class, 'logs_export'])->name('logs-export');
        Route::get('/reports/inward-report', [ReportController::class, 'inward_report_index'])->name('inward-report');
        Route::get('/reports/inward-report-export', [ReportController::class, 'inward_report_export'])->name('inward-report-export');

        Route::get('/attendance', [ReportController::class, 'Attendance'])->name('attendance');
        Route::get('/attendance/atte_data', [ReportController::class, 'Atte_Data'])->name('atte_data');
    });


    /*Customers Route (Super Admin)*/
    Route::middleware('auth')->group(function () {
        Route::get('/customers', [\App\Http\Controllers\CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/create', [\App\Http\Controllers\CustomerController::class, 'create'])->name('customers.create');
        Route::post('/customers', [\App\Http\Controllers\CustomerController::class, 'store'])->name('customers.store');
        Route::post('/customers/{id}/reset-password', [\App\Http\Controllers\CustomerController::class, 'resetPassword'])->name('customers.resetPassword');
        Route::post('/customers/{id}/update-status', [\App\Http\Controllers\CustomerController::class, 'updateStatus'])->name('customers.updateStatus');
        Route::delete('/customers/{id}', [\App\Http\Controllers\CustomerController::class, 'destroy'])->name('customers.destroy');
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
        Route::get('/contracts/{contract}/get-products-tab', [ContractController::class, 'getProductsTab'])->name('contracts.get-products-tab');
        Route::get('/contracts/{contract}/get-services-tab', [ContractController::class, 'getServicesTab'])->name('contracts.get-services-tab');
        Route::get('/contracts/{contract}/get-checklist-tab', [ContractController::class, 'getChecklistTab'])->name('contracts.get-checklist-tab');
        Route::get('/contracts/{contract}/edit', [ContractController::class, 'edit'])->name('contracts.edit');
        Route::get('/contracts/{contract}/delete', [ContractController::class, 'DeleteContract'])->name('contracts.delete');
        Route::post('/contracts/{contract}/update', [ContractController::class, 'update'])->name('contracts.update');
        Route::post('/contracts/{contract}/add_product', [ContractController::class, 'AddContractProduct'])->name('contracts.add_product');
        Route::post('/contracts/{contract}/update_product', [ContractController::class, 'UpdateContractProduct'])->name('contracts.update_product');
        Route::get('/contracts/customer_contract', [ContractController::class, 'GetContractByCustId'])->name('contracts.customer_contract');
        Route::get('/contracts/contract_by_id', [ContractController::class, 'GetContractById'])->name('contracts.contract_by_id');
        Route::get('/contracts/puc/{contractUnderProduct}/delete', [ContractController::class, 'DeleteContractProduct'])->name('contract_product.delete');
        Route::post('/contracts/checklist/{contract}/store', [ContractController::class, 'checklistStore'])->name('checklist.store');
        Route::get('/contracts/checklist/{checklist}/delete', [ContractController::class, 'checklistdelete'])->name('checklist.delete');
        Route::post('/contracts/service/{contract}/store', [ContractController::class, 'serviceStore'])->name('contract_service.store');
        Route::post('/contracts/service/{contract}/update', [ContractController::class, 'serviceUpdate'])->name('contract_service.update');
        Route::get('/contracts/service/{contractScheduleService}/delete', [ContractController::class, 'servicedelete'])->name('contract_service.delete');
        Route::get('/contract-products', [ContractController::class, 'index_products'])->name('contracts.products');
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
    Route::middleware('auth')->group(function () {
        Route::get('/masters/issue-type', [MasterController::class, 'issue_index'])->name('masters.issue-type');
        Route::post('/masters/issue-type', [MasterController::class, 'issue_saveupdate'])->name('masters.issue-type-store');
        Route::delete('/masters/issue-type', [MasterController::class, 'issue_delete'])->name('masters.issue-type-delete');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/masters/designation', [MasterController::class, 'designation_index'])->name('masters.designation');
        Route::post('/masters/designation', [MasterController::class, 'designation_saveupdate'])->name('masters.designation-store');
        Route::delete('/masters/designation', [MasterController::class, 'designation_delete'])->name('masters.designation-delete');
    });
    /*end master routes*/

    Route::middleware('auth')->group(function () {
        Route::get('/dcmanagements', [DcController::class, 'index'])->name('dcmanagements');
    });
    Route::middleware('auth')->group(function () {
        // Define specific routes BEFORE resource route to avoid route conflicts
        Route::get('/repairinwards/get-tickets', [RepairInwardController::class, 'getTicketsByCustomer'])->name('repairinwards.get-tickets');
        Route::get('/repairinwards/get-data', [RepairInwardController::class, 'getData'])->name('repairinwards.get-data');
        Route::get('/repairinwards/export', [RepairInwardController::class, 'export'])->name('repairinwards.export');
        Route::post('/repairinwards/{repairinward}/update-status', [RepairInwardController::class, 'updateStatus'])->name('repairinwards.update-status');
        Route::resource('repairinwards', RepairInwardController::class);
    });
    Route::middleware('auth')->group(function () {
        Route::get('/quotmanagements', [QuotationController::class, 'index'])->name('quotmanagements');
        Route::get('/quotmanagements/create', [QuotationController::class, 'create'])->name('quotmanagements.create');
        Route::post('/quotmanagements/store', [QuotationController::class, 'store'])->name('quotmanagements.store');
        Route::get('/quotmanagements/{quotation}/view', [QuotationController::class, 'View'])->name('quotmanagements.view');
        Route::get('/quotmanagements/{quotation}/delete', [QuotationController::class, 'delete'])->name('quotmanagements.delete');
        Route::get('/quotmanagements/{quotation}/print', [QuotationController::class, 'Print'])->name('quotmanagements.print');
        Route::get('/quotmanagements/{quotation}/status-update/{quotationstatus}', action: [QuotationController::class, 'StatusUpdate'])->name('quotmanagements.status-update');
        Route::get('/quotmanagements/{quotation_product}/delete_qp', [QuotationController::class, 'DeleteQP'])->name('quotmanagements.delete_qp');

    });
    Route::middleware('auth')->group(function () {
        Route::get('/employees', [EmployeeController::class, 'index'])->name('employees');
        Route::get('employee/{employee}/view', [EmployeeController::class, 'view'])
            ->name('employees.view');
        Route::post('employees.status_change', [EmployeeController::class, 'StatusChange'])
            ->name('employees.status_change');

    });
    ;

    Route::middleware(['auth', 'validate'])->group(function () {

        Route::post('employees.store', [EmployeeController::class, 'store'])
            ->name('employees.store');
        Route::get('/employee/create', [EmployeeController::class, 'create'])
            ->name('employees.create');

    });
    Route::middleware('auth')->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name("products");
        Route::get('/products/create', [ProductController::class, 'create'])->name("products.create");
        Route::get('/products/{product}/view', [ProductController::class, 'view'])->name("products.view");
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name("products.edit");
        Route::get('/products/{product}/delete', [ProductController::class, 'DeleteProduct'])->name("products.delete");
        Route::post('/products/{product}/update', [ProductController::class, 'update'])->name("products.update");
        Route::post('/products/store', [ProductController::class, 'store'])->name("products.store");
        Route::post('/products/{product}/upload', [ProductController::class, 'upload'])->name("products.upload");
        Route::get('/products/product_by_id', [ProductController::class, 'product_by_id'])->name("products.product_by_id");
        Route::get('/products/{productSerialNumber}/sr/delete', [ProductController::class, 'DeleteProductSrNo'])->name("product_srno.delete");
        Route::post('/products/{product}/add-sn', [ProductController::class, 'AddProductSrNo'])->name("products.add-sn");
    });


    Route::middleware('auth')->group(function () {
        Route::get('employees/{employee}/edit', [EmployeeController::class, 'edit'])
            ->name('employees.edit');

        Route::get('location', [EmployeeController::class, 'location'])
            ->name('location');
        Route::get('location-report', [EmployeeController::class, 'locationReport'])
            ->name('location-report');
        Route::get('location-data', [EmployeeController::class, 'Location_Data'])
            ->name('location-data');
        Route::get('getlocation/{userId}', [EmployeeController::class, 'getlocation'])
            ->name('getlocation');
        Route::get('location-all', [EmployeeController::class, 'getLocationAll'])
            ->name('location-all');

        Route::post('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::get('/employees/{employee}/delete', [EmployeeController::class, 'deleteEmp'])->name('employees.delete');
        Route::post('/employees/{employee}/password', [EmployeeController::class, 'ResetPassword'])->name('employees.setpassword');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/reports/invoice', [ReportController::class, 'invoice'])->name('reports.invoice');
    });



});
require __DIR__ . '/auth.php';