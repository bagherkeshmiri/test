<?php

namespace App\Providers;


use App\Notifications\Channels\Sms\SmsChannel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;


class NotificationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Notification::extend('sms', function ($app) {
            return $app->make(SmsChannel::class);
        });
    }
}
