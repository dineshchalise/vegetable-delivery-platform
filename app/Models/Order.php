<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const FLOW = ['received', 'packing', 'ready_at_hub', 'out_for_delivery', 'completed'];

    protected $fillable = [
        'order_number', 'customer_mobile', 'customer_name', 'customer_address', 'hub_id',
        'status', 'payment_method', 'payment_status', 'subtotal', 'delivery_fee', 'total_amount',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function hub()
    {
        return $this->belongsTo(Hub::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
