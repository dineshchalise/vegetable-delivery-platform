<?php

namespace App\Livewire\Admin;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $blocked = '';

    public function toggle(Customer $customer): void
    {
        $customer->update(['is_blocked' => ! $customer->is_blocked]);
    }

    public function render()
    {
        return view('livewire.admin.customer-manager', [
            'customers' => Customer::query()
                ->when($this->search, fn ($q) => $q->where('mobile', 'like', "%{$this->search}%")->orWhere('name', 'like', "%{$this->search}%"))
                ->when($this->blocked !== '', fn ($q) => $q->where('is_blocked', (bool) $this->blocked))
                ->latest()
                ->paginate(20),
        ])->layout('components.layouts.admin');
    }
}
