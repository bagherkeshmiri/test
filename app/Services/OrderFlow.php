<?php

namespace App\Services;

use App\Events\{OrderPlacedEvent, OrderCompletedEvent, OrderCancelledEvent};
use App\Models\User;

class OrderFlow
{
    public function place(User $user, array $orderData): void
    {
        event(new OrderPlacedEvent($user, [
            'user_id' => $user->id,
            'order_number' => $orderData['number']
        ]));
    }

    public function complete(User $user, array $orderData): void
    {
        event(new OrderCompletedEvent($user, [
            'user_id' => $user->id,
            'order_number' => $orderData['number']
        ]));
    }

    public function cancel(User $user, array $orderData): void
    {
        event(new OrderCancelledEvent($user, [
            'user_id' => $user->id,
            'order_number' => $orderData['number']
        ]));
    }
}
