<?php

namespace App\Providers;

use App\Services\SMS\LogSMSService;
use App\Services\SMS\SMSServiceInterface;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(SMSServiceInterface::class, LogSMSService::class);
    }

    public function boot(): void
    {
        RateLimiter::for('otp', function (Request $request) {
            return Limit::perMinutes(10, 3)->by($request->input('mobile') ?: $request->ip());
        });
    }
}
