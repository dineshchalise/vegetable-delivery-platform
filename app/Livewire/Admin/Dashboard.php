<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\Product;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'todayOrders' => Order::whereDate('created_at', today())->count(),
            'pendingPickup' => Order::whereIn('status', ['received', 'packing'])->count(),
            'pendingDelivery' => Order::where('status', 'out_for_delivery')->count(),
            'lowStock' => Product::where('stock_quantity', '<', 5)->count(),
        ])->layout('components.layouts.admin');
    }
}
