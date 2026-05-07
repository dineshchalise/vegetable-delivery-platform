<div class="mx-auto max-w-4xl px-4 py-8" wire:poll.30s="refreshOrder">
    <h1 class="text-2xl font-semibold">Order {{ $order->order_number }}</h1>
    <div class="mt-6 grid gap-3 sm:grid-cols-5">
        @foreach($flow as $status)
            <div class="rounded border p-3 {{ array_search($status, $flow, true) <= array_search($order->status, $flow, true) ? 'border-emerald-600 bg-emerald-50' : 'bg-white' }}">
                {{ str_replace('_', ' ', $status) }}
            </div>
        @endforeach
    </div>
    <section class="mt-6 rounded bg-white p-4 shadow">
        <h2 class="font-semibold">{{ $order->hub->name }}</h2>
        <p class="text-sm">{{ $order->hub->address }}</p>
        <p class="text-sm">{{ $order->hub->contact_number }}</p>
    </section>
    <section class="mt-6 rounded bg-white p-4 shadow">
        <h2 class="mb-3 font-semibold">Items</h2>
        @foreach($order->items as $item)
            <div class="flex justify-between border-b py-2">
                <span>{{ $item->product_name }} x {{ $item->quantity }}</span>
                <span>Rs {{ $item->subtotal }}</span>
            </div>
        @endforeach
    </section>
</div>
