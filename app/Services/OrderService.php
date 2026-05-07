<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Services\SMS\SMSServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderService
{
    public function __construct(private SMSServiceInterface $sms)
    {
    }

    public function createGuestOrder(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $customer = Customer::firstOrCreate(
                ['mobile' => $data['mobile']],
                ['name' => $data['name'], 'address' => $data['address']]
            );

            if ($customer->is_blocked) {
                throw ValidationException::withMessages(['mobile' => 'This customer cannot place orders.']);
            }

            $customer->update(['name' => $data['name'], 'address' => $data['address']]);

            $products = Product::whereIn('id', collect($data['items'])->pluck('product_id'))
                ->where('is_published', true)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $subtotal = 0;
            $items = [];

            foreach ($data['items'] as $item) {
                $product = $products[$item['product_id']] ?? null;

                if (! $product || $product->stock_quantity < $item['quantity']) {
                    throw ValidationException::withMessages(['items' => 'One or more products are unavailable.']);
                }

                $lineSubtotal = round($product->price * $item['quantity'], 2);
                $subtotal += $lineSubtotal;
                $items[] = compact('product', 'item', 'lineSubtotal');
            }

            $deliveryFee = (float) ($data['delivery_fee'] ?? 0);

            $order = Order::create([
                'order_number' => $this->nextOrderNumber(),
                'customer_mobile' => $data['mobile'],
                'customer_name' => $data['name'],
                'customer_address' => $data['address'],
                'hub_id' => $data['hub_id'],
                'status' => 'received',
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total_amount' => $subtotal + $deliveryFee,
            ]);

            foreach ($items as $line) {
                $product = $line['product'];
                $quantity = $line['item']['quantity'];
                $product->decrement('stock_quantity', $quantity);
                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'quantity' => $quantity,
                    'subtotal' => $line['lineSubtotal'],
                ]);
            }

            $this->sms->send($order->customer_mobile, "Order {$order->order_number} received. We will update you soon.");

            return $order->load('items', 'hub');
        });
    }

    public function updateStatus(Order $order, string $status): Order
    {
        $order->update(['status' => $status]);

        if ($status === 'ready_at_hub') {
            $this->sms->send($order->customer_mobile, "Order {$order->order_number} is ready at the hub.");
        }

        if ($status === 'out_for_delivery') {
            $this->sms->send($order->customer_mobile, "Order {$order->order_number} is out for delivery. Agent details coming soon.");
        }

        return $order->refresh();
    }

    private function nextOrderNumber(): string
    {
        return 'V'.now()->format('ymd').str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
    }
}
