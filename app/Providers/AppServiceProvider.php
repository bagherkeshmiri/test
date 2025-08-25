<?php

namespace App\Providers;

use App\Notifications\Channels\Sms\SmsChannel;
use App\Services\Sms\Kavenegar\KavenegarSmsClient;
use App\Services\Sms\SmsClientInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\ServiceProvider;
use RuntimeException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SmsClientInterface::class, function ($app) {

            $cfg = $app['config']['services.sms'] ?? [];

            if (!isset($cfg['kavenegar']['key'], $cfg['kavenegar']['sender'])) {
                throw new RuntimeException('Kavenegar SMS config not set properly.');
            }

            return new KavenegarSmsClient(
                apiKey: $cfg['kavenegar']['key'],
                sender: $cfg['kavenegar']['sender']
            );
        });
    }

    /**
     * Bootstrap any application services.
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        $this->app->make(ChannelManager::class)->extend('sms', function ($app) {
            $client = $app->make(SmsClientInterface::class);
            return new SmsChannel($client);
        });
    }
}
