<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Hub;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_checkout_creates_customer_order_items_and_sms_log(): void
    {
        $category = Category::create(['name' => 'Roots', 'slug' => 'roots', 'display_order' => 1, 'is_active' => true]);
        $hub = Hub::create([
            'name' => 'Koteshwor Hub',
            'address' => 'Koteshwor',
            'contact_number' => '9800000000',
            'pickup_timings' => '8 AM - 7 PM',
            'is_active' => true,
        ]);
        $product = Product::create([
            'name' => 'Potato',
            'slug' => 'potato',
            'category_id' => $category->id,
            'price' => 50,
            'unit' => 'kg',
            'stock_quantity' => 10,
            'is_published' => true,
        ]);

        $this->postJson('/api/orders', [
            'name' => 'Sita Sharma',
            'mobile' => '9812345678',
            'address' => 'Koteshwor',
            'hub_id' => $hub->id,
            'items' => [['product_id' => $product->id, 'quantity' => 2]],
        ])->assertCreated()
            ->assertJsonPath('customer_mobile', '9812345678')
            ->assertJsonPath('total_amount', '100.00');

        $this->assertDatabaseHas('customers', ['mobile' => '9812345678', 'name' => 'Sita Sharma']);
        $this->assertDatabaseHas('order_items', ['product_name' => 'Potato', 'quantity' => 2]);
        $this->assertDatabaseHas('sms_logs', ['mobile' => '9812345678']);
        $this->assertEquals('8.00', $product->refresh()->stock_quantity);
    }
}
