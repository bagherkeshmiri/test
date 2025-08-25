<?php

namespace App\Services\Sms;

interface SmsClientInterface
{
    public function send(string $to, string $message): void;
}
