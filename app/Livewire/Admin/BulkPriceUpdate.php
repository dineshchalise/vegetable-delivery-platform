<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BulkPriceUpdate extends Component
{
    public array $prices = [];

    public function mount(): void
    {
        $this->prices = Product::pluck('price', 'id')->map(fn ($price) => (string) $price)->all();
    }

    public function save(): void
    {
        $this->validate(['prices.*' => ['required', 'numeric', 'min:0']]);

        DB::transaction(function () {
            foreach ($this->prices as $id => $price) {
                Product::whereKey($id)->update(['price' => $price]);
            }
        });

        session()->flash('status', 'Prices updated.');
    }

    public function render()
    {
        return view('livewire.admin.bulk-price-update', [
            'products' => Product::with('category')->orderBy('name')->get(),
        ]);
    }
}
