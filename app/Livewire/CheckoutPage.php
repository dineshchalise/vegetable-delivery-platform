<?php

namespace App\Livewire;

use App\Models\Hub;
use App\Services\OrderService;
use Livewire\Component;

class CheckoutPage extends Component
{
    public int $step = 1;
    public string $name = '';
    public string $mobile = '';
    public string $address = '';
    public ?int $hub_id = null;
    public array $items = [];
    public ?string $orderNumber = null;

    public function next(): void
    {
        $rules = $this->rulesForStep();

        if ($rules !== []) {
            $this->validate($rules);
        }

        $this->step = $this->step === 1 ? 3 : $this->step + 1;
    }

    public function placeOrder(OrderService $orders): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:120'],
            'mobile' => ['required', 'digits:10'],
            'address' => ['required', 'string'],
            'hub_id' => ['required', 'exists:hubs,id'],
            'items' => ['required', 'array', 'min:1'],
        ]);

        $order = $orders->createGuestOrder([
            'name' => $this->name,
            'mobile' => $this->mobile,
            'address' => $this->address,
            'hub_id' => $this->hub_id,
            'items' => $this->items,
        ]);

        $this->orderNumber = $order->order_number;
        $this->step = 5;
    }

    public function render()
    {
        return view('livewire.checkout-page', [
            'hubs' => Hub::where('is_active', true)->get(),
        ])->layout('components.layouts.app');
    }

    private function rulesForStep(): array
    {
        return match ($this->step) {
            1 => [
                'name' => ['required'],
                'mobile' => ['required', 'digits:10'],
                'address' => ['required'],
                'hub_id' => ['required', 'exists:hubs,id'],
            ],
            2 => ['hub_id' => ['required', 'exists:hubs,id']],
            default => [],
        };
    }
}
