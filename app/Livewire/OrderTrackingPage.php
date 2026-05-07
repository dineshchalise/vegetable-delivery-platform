<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\On;
use Livewire\Component;

class OrderTrackingPage extends Component
{
    public Order $order;

    public function mount(Order $order): void
    {
        $this->order = $order->load('items', 'hub');
    }

    #[On('poll')]
    public function refreshOrder(): void
    {
        $this->order->refresh()->load('items', 'hub');
    }

    public function render()
    {
        return view('livewire.order-tracking-page', [
            'flow' => Order::FLOW,
        ])->layout('components.layouts.app');
    }
}
