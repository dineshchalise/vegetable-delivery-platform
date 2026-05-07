<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Hub;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Staff::firstOrCreate(['email' => 'admin@veg.test'], [
            'name' => 'Demo Admin',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        Staff::firstOrCreate(['email' => 'staff@veg.test'], [
            'name' => 'Demo Staff',
            'password' => Hash::make('password123'),
            'role' => 'staff',
        ]);

        $categories = collect(['Leafy Greens', 'Root Vegetables', 'Fresh Herbs', 'Seasonal']);
        $categories->each(function ($name, $index) {
            Category::firstOrCreate(['slug' => Str::slug($name)], [
                'name' => $name,
                'display_order' => $index + 1,
                'is_active' => true,
            ]);
        });

        Hub::firstOrCreate(['name' => 'Koteshwor Hub'], [
            'address' => 'Koteshwor, Kathmandu',
            'contact_number' => '9800000001',
            'pickup_timings' => '8 AM - 7 PM',
            'is_active' => true,
        ]);

        Hub::firstOrCreate(['name' => 'Lalitpur Hub'], [
            'address' => 'Jawalakhel, Lalitpur',
            'contact_number' => '9800000002',
            'pickup_timings' => '9 AM - 6 PM',
            'is_active' => true,
        ]);

        $leafy = Category::where('slug', 'leafy-greens')->first();
        $root = Category::where('slug', 'root-vegetables')->first();

        foreach ([
            ['Spinach', $leafy->id, 80, 'bunch', 40],
            ['Coriander', $leafy->id, 25, 'bunch', 60],
            ['Potato', $root->id, 55, 'kg', 120],
            ['Carrot', $root->id, 95, 'kg', 35],
        ] as [$name, $categoryId, $price, $unit, $stock]) {
            Product::firstOrCreate(['slug' => Str::slug($name)], [
                'name' => $name,
                'category_id' => $categoryId,
                'price' => $price,
                'unit' => $unit,
                'stock_quantity' => $stock,
                'is_published' => true,
            ]);
        }

        foreach ([
            'site_name' => 'Fresh Vegetable Delivery',
            'contact_info' => '9800000000',
            'footer_text' => 'Fresh vegetables delivered daily.',
            'delivery_fee' => '0',
            'free_delivery_minimum' => '1000',
            'cod_enabled' => '1',
            'online_payment_enabled' => '0',
        ] as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
