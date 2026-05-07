<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OtpService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private OtpService $otps)
    {
    }

    public function sendOtp(Request $request)
    {
        $data = $request->validate(['mobile' => ['required', 'digits:10']]);
        $this->otps->send($data['mobile']);

        return response()->json(['message' => 'OTP sent.']);
    }

    public function verifyOtp(Request $request)
    {
        $data = $request->validate([
            'mobile' => ['required', 'digits:10'],
            'otp' => ['required', 'digits:6'],
        ]);

        $customer = $this->otps->verify($data['mobile'], $data['otp']);

        return response()->json([
            'token' => $customer->createToken('customer')->plainTextToken,
            'customer' => $customer,
        ]);
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['message' => 'Logged out.']);
    }
}
