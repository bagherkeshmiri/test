<?php

use App\Models\User;
use App\Notifications\Orders\OrderPlaced;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test-store-order', function () {

    $user = User::query()->first();

    $orderData = [
        'user_id' => $user->id,
        'order_number' => 'ORD-12345'
    ];

//    $user->notify(new OrderPlaced($orderData));
    // Or
//    $user->notify(new OrderPlaced($orderData, preferred: 'database'));
//    $user->notify(new OrderPlaced($orderData, preferred: 'push'));
    $user->notify(new OrderPlaced($orderData, preferred: 'sms'));
});
