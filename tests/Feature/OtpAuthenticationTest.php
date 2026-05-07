<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Otp;
use App\Models\SmsLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OtpAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_request_and_verify_otp(): void
    {
        $this->postJson('/api/auth/send-otp', ['mobile' => '9812345678'])
            ->assertOk();

        $this->assertDatabaseHas('customers', ['mobile' => '9812345678']);
        $this->assertDatabaseCount('sms_logs', 1);

        $otp = Otp::where('mobile', '9812345678')->firstOrFail();

        $this->postJson('/api/auth/verify-otp', [
            'mobile' => '9812345678',
            'otp' => $otp->otp_code,
        ])->assertOk()
            ->assertJsonStructure(['token', 'customer']);

        $this->assertTrue($otp->refresh()->is_used);
    }

    public function test_blocked_customer_cannot_request_otp(): void
    {
        Customer::create(['mobile' => '9812345678', 'is_blocked' => true]);

        $this->postJson('/api/auth/send-otp', ['mobile' => '9812345678'])
            ->assertStatus(422);

        $this->assertDatabaseCount('sms_logs', 0);
    }
}
