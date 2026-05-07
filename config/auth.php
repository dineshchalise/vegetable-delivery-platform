<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'staff',
    ],
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'customers',
        ],
        'staff' => [
            'driver' => 'session',
            'provider' => 'staff',
        ],
        'sanctum' => [
            'driver' => 'sanctum',
            'provider' => 'customers',
        ],
    ],
    'providers' => [
        'customers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Customer::class,
        ],
        'staff' => [
            'driver' => 'eloquent',
            'model' => App\Models\Staff::class,
        ],
    ],
    'passwords' => [
        'staff' => [
            'provider' => 'staff',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],
    'password_timeout' => 10800,
];
