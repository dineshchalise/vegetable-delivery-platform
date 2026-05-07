<?php

namespace App\Services\SMS;

interface SMSServiceInterface
{
    public function send(string $mobile, string $message): void;
}
