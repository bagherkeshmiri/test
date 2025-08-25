<?php

namespace App\Providers;

use App\Services\Sms\Kavenegar\KavenegarSmsClient;
use App\Services\Sms\SmsClientInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SmsClientInterface::class, function ($app) {
            $cfg = $app['config']['services.sms'];
            return new KavenegarSmsClient(
                apiKey: $cfg['kavenegar']['key'],
                sender: $cfg['kavenegar']['sender']
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
