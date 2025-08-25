<?php

namespace App\Listeners;

use App\Events\OrderCancelledEvent;
use App\Notifications\Orders\OrderCancelled;

class SendOrderCancelledNotification
{
    public function handle(OrderCancelledEvent $event): void
    {
        $event->user->notify(new OrderCancelled($event->data));
    }
}
