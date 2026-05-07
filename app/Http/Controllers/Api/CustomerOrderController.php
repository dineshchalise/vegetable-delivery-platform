<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    public function __construct(private OrderService $orders)
    {
    }

    public function index(Request $request)
    {
        return Order::with('items', 'hub')
            ->where('customer_mobile', $request->user()->mobile)
            ->latest()
            ->paginate(10);
    }

    public function show(Request $request, Order $order)
    {
        abort_unless($order->customer_mobile === $request->user()->mobile, 403);

        return $order->load('items', 'hub');
    }

    public function store(StoreOrderRequest $request)
    {
        return response()->json($this->orders->createGuestOrder($request->validated()), 201);
    }
}
