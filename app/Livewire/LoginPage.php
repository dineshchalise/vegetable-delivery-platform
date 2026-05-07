<?php

namespace App\Livewire;

use App\Services\OtpService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginPage extends Component
{
    public string $mobile = '';
    public string $otp = '';
    public bool $sent = false;

    public function send(OtpService $otps): void
    {
        $this->validate(['mobile' => ['required', 'digits:10']]);
        $otps->send($this->mobile);
        $this->sent = true;
    }

    public function verify(OtpService $otps)
    {
        $this->validate(['otp' => ['required', 'digits:6']]);
        Auth::login($otps->verify($this->mobile, $this->otp));

        return redirect()->route('orders.index');
    }

    public function render()
    {
        return view('livewire.login-page')->layout('components.layouts.app');
    }
}
