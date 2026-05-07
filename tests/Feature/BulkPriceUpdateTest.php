<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Staff;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BulkPriceUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_can_bulk_update_product_prices(): void
    {
        $staff = Staff::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);
        $category = Category::create(['name' => 'Roots', 'slug' => 'roots', 'display_order' => 1, 'is_active' => true]);
        $product = Product::create([
            'name' => 'Potato',
            'slug' => 'potato',
            'category_id' => $category->id,
            'price' => 50,
            'unit' => 'kg',
            'stock_quantity' => 10,
            'is_published' => true,
        ]);

        $this->actingAs($staff, 'sanctum')->postJson('/api/admin/products/bulk-price', [
            'prices' => [['product_id' => $product->id, 'price' => 65]],
        ])->assertOk();

        $this->assertEquals('65.00', $product->refresh()->price);
    }
}
