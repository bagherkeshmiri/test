<?php

namespace App\Notifications\Orders;

use App\Notifications\BaseFlexibleNotification;
use App\Notifications\Channels\Sms\SmsMessage;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Notifications\Messages\BroadcastMessage;

class OrderCancelled extends BaseFlexibleNotification
{
    public function __construct(protected array $data, ?string $preferred = null)
    {
        parent::__construct($preferred);
    }

    protected function supportedChannels(): array
    {
        return ['sms', 'database', 'push'];
    }

    protected function eventKey(): string
    {
        return 'orders.cancelled';
    }

    public function toDatabase($notifiable): array
    {
        app()->setLocale($this->localeFor($notifiable));
        return [
            'title' => trans('notifications.orders.cancelled.title'),
            'body' => trans('notifications.orders.cancelled.body', [
                'order' => $this->data['order_number'] ?? ''
            ]),
            'data' => $this->data,
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        app()->setLocale($this->localeFor($notifiable));
        return new BroadcastMessage([
            'title' => trans('notifications.orders.cancelled.title'),
            'body' => trans('notifications.orders.cancelled.body', [
                'order' => $this->data['order_number'] ?? ''
            ]),
            'data' => $this->data,
        ]);
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('App.Models.User.' . $this->data['user_id'])];
    }

    public function toSms($notifiable): SmsMessage
    {
        app()->setLocale($this->localeFor($notifiable));
        $text = trans('notifications.orders.cancelled.sms', [
            'order' => $this->data['order_number'] ?? ''
        ]);
        return new SmsMessage($text);
    }
}
