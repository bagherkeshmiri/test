<?php

namespace App\Services\Sms\Kavenegar;


use App\Services\Sms\SmsClientInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;


class KavenegarSmsClient implements SmsClientInterface
{
    public function __construct(
        protected string $apiKey,
        protected string $sender
    ) {
    }


    /**
     * @throws ConnectionException
     */
    public function send(string $to, string $message): void
    {
        $response = Http::asForm()->post('https://api.kavenegar.com/v1/' . $this->apiKey . '/sms/send.json', [
            'receptor' => $to,
            'sender' => $this->sender,
            'message' => $message,
        ]);


        if (!$response->ok()) {
            throw new RuntimeException('SMS failed: ' . $response->body());
        }
    }
}
