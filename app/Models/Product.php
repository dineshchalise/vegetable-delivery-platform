<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'slug', 'category_id', 'price', 'unit', 'stock_quantity', 'image_url', 'is_published'];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'decimal:2',
        'is_published' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
