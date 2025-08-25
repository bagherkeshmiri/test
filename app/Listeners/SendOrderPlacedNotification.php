<?php

namespace App\Listeners;

use App\Events\OrderPlacedEvent;
use App\Notifications\Orders\OrderPlaced;

class SendOrderPlacedNotification
{
    public function handle(OrderPlacedEvent $event): void
    {
        $event->user->notify(new OrderPlaced($event->data));
    }
}
