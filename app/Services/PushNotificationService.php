<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\SendPushNotification;
use Illuminate\Support\Facades\Log;
use Exception;

class PushNotificationService
{
    /**
     * Send push notification to a specific user
     *
     * @param int $userId
     * @param string $title
     * @param string $message
     * @param array $data Additional data to send with notification
     * @return bool
     */
    public function sendPushNotification($userId, $title, $message, $data = [])
    {
        try {
            // Get user with FCM token
            $user = User::where('id', $userId)
                       ->whereNotNull('fcm_token')
                       ->where('fcm_token', '!=', '')
                       ->first();

            if (!$user) {
                Log::warning("Push notification failed: User {$userId} not found or has no FCM token");
                return false;
            }

            // Send notification
            $user->notify(new SendPushNotification($title, $message, $data));
            
            Log::info("Push notification sent successfully to user {$userId}: {$title} - {$message}");
            return true;

        } catch (Exception $e) {
            Log::error("Push notification failed for user {$userId}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send service assignment notification
     *
     * @param int $userId
     * @param string $serviceNo
     * @param string $customerName
     * @param string $serviceDate
     * @return bool
     */
    public function sendServiceAssignmentNotification($userId, $serviceNo, $customerName, $serviceDate)
    {
        $title = "New Service Assigned";
        $message = "Service #{$serviceNo} has been assigned to you for {$customerName} on {$serviceDate}";
        
        $data = [
            'type' => 'service_assignment',
            'service_no' => $serviceNo,
            'customer_name' => $customerName,
            'service_date' => $serviceDate,
            'timestamp' => now()->toISOString()
        ];

        return $this->sendPushNotification($userId, $title, $message, $data);
    }

    /**
     * Send service status update notification
     *
     * @param int $userId
     * @param string $serviceNo
     * @param string $status
     * @return bool
     */
    public function sendServiceStatusUpdateNotification($userId, $serviceNo, $status)
    {
        $title = "Service Status Updated";
        $message = "Service #{$serviceNo} status has been updated to: {$status}";
        
        $data = [
            'type' => 'status_update',
            'service_no' => $serviceNo,
            'status' => $status,
            'timestamp' => now()->toISOString()
        ];

        return $this->sendPushNotification($userId, $title, $message, $data);
    }

    /**
     * Send urgent service notification
     *
     * @param int $userId
     * @param string $serviceNo
     * @param string $priority
     * @return bool
     */
    public function sendUrgentServiceNotification($userId, $serviceNo, $priority)
    {
        $title = "🚨 Urgent Service Alert";
        $message = "High priority service #{$serviceNo} requires immediate attention";
        
        $data = [
            'type' => 'urgent_service',
            'service_no' => $serviceNo,
            'priority' => $priority,
            'timestamp' => now()->toISOString()
        ];

        return $this->sendPushNotification($userId, $title, $message, $data);
    }

    /**
     * Validate FCM token format
     *
     * @param string $token
     * @return bool
     */
    public function isValidFcmToken($token)
    {
        if (empty($token)) {
            return false;
        }

        // Basic FCM token validation (starts with specific patterns)
        $validPatterns = [
            '/^[a-zA-Z0-9:_-]{140,}$/', // Standard FCM token pattern
        ];

        foreach ($validPatterns as $pattern) {
            if (preg_match($pattern, $token)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get users with valid FCM tokens
     *
     * @param array $userIds
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsersWithValidTokens($userIds)
    {
        return User::whereIn('id', $userIds)
                   ->whereNotNull('fcm_token')
                   ->where('fcm_token', '!=', '')
                   ->get();
    }
} 