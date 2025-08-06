# Push Notification Implementation Guide

## Overview
This document describes the implementation of push notifications in the AMC Laravel application. The system sends push notifications to users' mobile devices when services are assigned or status changes occur.

## Features Implemented

### 1. PushNotificationService Class
**Location**: `app/Services/PushNotificationService.php`

This service class provides the following methods:

#### Core Methods:
- `sendPushNotification($userId, $title, $message, $data = [])` - Sends a basic push notification
- `sendServiceAssignmentNotification($userId, $serviceNo, $customerName, $serviceDate)` - Sends service assignment notifications
- `sendServiceStatusUpdateNotification($userId, $serviceNo, $status)` - Sends status update notifications
- `sendUrgentServiceNotification($userId, $serviceNo, $priority)` - Sends urgent service alerts

#### Utility Methods:
- `isValidFcmToken($token)` - Validates FCM token format
- `getUsersWithValidTokens($userIds)` - Retrieves users with valid FCM tokens

### 2. Enhanced SendPushNotification Class
**Location**: `app/Notifications/SendPushNotification.php`

Updated to support:
- Additional data payload
- Better error handling
- Improved Android/iOS configuration
- Custom notification colors

### 3. Integration Points

#### Service Assignment Notifications
**Triggered in**:
- `ServiceController::AssignEngineer()` - When manually assigning engineers
- `ServiceController::AddServiceCallManage()` - When creating services with engineer assignment

#### Status Update Notifications
**Triggered in**:
- `AppUserController::ApplyServiceAction()` - When engineers update service status

## Database Requirements

### Users Table
The `users` table must have the following field:
```sql
fcm_token VARCHAR(255) NULL
```

### Current Implementation
The User model already includes:
- `fcm_token` in fillable fields
- `routeNotificationForFcm()` method for FCM token retrieval
- FCM token hidden from JSON responses

## API Endpoints

### Test Endpoint
```
POST /api/v1/test-push-notification
```

**Parameters**:
- `user_id` (required): User ID to send notification to
- `title` (required): Notification title
- `message` (required): Notification message

**Response**:
```json
{
    "success": true,
    "message": "Push notification sent successfully"
}
```

## Configuration Requirements

### Firebase Configuration
Ensure the following is configured in your Laravel application:

1. **Firebase Service Account Key**
   - Place the Firebase service account JSON file in `storage/app/firebase/`
   - Update `.env` file with Firebase configuration

2. **Environment Variables**
   ```env
   FIREBASE_CREDENTIALS=storage/app/firebase/service-account.json
   FIREBASE_PROJECT_ID=your-project-id
   ```

3. **FCM Package**
   ```bash
   composer require laravel-notification-channels/fcm
   ```

## Usage Examples

### 1. Sending Service Assignment Notification
```php
$pushNotificationService = new PushNotificationService();
$pushNotificationService->sendServiceAssignmentNotification(
    $engineerId,
    'SRV-2024-001',
    'ABC Company',
    '2024-01-15'
);
```

### 2. Sending Status Update Notification
```php
$pushNotificationService = new PushNotificationService();
$pushNotificationService->sendServiceStatusUpdateNotification(
    $engineerId,
    'SRV-2024-001',
    'In Progress'
);
```

### 3. Sending Custom Notification
```php
$pushNotificationService = new PushNotificationService();
$pushNotificationService->sendPushNotification(
    $userId,
    'Custom Title',
    'Custom message content',
    ['type' => 'custom', 'data' => 'additional info']
);
```

## Error Handling

### Logging
All push notification activities are logged:
- **Info**: Successful notifications
- **Warning**: User not found or missing FCM token
- **Error**: FCM sending failures

### Graceful Degradation
- If FCM token is invalid or missing, notification is skipped
- If FCM service is unavailable, error is logged but application continues
- No exceptions are thrown to prevent service disruption

## Testing

### 1. Test Push Notification
```bash
curl -X POST http://your-domain/api/v1/test-push-notification \
  -H "Content-Type: application/json" \
  -d '{
    "user_id": 1,
    "title": "Test Notification",
    "message": "This is a test push notification"
  }'
```

### 2. Verify FCM Token
```php
$pushNotificationService = new PushNotificationService();
$isValid = $pushNotificationService->isValidFcmToken($user->fcm_token);
```

## Mobile App Integration

### FCM Token Update
The mobile app should call the existing endpoint to update FCM tokens:
```
POST /api/v1/fcmtokenApp
```

### Notification Handling
The mobile app should handle the following notification types:
- `service_assignment` - New service assigned
- `status_update` - Service status changed
- `urgent_service` - High priority service
- `test` - Test notifications

## Security Considerations

1. **Token Validation**: FCM tokens are validated before sending
2. **User Verification**: Only valid user IDs are accepted
3. **Rate Limiting**: API endpoints are rate-limited
4. **Error Logging**: Sensitive information is not logged

## Troubleshooting

### Common Issues

1. **Notification Not Received**
   - Check if user has valid FCM token
   - Verify Firebase configuration
   - Check application logs for errors

2. **FCM Token Issues**
   - Ensure mobile app updates FCM token on login
   - Validate token format using `isValidFcmToken()`

3. **Firebase Configuration**
   - Verify service account JSON file
   - Check project ID in environment variables
   - Ensure Firebase project has FCM enabled

### Debug Commands
```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Test FCM configuration
php artisan tinker
>>> $service = new App\Services\PushNotificationService();
>>> $service->isValidFcmToken('test-token');
```

## Future Enhancements

1. **Notification Templates**: Predefined notification templates
2. **Bulk Notifications**: Send to multiple users simultaneously
3. **Notification History**: Track sent notifications
4. **Customization**: User notification preferences
5. **Analytics**: Notification delivery and engagement metrics

## Support

For issues or questions regarding push notifications:
1. Check application logs first
2. Verify Firebase configuration
3. Test with the provided test endpoint
4. Review this documentation

---

**Last Updated**: January 2024
**Version**: 1.0 