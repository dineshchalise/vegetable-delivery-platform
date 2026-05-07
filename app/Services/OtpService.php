<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Otp;
use App\Services\SMS\SMSServiceInterface;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class OtpService
{
    public function __construct(private SMSServiceInterface $sms)
    {
    }

    public function send(string $mobile): void
    {
        $customer = Customer::firstOrCreate(['mobile' => $mobile]);

        if ($customer->is_blocked) {
            throw ValidationException::withMessages(['mobile' => 'This customer has been blocked.']);
        }

        $code = (string) random_int(100000, 999999);

        Otp::create([
            'mobile' => $mobile,
            'otp_code' => $code,
            'expires_at' => now()->addMinutes(5),
            'is_used' => false,
            'created_at' => now(),
        ]);

        $this->sms->send($mobile, "Your vegetable delivery OTP is {$code}. It expires in 5 minutes.");
    }

    public function verify(string $mobile, string $code): Customer
    {
        $otp = Otp::query()
            ->where('mobile', $mobile)
            ->where('otp_code', $code)
            ->where('is_used', false)
            ->latest('created_at')
            ->first();

        if (! $otp || Carbon::parse($otp->expires_at)->isPast()) {
            throw ValidationException::withMessages(['otp' => 'Invalid or expired OTP.']);
        }

        $otp->update(['is_used' => true]);

        return Customer::where('mobile', $mobile)->firstOrFail();
    }
}
