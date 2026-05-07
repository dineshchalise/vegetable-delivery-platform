<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function __construct(private OrderService $orders)
    {
    }

    public function index(Request $request)
    {
        return Order::with('hub')
            ->when($request->query('status'), fn ($q, $status) => $q->where('status', $status))
            ->when($request->query('hub_id'), fn ($q, $hub) => $q->where('hub_id', $hub))
            ->when($request->query('from'), fn ($q, $from) => $q->whereDate('created_at', '>=', $from))
            ->when($request->query('to'), fn ($q, $to) => $q->whereDate('created_at', '<=', $to))
            ->latest()
            ->paginate(25);
    }

    public function show(Order $order)
    {
        return $order->load('items', 'hub');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['received', 'packing', 'ready_at_hub', 'out_for_delivery', 'completed', 'cancelled'])],
        ]);

        return $this->orders->updateStatus($order, $data['status']);
    }
}
