<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Hub;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderStatusWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_ready_and_delivery_statuses_create_sms_logs(): void
    {
        $hub = Hub::create([
            'name' => 'Hub',
            'address' => 'Kathmandu',
            'contact_number' => '9800000000',
            'pickup_timings' => '8 AM - 7 PM',
            'is_active' => true,
        ]);
        $order = Order::create([
            'order_number' => 'V123',
            'customer_mobile' => '9812345678',
            'customer_name' => 'Sita',
            'customer_address' => 'Koteshwor',
            'hub_id' => $hub->id,
            'status' => 'received',
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'subtotal' => 100,
            'delivery_fee' => 0,
            'total_amount' => 100,
        ]);

        app(OrderService::class)->updateStatus($order, 'ready_at_hub');
        app(OrderService::class)->updateStatus($order, 'out_for_delivery');

        $this->assertDatabaseCount('sms_logs', 2);
    }
}
