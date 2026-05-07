<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = ['mobile', 'name', 'address', 'is_blocked'];

    protected $casts = [
        'is_blocked' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_mobile', 'mobile');
    }
}
