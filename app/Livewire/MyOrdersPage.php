<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MyOrdersPage extends Component
{
    use WithPagination;

    public function render()
    {
        abort_unless(Auth::check(), 403);

        return view('livewire.my-orders-page', [
            'orders' => Order::where('customer_mobile', Auth::user()->mobile)->latest()->paginate(10),
        ])->layout('components.layouts.app');
    }
}
