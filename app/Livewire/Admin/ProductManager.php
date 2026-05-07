<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;

class ProductManager extends Component
{
    public string $tab = 'grid';

    public function render()
    {
        return view('livewire.admin.product-manager', [
            'products' => Product::with('category')->latest()->paginate(20),
        ])->layout('components.layouts.admin');
    }
}
