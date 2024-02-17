<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PDFExportController;
use App\Http\Controllers\MasterController;
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
Route::middleware(['prevent-back-history'])->group(function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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
        Route::post('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    });
    Route::post('clients/{id}/add_cp', [ClientController::class, 'add_cp'])
        ->name('clients.add_cp')
        ->middleware('auth');


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
        Route::get('/contracts/{contract}/view', [ContractController::class, 'view'])->name('contracts.view');
        Route::get('/contracts/{contract}/edit', [ContractController::class, 'edit'])->name('contracts.edit');
        Route::post('/contracts/{contract}/update', [ContractController::class, 'update'])->name('contracts.update');
        Route::post('/contracts/{contract}/add_product', [ContractController::class, 'AddContractProduct'])->name('contracts.add_product');
    });

    /*end contractt*/
    /*Project Route*/
    Route::middleware('auth')->group(function () {
        Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
        Route::post('/add_ref_client', [ProjectController::class, 'AddRefClient'])->name('add_ref_client');
        Route::post('/ref_client/{ref_client}/delete', [ProjectController::class, 'DeleteRefClient'])->name('delete_ref_client');

    });
    Route::post('projects.store', [ProjectController::class, 'store'])
        ->name('projects.store')
        ->middleware('auth');

    Route::get('charakteristisch', [ProjectController::class, 'charakteristisch'])
        ->name('charakteristisch')
        ->middleware('auth');

    Route::get('projects/{project}/view', [ProjectController::class, 'view'])
        ->name('projects.view');

    Route::get('projects/{project}/edit', [ProjectController::class, 'edit'])
        ->name('projects.edit')
        ->middleware('auth');
    Route::middleware('auth')->group(function () {
        Route::post('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    });
    Route::get('projects/{project}/document', [ProjectController::class, 'document'])
        ->name('projects.document')
        ->middleware('auth');
    Route::post('projects.document_store', [ProjectController::class, 'document_store'])
        ->name('projects.document_store')
        ->middleware('auth');
    Route::post('projects/{document}/document_update', [ProjectController::class, 'document_update'])
        ->name('projects.document_update')
        ->middleware('auth');
    Route::get('projects/{document}/doc_view', [ProjectController::class, 'document_view'])
        ->name('projects.document_view')
        ->middleware('auth');
    Route::get('projects.client_info', [ProjectController::class, 'client_info'])
        ->name('projects.client_info')
        ->middleware('auth');
    Route::post('projects/{project}/project_status', [ProjectController::class, 'change_status'])
        ->name('project_status')
        ->middleware('auth');


    /*Employee Route*/
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
    });
    Route::middleware('auth')->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name("products");
        Route::get('/products/create', [ProductController::class, 'create'])->name("products.create");
        Route::get('/products/{product}/view', [ProductController::class, 'view'])->name("products.view");
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name("products.edit");
        Route::post('/products/{product}/update', [ProductController::class, 'update'])->name("products.update");
        Route::post('/products/store', [ProductController::class, 'store'])->name("products.store");
        Route::post('/products/{product}/upload', [ProductController::class, 'upload'])->name("products.upload");
    });
    Route::get('employees/{employee}/edit', [EmployeeController::class, 'edit'])
        ->name('employees.edit')
        ->middleware('auth');
    Route::middleware('auth')->group(function () {
        Route::post('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    });

    /*Documents Route*/
    Route::middleware('auth')->group(function () {
        Route::get('/documents', [DocumentController::class, 'index'])->name('documents');
    });

    /*Setting Route*/
    Route::middleware('auth')->group(function () {
        Route::get('/settings/document', [SettingController::class, 'index'])->name('document-settings');
    });


    /*export to pdf*/
    Route::middleware('auth')->group(function () {
        Route::get('projects/{document}/prufing_pdf_export', [PDFExportController::class, 'prufing_pdf_export'])->name('projects.prufing_pdf_export');
    });

    /*Invoices Route*/
    Route::middleware('auth')->group(function () {
        Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
        Route::get('invoices/get_p_info', [InvoiceController::class, 'get_p_info'])
            ->name('get_p_info');
        Route::get('invoices/{invoice}/view', [InvoiceController::class, 'view'])
            ->name('invoices.view');

        Route::post('invoices/store', [InvoiceController::class, 'store'])
            ->name('store');
        Route::get('invoices/{invoice}/edit', [InvoiceController::class, 'edit'])
            ->name('invoices.edit');
        Route::get('invoices/{invoice}/view', [InvoiceController::class, 'view'])
            ->name('invoices.view');
        Route::post('/invoices/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/invoice-items', [MasterController::class, 'invoice_item_index'])->name("invoice-items");
        Route::get('/invoice-item/create', [MasterController::class, 'invoice_item_create'])->name("invoice-item-create");
        Route::post('/invoice-item/store', [MasterController::class, 'invoice_item_store'])->name("invoice-item-store");
        Route::get('/invoice-item/{invoiceItem}/edit', [MasterController::class, 'invoice_item_edit'])->name("invoice-item-edit");
        Route::post('/invoice-item/update/{invoiceItem}', [MasterController::class, 'invoice_item_update'])->name("invoice-item-update");
    });
    Route::middleware('auth')->group(function () {
        Route::get('/doc-master/prufing_document', [DocMasterController::class, 'index_prufing_document'])->name("doc-master.prufing_document");
        Route::post('/doc-master/{prufing_document}/update', [DocMasterController::class, 'update_prufing_document'])->name("prufing_document.update");
        Route::post('/doc-master/sub_heading/{prufing_content}/update', [DocMasterController::class, 'update_prufing_prufing_content'])->name("prufing_sub_heading.update");
        Route::post('/doc-master/sub_heading/{prufing_heading}/add', [DocMasterController::class, 'add_prufing_prufing_content'])->name("prufing_sub_heading.add");
        Route::post('/doc-master/sub_content/{content_sub_content}/update', [DocMasterController::class, 'update_content_sub_content'])->name("content_sub_content.update");
        Route::post('/doc-master/sub_content/{prufing_content}/add', [DocMasterController::class, 'add_content_sub_content'])->name("content_sub_content.add");

    });

    Route::middleware('auth')->group(function () {
        Route::get('/reports/invoice', [ReportController::class, 'invoice'])->name('reports.invoice');
    });
    require __DIR__ . '/auth.php';
});