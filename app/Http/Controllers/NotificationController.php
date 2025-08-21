<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Service;
use App\Models\ServiceHistory;
use Exception;

class NotificationController extends Controller
{
    /**
     * Get notifications for a user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotifications(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer|exists:users,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ]);
            }

            $userId = $request->user_id;

            // Get recent service activities for the user
            $notifications = ServiceHistory::where('user_id', $userId)
                ->join('services', 'services.id', '=', 'service_history.service_id')
                ->join('master_service_status', 'master_service_status.Status_Id', '=', 'service_history.status_id')
                ->join('clients', 'clients.CST_ID', '=', 'services.customer_id')
                ->select([
                    'service_history.id as notification_id',
                    'service_history.action_description as title',
                    'service_history.created_at as timestamp',
                    'services.service_no',
                    'clients.CST_Name as customer_name',
                    'master_service_status.Status_Name as status',
                    'service_history.status_id',
                    DB::raw('CASE 
                        WHEN service_history.status_id = 6 THEN "service_assignment"
                        WHEN service_history.status_id IN (2,3,4,5) THEN "status_update"
                        ELSE "info"
                    END as type'),
                    DB::raw('0 as isRead')
                ])
                ->orderBy('service_history.created_at', 'desc')
                ->limit(50)
                ->get();

            // Format notifications
            $formattedNotifications = $notifications->map(function ($notification) {
                return [
                    'id' => $notification->notification_id,
                    'title' => $this->formatNotificationTitle($notification),
                    'message' => $this->formatNotificationMessage($notification),
                    'timestamp' => $notification->timestamp,
                    'type' => $notification->type,
                    'isRead' => (bool) $notification->isRead,
                    'service_no' => $notification->service_no,
                    'customer_name' => $notification->customer_name,
                    'status' => $notification->status,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Notifications retrieved successfully',
                'notifications' => $formattedNotifications,
                'count' => $formattedNotifications->count()
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving notifications: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get notification count for a user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotificationCount(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer|exists:users,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ]);
            }

            $userId = $request->user_id;

            // Count recent unread notifications (last 7 days)
            $count = ServiceHistory::where('user_id', $userId)
                ->where('created_at', '>=', now()->subDays(7))
                ->count();

            return response()->json([
                'success' => true,
                'message' => 'Notification count retrieved successfully',
                'count' => $count
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving notification count: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Mark notification as read
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markNotificationAsRead(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'notification_id' => 'required|integer|exists:service_history,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ]);
            }

            // In a real implementation, you would have a notifications table
            // For now, we'll just return success
            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error marking notification as read: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Mark all notifications as read for a user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAllNotificationsAsRead(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer|exists:users,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ]);
            }

            // In a real implementation, you would update a notifications table
            // For now, we'll just return success
            return response()->json([
                'success' => true,
                'message' => 'All notifications marked as read'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error marking notifications as read: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Format notification title
     *
     * @param object $notification
     * @return string
     */
    private function formatNotificationTitle($notification)
    {
        switch ($notification->status_id) {
            case 6:
                return 'New Service Assigned';
            case 2:
                return 'Service Status Updated - Open';
            case 3:
                return 'Service Status Updated - Pending';
            case 4:
                return 'Service Status Updated - Resolved';
            case 5:
                return 'Service Status Updated - Closed';
            default:
                return 'Service Update';
        }
    }

    /**
     * Format notification message
     *
     * @param object $notification
     * @return string
     */
    private function formatNotificationMessage($notification)
    {
        $serviceNo = $notification->service_no;
        $customerName = $notification->customer_name;
        $status = $notification->status;

        switch ($notification->status_id) {
            case 6:
                return "Service #{$serviceNo} has been assigned to you for {$customerName}";
            case 2:
                return "Service #{$serviceNo} status changed to Open for {$customerName}";
            case 3:
                return "Service #{$serviceNo} status changed to Pending for {$customerName}";
            case 4:
                return "Service #{$serviceNo} has been resolved for {$customerName}";
            case 5:
                return "Service #{$serviceNo} has been closed for {$customerName}";
            default:
                return "Service #{$serviceNo} status updated to {$status} for {$customerName}";
        }
    }
} 