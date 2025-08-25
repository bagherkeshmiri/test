<?php
namespace App\Notifications\Channels\Sms;


use App\Services\Sms\SmsClientInterface;
use Illuminate\Notifications\Notification;


class SmsChannel
{
    public function __construct(protected SmsClientInterface $client) {}


    public function send($notifiable, Notification $notification): void
    {
        if (!method_exists($notification, 'toSms')) {
            return;
        }


        $message = $notification->toSms($notifiable);
        if (!$message instanceof SmsMessage) {
            return;
        }


        $phone = $notifiable->phone_number ?? null;
        if (!$phone) return;


        $this->client->send($phone, $message->content);
    }
}
