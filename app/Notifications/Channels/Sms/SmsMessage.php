<?php

namespace App\Notifications\Channels\Sms;

class SmsMessage
{
    public function __construct(
        public string $content
    ) {
    }
}
