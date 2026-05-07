<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hub extends Model
{
    protected $fillable = ['name', 'photo_url', 'address', 'contact_number', 'pickup_timings', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
