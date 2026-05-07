<div>
    <h1 class="mb-6 text-2xl font-semibold">Orders</h1>
    <div class="mb-4 flex gap-3">
        <select wire:model.live="status" class="rounded border p-2">
            <option value="">All statuses</option>
            @foreach($statuses as $status)<option value="{{ $status }}">{{ str_replace('_', ' ', $status) }}</option>@endforeach
        </select>
        <select wire:model.live="hubId" class="rounded border p-2">
            <option value="">All hubs</option>
            @foreach($hubs as $hub)<option value="{{ $hub->id }}">{{ $hub->name }}</option>@endforeach
        </select>
    </div>
    <div class="rounded bg-white shadow">
        @foreach($orders as $order)
            <div class="grid gap-3 border-b p-4 md:grid-cols-5">
                <strong>{{ $order->order_number }}</strong>
                <span>{{ $order->customer_name }}</span>
                <span>{{ $order->hub->name }}</span>
                <span>Rs {{ $order->total_amount }}</span>
                <select wire:change="updateStatus({{ $order->id }}, $event.target.value)" class="rounded border p-2">
                    @foreach($statuses as $status)<option value="{{ $status }}" @selected($order->status === $status)>{{ str_replace('_', ' ', $status) }}</option>@endforeach
                </select>
            </div>
        @endforeach
    </div>
    <div class="mt-6">{{ $orders->links() }}</div>
</div>
