<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    public $timestamps = false;

    protected $fillable = ['mobile', 'otp_code', 'expires_at', 'is_used', 'created_at'];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean',
        'created_at' => 'datetime',
    ];
}
