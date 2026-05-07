<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class HomePage extends Component
{
    public ?string $category = null;

    public function render()
    {
        return view('livewire.home-page', [
            'categories' => Category::where('is_active', true)->orderBy('display_order')->get(),
            'products' => Product::with('category')
                ->where('is_published', true)
                ->when($this->category, fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $this->category)))
                ->orderBy('name')
                ->get(),
        ])->layout('components.layouts.app');
    }
}
