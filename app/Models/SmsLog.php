<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $fillable = ['mobile', 'message', 'driver', 'sent', 'error'];

    protected $casts = ['sent' => 'boolean'];
}
