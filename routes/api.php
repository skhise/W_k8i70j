<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\VisitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppUserController;

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
Route::group(['namespace' => 'API', 'prefix' => 'v1', 'middleware' => ['cors', 'throttle:500,1']], function () {
    Route::post("signin", [AppUserController::class, "SignIn"]);
    Route::post("signup", [AppUserController::class, "SignUp"]);
    Route::get("GetTickets", [AppUserController::class, "GetTickets"]);
    Route::get("GetServiceTicketByIdCustomer", [AppUserController::class, "GetServiceTicketByIdCustomer"]);
    Route::get("GetServiceTicketById", [AppUserController::class, "GetServiceTicketById"]);
    Route::get("engineerDashboard", [AppUserController::class, "EngineerDashboard"]);
    Route::get("ApplyServiceAction", [AppUserController::class, "ApplyServiceAction"]);
    Route::get("ApplyRejectAction", [AppUserController::class, "ApplyRejectAction"]);
    Route::get("GetStatusListApp", [AppUserController::class, "GetStatusList"]);
    Route::get("GetReasonList", [AppUserController::class, "GetReasonList"]);
    Route::get('get_serviceType_list', [AppUserController::class, "GetServiceTypeList"]);
    Route::get('get_issueType_list', [AppUserController::class, "GetIssueTypeList"]);
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
    Route::get("GetAllProductType", [AppUserController::class, "GetProductType"]);
    Route::get("GetAllProductListByTypeApp", [AppUserController::class, "GetAllProductListByTypeApp"]);
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
    Route::get('markOnlineOffline', [AppUserController::class, 'markOnlineOffline']);
    Route::get('GetProfile', [AppUserController::class, 'Profile']);
    Route::get('GetRecentActivity', [AppUserController::class, 'GetRecentActivity']);
    Route::post('test-push-notification', [AppUserController::class, 'testPushNotification']);
    
    // FCM Token test route
    Route::post('test-fcm-token', [AppUserController::class, 'testFCMToken']);
    
    // Service attachment routes
    Route::post('uploadServiceAttachment', [AppUserController::class, 'uploadServiceAttachment']);
    Route::get('getServiceAttachments', [AppUserController::class, 'getServiceAttachments']);
    
    // Google Drive credentials routes
    Route::get('getGoogleDriveCredentials', [AppUserController::class, 'getGoogleDriveCredentials']);
    Route::post('updateGoogleDriveCredentials', [AppUserController::class, 'updateGoogleDriveCredentials']);
    
    // Notification routes
    Route::get('GetNotifications', [App\Http\Controllers\NotificationController::class, 'getNotifications']);
    Route::get('GetNotificationCount', [App\Http\Controllers\NotificationController::class, 'getNotificationCount']);
    Route::post('MarkNotificationAsRead', [App\Http\Controllers\NotificationController::class, 'markNotificationAsRead']);
    Route::post('MarkAllNotificationsAsRead', [App\Http\Controllers\NotificationController::class, 'markAllNotificationsAsRead']);
    
    /*end app controller*/

    Route::get('GetEngineerAttendance', [AttendanceController::class, 'GetEngineerAttendance']);
    Route::post('MarkPunch', [AttendanceController::class, 'AddPunch']);
    Route::post("AddPunchAdmin", [AttendanceController::class, 'AddPunchAdmin']);
    Route::post("update/{id}", [AttendanceController::class, 'AddPunchAdmin']);
    Route::get("GetAttendanceById", [AttendanceController::class, 'GetAttendanceById']);
    Route::get('GetAttendanceByDate', [AttendanceController::class, 'GetAttendanceByDate']);
    Route::get("GetAttendanceList", [AttendanceController::class, "GetAttendanceList"]);
    Route::get("UpdateLeaveRequest", [AttendanceController::class, "UpdateLeaveRequest"]);

    /*visit controller*/
    Route::get('GetVisitData', [VisitController::class, 'GetVisitData']);
    Route::get("GetUserVisits", [VisitController::class, "GetUserVisits"]);
    Route::get('GetVisitType', [VisitController::class, 'GetVisitType']);
    Route::get('GetVisitStatus', [VisitController::class, 'GetVisitStatus']);
    Route::post('NewVisit', [VisitController::class, 'NewVisit']);
    Route::get('GetUserVisitsById', [VisitController::class, 'GetUserVisitsById']);
    Route::get('GetVisitById', [VisitController::class, "GetVisitById"]);


    /*end visit controller*/

});
Route::get('send-mail', function () {

    $details = [
        'title' => 'Test Mail',
        'body' => 'This is a test email using SMTP'
    ];

    \Mail::to('shekhar.khise@gmail.com')->send(new \App\Mail\MailSender($details));

    dd("Mail Sent Successfully.");
});




