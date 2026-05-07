<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class CategoryManager extends Component
{
    public string $name = '';

    public function add(): void
    {
        $this->validate(['name' => ['required', 'string', 'max:120']]);
        Category::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'display_order' => Category::max('display_order') + 1,
            'is_active' => true,
        ]);
        $this->reset('name');
    }

    public function toggle(Category $category): void
    {
        $category->update(['is_active' => ! $category->is_active]);
    }

    public function render()
    {
        return view('livewire.admin.category-manager', [
            'categories' => Category::orderBy('display_order')->get(),
        ])->layout('components.layouts.admin');
    }
}
