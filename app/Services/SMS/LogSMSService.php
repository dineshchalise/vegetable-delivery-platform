<?php

namespace App\Services\SMS;

use App\Models\SmsLog;

class LogSMSService implements SMSServiceInterface
{
    public function send(string $mobile, string $message): void
    {
        SmsLog::create([
            'mobile' => $mobile,
            'message' => $message,
            'driver' => 'log',
            'sent' => true,
        ]);
    }
}
