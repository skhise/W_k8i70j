<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\StoreProductController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppUserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\AttendanceReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get("getAllUsers", [EmployeeController::class, 'getAllUsers']);
Route::post("userLoginNew", [UserController::class, 'userLoginNew']);
Route::post("login", [UserController::class, 'userLogin']);
Route::get("profile", [UserController::class, 'Profile']);
Route::get("markOnlineOffline", [UserController::class, 'MarkOnLineOffline']);
/*payment*/

Route::post("init", [PaymentController::class, 'init']);
Route::get("credimax-response", [PaymentController::class, 'credimax_response']);
Route::post("payment_status", [PaymentController::class, 'Payment_Status']);
Route::post("benefit_response", [PaymentController::class, "benefit_response"]);
/*end payment*/

/*dashboard*/
Route::get("GetDashboard", [DashboardController::class, 'GetDashboard']);
Route::get("GetLatestServices", [DashboardController::class, 'GetLatestServices']);
Route::get("GetContractData", [DashboardController::class, 'GetContractData']);
Route::get("GetScheduleCount", [DashboardController::class, 'GetScheduleCount']);
Route::get("GetDashboardAttendance", [DashboardController::class, 'GetDashboardAttendance']);
Route::get("GetLatestPunch", [DashboardController::class, 'GetLatestPunch']);
Route::get("GetEmployeeData", [DashboardController::class, 'GetEmployeeData']);

/*dashboard end*/

Route::post("add_customer", [CustomerController::class, 'addCustomer']);
Route::post("edit_customer", [CustomerController::class, 'UpdateCustomer']);
Route::get("get_customer", [CustomerController::class, 'GetCustomers']);
Route::get("GetCustomerById", [CustomerController::class, 'GetCustomerById']);
Route::get("GetCustomerContacts", [CustomerController::class, 'GetCustomerContacts']);
Route::get("GetCustomerSites", [CustomerController::class, 'GetCustomerSites']);
Route::get("GetAreaNameMaster", [CustomerController::class, 'GetAreaNameMaster']);
Route::post("AddCustomerSite", [CustomerController::class, 'AddCustomerSite']);
Route::post("UpdateCustomerSite", [CustomerController::class, 'UpdateCustomerSite']);
Route::post("AddCustomerContact", [CustomerController::class, 'AddCustomerContact']);
Route::post("UpdateCustomerContact", [CustomerController::class, 'UpdateCustomerContact']);
Route::post("DeleteCustomer", [CustomerController::class, "DeleteCustomer"]);

Route::get('GetEngineerAttendance', [AttendanceController::class, 'GetEngineerAttendance']);
Route::post('MarkPunch', [AttendanceController::class, 'AddPunch']);
Route::post("AddPunchAdmin", [AttendanceController::class, 'AddPunchAdmin']);
Route::post("update/{id}", [AttendanceController::class, 'AddPunchAdmin']);
Route::get("GetAttendanceById", [AttendanceController::class, 'GetAttendanceById']);
Route::get('GetAttendanceByDate', [AttendanceController::class, 'GetAttendanceByDate']);
Route::post('SaveLeaveApplication', [AttendanceController::class, 'SaveLeaveApplication']);
Route::get('GetLeaveApplication', [AttendanceController::class, 'GetLeaveApplication']);
Route::get("GetAttendanceList", [AttendanceController::class, "GetAttendanceList"]);
Route::get("GetLeaveApplicationAdmin", [AttendanceController::class, "GetLeaveApplicationAdmin"]);
Route::get("UpdateLeaveRequest", [AttendanceController::class, "UpdateLeaveRequest"]);

Route::get("GetEmployeeAttendanceReport", [AttendanceReportController::class, "GetEmployeeAttendanceReport"]);
Route::get("GetLeaveReport", [AttendanceReportController::class, "GetLeaveReport"]);
Route::get("GetVisitsReport", [AttendanceReportController::class, "GetVisitsReport"]);
Route::get("GetLocationReport", [AttendanceReportController::class, "GetLocationReport"]);

Route::get("GetEmployeeById", [EmployeeController::class, 'GetEmployeeById']);
Route::get("get_employee", [EmployeeController::class, 'GetEmployees']);
Route::post("add_employee", [EmployeeController::class, 'AddEmployee']);
Route::post("edit_employee", [EmployeeController::class, 'UpdateEmployee']);
Route::post("CPRUpdate", [EmployeeController::class, 'CPRUpdate']);
Route::post("PicUpdate", [EmployeeController::class, 'PicUpdate']);
Route::post("ResetPasswordWeb", [EmployeeController::class, 'ResetPassword']);
Route::post("DeActivate", [EmployeeController::class, 'DeActivate']);
Route::post("DeleteEmployee", [EmployeeController::class, "DeleteEmployee"]);

/*visit controller*/
Route::get('GetVisitData', [VisitController::class, 'GetVisitData']);
Route::get("GetUserVisits", [VisitController::class, "GetUserVisits"]);
Route::get('GetVisitType', [VisitController::class, 'GetVisitType']);
Route::get('GetVisitStatus', [VisitController::class, 'GetVisitStatus']);
Route::post('NewVisit', [VisitController::class, 'NewVisit']);
Route::get('GetUserVisitsById', [VisitController::class, 'GetUserVisitsById']);
Route::get('GetVisitById', [VisitController::class, "GetVisitById"]);


/*end visit controller*/

/* notification start*/
Route::patch('/fcm-token', [UserController::class, 'updateToken'])->name('fcmToken');
Route::post('/send-notification', [UserController::class, 'notification'])->name('notification');

/*notification end*/

Route::post("add-product", [ProductController::class, "AddProduct"]);
Route::post("update-product", [ProductController::class, "UpdateProduct"]);
Route::get("product-list", [ProductController::class, "GetProducts"]);
Route::get("GetProductById", [ProductController::class, "GetProductById"]);
Route::get("GetProductAccessory", [ProductController::class, "GetProductAccessory"]);
Route::post("AddProductAccessory", [ProductController::class, "AddProductAccessory"]);
Route::post("UpdateProductAccessory", [ProductController::class, "UpdateProductAccessory"]);
Route::post("UpdateProductImageContract", [ProductController::class, "UpdateProductImage"]);
Route::post("DeleteProduct", [ProductController::class, "DeleteProduct"]);
Route::get("GetProductType", [ProductController::class, "GetProductType"]);
Route::get("GetContractProduct", [ProductController::class, "GetContractProduct"]);
Route::get("GetContractProductList", [ProductController::class, "GetContractProductList"]);
Route::get("GetContractProductById", [ProductController::class, "GetContractProductById"]);


/*contract mangement start*/
Route::get("get_contracts", [ContractController::class, 'GetContracts']);
Route::get("get_ContractSiteType", [ContractController::class, "GetContractSiteType"]);
Route::get("get_ContractType", [ContractController::class, "GetContractType"]);
Route::get("get_ContractStatus", [ContractController::class, "GetContractStatus"]);
Route::get("get_CustomerList", [ContractController::class, "GetCustomerList"]);
Route::get("get_ProductList", [ContractController::class, "GetProductList"]);
Route::get("get_ScheduleList", [ContractController::class, "GetScheduleList"]);
Route::get("get_ProductAccessoryList", [ContractController::class, "GetProductAccessory"]);
Route::post("add_contract_product", [ContractController::class, "AddContractProduct"]);
Route::get("GetContractNumber", [ContractController::class, "GetContractNumber"]);
Route::post("add_contract", [ContractController::class, "AddContract"]);
Route::post("edit_contract", [ContractController::class, "UpdateContract"]);
Route::get("get_contractby_id", [ContractController::class, "GetContractById"]);
Route::get("get_contractpaby_id", [ContractController::class, "GetContractProductAccessoryById"]);
Route::get("get_contract_service", [ContractController::class, "GetContractSchedules"]);
Route::post("add_contract_service", [ContractController::class, "AddContractScheduleService"]);
Route::post("AddContractScheduleServiceOne", [ContractController::class, "AddContractScheduleServiceOne"]);
Route::post("UpdateContractScheduleServiceOne", [ContractController::class, "UpdateContractScheduleServiceOne"]);
Route::get("getPrintContractAccessory", [ContractController::class, "getPrintContractAccessory"]);
Route::post("AddContractProductAccessory", [ContractController::class, "AddContractProductAccessory"]);
Route::post("UpdateContractProductAccessory", [ContractController::class, "UpdateContractProductAccessory"]);
Route::post("Add_Contract_Attachement", [ContractController::class, "UploadAttachment"]);
Route::get("GetAttachments", [ContractController::class, "GetAttachments"]);
Route::post("Add_Contract_ProductImage", [ContractController::class, "Add_Contract_ProductImage"]);
Route::get("GetContractProductImagesById", [ContractController::class, "GetContractProductImagesById"]);
Route::post("UpdateSubject", [ContractController::class, "UpdateSubject"]);
Route::post("UpdateSocpeOfWork", [ContractController::class, "UpdateSocpeOfWork"]);
Route::post("UpdateBody", [ContractController::class, "UpdateBody"]);
Route::post("DeleteAttachment", [ContractController::class, "DeleteAttachment"]);
Route::post("DeleteScheduleService", [ContractController::class, "DeleteScheduleService"]);
Route::post("DeleteContract", [ContractController::class, "DeleteContract"]);
Route::post("UpdateContractUnderProduct", [ContractController::class, "UpdateContractUnderProduct"]);
Route::post("DeleteContractProduct", [ContractController::class, "DeleteContractProduct"]);

/* contract management end */

/*Service Management*/

Route::get("get_customer_list", [ServiceController::class, "GetCustomerList"]);
Route::get("get_priority_list", [ServiceController::class, "GetPriority"]);
Route::get("get_serviceType_list", [ServiceController::class, "GetServiceType"]);
Route::get("get_issueType_list", [ServiceController::class, "GetIssueType"]);
Route::get("get_contract_by_customer", [ServiceController::class, "GetContractByCustId"]);
Route::get("get_contract_by_id", [ServiceController::class, "GetContractDetailsById"]);
Route::get("get_customer_by_id", [ServiceController::class, "GetCustomerById"]);
Route::get("GetServiceNumber", [ServiceController::class, "GetServiceNumber"]);
Route::get("GetServiceCallById", [ServiceController::class, "GetServiceCallById"]);
Route::get("GetEngineerList", [ServiceController::class, "GetEngineerList"]);
Route::get("AssignEngineer", [ServiceController::class, "AssignEngineer"]);
Route::get("GetServiceHistory", [ServiceController::class, "GetServiceHistory"]);
Route::get("GetReasonList", [ServiceController::class, "GetReasonList"]);
Route::get("GetStatusList", [ServiceController::class, "GetStatusList"]);
Route::get("ApplyServiceActionWeb", [ServiceController::class, "ApplyServiceAction"]);
Route::post("AddFieldReport", [ServiceController::class, "AddFieldReport"]);
Route::get("GetServiceFieldReport", [ServiceController::class, "GetServiceFieldReport"]);


Route::get("GetContractProductListService", [ServiceController::class, "GetContractProductListService"]);
Route::get("GetContractProductAccessory", [ServiceController::class, "GetContractProductAccessory"]);
Route::get("GetContractProductAccessoryById", [ServiceController::class, "GetContractProductAccessoryById"]);

Route::get("GetAllProductList", [ServiceController::class, "GetAllProductList"]);
Route::get("GetAllProductAccessory", [ServiceController::class, "GetAllProductAccessory"]);
Route::get("GetAllProductAccessoryById", [ServiceController::class, "GetAllProductAccessoryById"]);

Route::post("AddServiceCall", [ServiceController::class, "AddServiceCall"]);
Route::post("UpdateServiceCall", [ServiceController::class, "UpdateServiceCallById"]);

Route::get("GetServiceCall", [ServiceController::class, "GetServiceCall"]);
Route::get("GetServiceAccessory", [ServiceController::class, "GetServiceAccessory"]);
Route::get("GetServiceProduct", [ServiceController::class, "GetServiceProduct"]);
Route::post("AddServiceCallManage", [ServiceController::class, "AddServiceCallManage"]);
Route::post("AddServiceCallAccessory", [ServiceController::class, "AddServiceCallAccessory"]);
Route::post("UpdateServiceAccessory", [ServiceController::class, "UpdateServiceAccessory"]);
Route::post("DeleteService", [ServiceController::class, "DeleteService"]);
Route::post('DeleteServiceAccesorry', [ServiceController::class, "DeleteServiceAccesorry"]);
Route::post('AddUpdateUnderServiceProduct', [ServiceController::class, "AddUpdateUnderServiceProduct"]);
Route::get('GetServiceUnderProduct', [ServiceController::class, "GetServiceUnderProduct"]);





/*Service Management End*/
//
//
//Route::fallback(function(){
//    return response()->json([
//        'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
//});

/* Master Controller Start */

Route::get("GetDesignation", [MasterController::class, "GetDesignation"]);
Route::get("GetSiteArea", [MasterController::class, "GetSiteArea"]);
Route::get("GetAccountSetting", [MasterController::class, "Account_Setting"]);
Route::post("Designation", [MasterController::class, "Designation"]);
Route::post("SiteArea", [MasterController::class, "SiteArea"]);
Route::get("GetServiceType", [MasterController::class, "GetServiceType"]);
Route::post("ServiceType", [MasterController::class, "ServiceType"]);
Route::get("GetIssueType", [MasterController::class, "GetIssueType"]);
Route::post("IssueType", [MasterController::class, "IssueType"]);
Route::get("GetContractType", [MasterController::class, "GetContractType"]);
Route::post("ContractType", [MasterController::class, "ContractType"]);
Route::get("GetProductCategory", [MasterController::class, "GetProductCategory"]);
Route::post("ProductCategory", [MasterController::class, "ProductCategory"]);
Route::get("GetRoleAccess", [MasterController::class, "GetRoleAccess"]);


/* Master Controller End */

/* Enquiry Controller Start */

Route::get("GetEnquiries", [EnquiryController::class, "GetEnquiryList"]);
Route::get("DeleteEnquiry", [EnquiryController::class, "DeleteEnquiry"]);
Route::get("UpdateEnquiry", [EnquiryController::class, "UpdateEnquiry"]);
/* Enquiry Controller End */

/* Request Controller Start */

Route::get("GetRequest", [RequestController::class, "GetRequestList"]);
Route::get("DeleteRequest", [RequestController::class, "DeleteRequest"]);
Route::get("UpdateRequest", [RequestController::class, "UpdateRequest"]);


/* Request Controller End */

Route::get("getCategoryList", [StoreProductController::class, "getCategoryList"]);
Route::get("getBrandList", [StoreProductController::class, "getBrandList"]);
Route::post("AddStoreProduct", [StoreProductController::class, "AddStoreProduct"]);
Route::get("GetStoreProducts", [StoreProductController::class, "GetStoreProducts"]);
Route::get("GetStoreProductById", [StoreProductController::class, "GetStoreProductById"]);
Route::post("UpdateStoreProduct", [StoreProductController::class, "UpdateStoreProduct"]);
Route::post("UpdateProductImage", [StoreProductController::class, "UpdateProductImage"]);



/*store api end*/


/*Schedule Start*/
Route::get("GetScheduleList", [ScheduleController::class, "GetScheduleList"]);
/*Schedule End*/

/*Report Controller*/
Route::get("GetServiceCallReport", [ReportController::class, "GetServiceCallReport"]);
Route::get("GetContractReport", [ReportController::class, "GetContractReport"]);
Route::get("GetStatusListAll", [ReportController::class, "GetStatusListAll"]);
Route::get("GetServiceCallReportByService", [ReportController::class, "GetServiceCallReportByService"]);
Route::get("GetCustomerReport", [ReportController::class, "GetCustomerReport"]);
Route::get("GetServicePaymentReportByService", [ReportController::class, 'GetServicePaymentReportByService']);
Route::get("GetAnalysisReport", [ReportController::class, 'GetAnalysisReport']);
Route::get("GetUserEmployeeLogReport", [ReportController::class, 'GetUserEmployeeLogReport']);


/*Report Controller*/

/*Start Mail Controller*/
Route::get('sendbasicemail', [MailController::class, 'basic_email']);
Route::post('AddMailSettings', [MailController::class, 'StoreMailSetting']);
Route::get('GetMailSettings', [MailController::class, 'GetMailSettings']);
Route::get('SendTestMail', [MailController::class, 'SendTestMail']);
/*End Mail Controller*/

/*Order Controller*/

Route::get("GetOrderList", [OrderController::class, "GetOrderList"]);
Route::post("NewOrder", [OrderController::class, "NewOrder"]);
Route::get("GetOrderById", [OrderController::class, "GetOrderById"]);
Route::get("UpdateOrderStatus", [OrderController::class, "UpdateOrderStatus"]);
Route::get("UpdateOrder", [OrderController::class, "UpdateOrder"]);


/*End Order Controller*/


/*app controller*/

Route::post("signin", [AppUserController::class, "SignIn"]);
Route::post("signup", [AppUserController::class, "SignUp"]);
Route::get("GetTickets", [AppUserController::class, "GetTickets"]);
Route::get("GetServiceTicketByIdCustomer", [AppUserController::class, "GetServiceTicketByIdCustomer"]);
Route::get("GetServiceTicketById", [AppUserController::class, "GetServiceTicketById"]);
Route::get("engineerDashboard", [AppUserController::class, "EngineerDashboard"]);
Route::get("ApplyServiceAction", [AppUserController::class, "ApplyServiceAction"]);
Route::get("GetStatusListApp", [AppUserController::class, "GetStatusList"]);
Route::get("GetReasonList", [AppUserController::class, "GetReasonList"]);
Route::get("GetServiceHistoryApp", [AppUserController::class, "GetServiceHistory"]);
Route::get("GetTicketListCustomer", [AppUserController::class, "GetTicketListCustomer"]);
Route::get("GetContractListByCustomer", [AppUserController::class, "GetContractListByCustomer"]);
Route::get("GetStoreProductsApp", [AppUserController::class, "GetStoreProductsApp"]);
Route::get("GetStoreProductsBestOfferApp", [AppUserController::class, "GetStoreProductsBestOfferApp"]);
Route::get("GetStoreProductsBestPlanApp", [AppUserController::class, "GetStoreProductsBestPlanApp"]);
Route::get("getCategoryListApp", [AppUserController::class, "getCategoryListApp"]);
Route::post("AddFieldReportApp", [AppUserController::class, "AddFieldReportApp"]);
Route::get("GetServiceFieldReportApp", [AppUserController::class, "GetServiceFieldReportApp"]);
Route::get("GetContractProductListApp", [AppUserController::class, "GetContractProductListApp"]);
Route::get("GetContractProductAccessoryApp", [AppUserController::class, "GetContractProductAccessoryApp"]);
Route::get("GetAllProductListApp", [AppUserController::class, "GetAllProductListApp"]);
Route::get("GetAllProductAccessoryApp", [AppUserController::class, "GetAllProductAccessoryApp"]);
Route::post("AddServiceCallAccessoryApp", [AppUserController::class, "AddServiceCallAccessoryApp"]);
Route::post("UpdatePassword", [AppUserController::class, "UpdatePassword"]);
Route::post("UpdateProfile", [AppUserController::class, "UpdateProfile"]);
Route::post("NewInquiry", [AppUserController::class, "SaveNewInquiry"]);
Route::post("NewRequest", [AppUserController::class, "SaveServiceRequest"]);
Route::get("AccountSetting", [AppUserController::class, "GetAccountSettings"]);
Route::get("CloseCall", [AppUserController::class, "FinalTicketClose"]);
Route::post('fcmtokenApp', [AppUserController::class, 'updateToken']);
/*end app controller*/
Route::get('send-mail', function () {

    $details = [
        'title' => 'Test Mail',
        'body' => 'This is a test email using SMTP'
    ];

    \Mail::to('shekhar.khise@gmail.com')->send(new \App\Mail\MailSender($details));

    dd("Mail Sent Successfully.");
});




