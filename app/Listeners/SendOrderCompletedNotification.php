<?php

namespace App\Listeners;

use App\Events\OrderCompletedEvent;
use App\Notifications\Orders\OrderCompleted;

class SendOrderCompletedNotification
{
    public function handle(OrderCompletedEvent $event): void
    {
        $event->user->notify(new OrderCompleted($event->data));
    }
}
