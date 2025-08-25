<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            // preferred default channel: sms|database|push (broadcast)
            $table->string('default_channel')->nullable()->comment(' sms | database | push ');
            // enable/disable per event key, e.g. orders.placed, orders.completed, orders.cancelled
            $table->json('channels_per_event')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_preferences');
    }
};
