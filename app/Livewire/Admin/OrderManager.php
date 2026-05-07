<?php

namespace App\Livewire\Admin;

use App\Models\Hub;
use App\Models\Order;
use App\Services\OrderService;
use Livewire\Component;
use Livewire\WithPagination;

class OrderManager extends Component
{
    use WithPagination;

    public string $status = '';
    public string $hubId = '';

    public function updateStatus(Order $order, string $status, OrderService $orders): void
    {
        $orders->updateStatus($order, $status);
    }

    public function render()
    {
        return view('livewire.admin.order-manager', [
            'orders' => Order::with('hub')
                ->when($this->status, fn ($q) => $q->where('status', $this->status))
                ->when($this->hubId, fn ($q) => $q->where('hub_id', $this->hubId))
                ->latest()
                ->paginate(20),
            'hubs' => Hub::where('is_active', true)->get(),
            'statuses' => ['received', 'packing', 'ready_at_hub', 'out_for_delivery', 'completed', 'cancelled'],
        ])->layout('components.layouts.admin');
    }
}
