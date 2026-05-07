<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return [
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'pending_pickup' => Order::whereIn('status', ['received', 'packing'])->count(),
            'pending_delivery' => Order::where('status', 'out_for_delivery')->count(),
            'low_stock_products' => Product::where('stock_quantity', '<', 5)->count(),
            'last_7_days' => Order::query()
                ->selectRaw('DATE(created_at) as date, COUNT(*) as orders')
                ->where('created_at', '>=', now()->subDays(6)->startOfDay())
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
        ];
    }
}
