<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\OrderPlacedEvent;
use App\Events\OrderCompletedEvent;
use App\Events\OrderCancelledEvent;
use App\Listeners\SendOrderPlacedNotification;
use App\Listeners\SendOrderCompletedNotification;
use App\Listeners\SendOrderCancelledNotification;


class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderPlacedEvent::class => [SendOrderPlacedNotification::class],
        OrderCompletedEvent::class => [SendOrderCompletedNotification::class],
        OrderCancelledEvent::class => [SendOrderCancelledNotification::class],
    ];
}
