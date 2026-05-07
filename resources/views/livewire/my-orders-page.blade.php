<div class="mx-auto max-w-4xl px-4 py-8">
    <h1 class="mb-6 text-2xl font-semibold">My Orders</h1>
    <div class="grid gap-4">
        @foreach($orders as $order)
            <a href="{{ route('orders.show', $order->order_number) }}" class="rounded border bg-white p-4">
                <div class="flex items-center justify-between">
                    <strong>{{ $order->order_number }}</strong>
                    <span class="rounded bg-slate-100 px-2 py-1 text-sm">{{ str_replace('_', ' ', $order->status) }}</span>
                </div>
                <p class="mt-2 text-sm text-slate-600">Rs {{ $order->total_amount }}</p>
            </a>
        @endforeach
    </div>
    <div class="mt-6">{{ $orders->links() }}</div>
</div>
