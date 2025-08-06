<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;
Use Exception;
class SendPushNotification extends Notification
{
    use Queueable;
    protected $title;
    protected $message;
    protected $data;
    

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $message, $data = [])
    {
        $this->title = $title;
        $this->message = $message;
        $this->data = $data;
        
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toFcm($notifiable)
    {
        try{
            $fcmMessage = FcmMessage::create()
                ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                    ->setTitle($this->title)
                    ->setBody($this->message)
                )
                ->setAndroid(
                    AndroidConfig::create()
                        ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
                        ->setNotification(AndroidNotification::create()->setColor('#0288d1'))
                )->setApns(
                    ApnsConfig::create()
                        ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios'))
                );

            // Add data payload if provided
            if (!empty($this->data)) {
                $fcmMessage->setData($this->data);
            }

            return $fcmMessage;
        }catch(Exception $e){
            \Log::error('FCM notification error: ' . $e->getMessage());
            return null;
        }
      
    }
    

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'data' => $this->data,
        ];
    }
    
    public function fcmProject($notifiable, $message)
    {
        // $message is what is returned by `toFcm`
        return 'app'; // name of the firebase project to use
    }
}
