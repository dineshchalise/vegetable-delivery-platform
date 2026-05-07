<div>
    <h1 class="mb-6 text-2xl font-semibold">Dashboard</h1>
    <div class="grid gap-4 md:grid-cols-4">
        <div class="rounded bg-white p-4 shadow"><div class="text-sm">Today orders</div><strong class="text-2xl">{{ $todayOrders }}</strong></div>
        <div class="rounded bg-white p-4 shadow"><div class="text-sm">Pending pickup</div><strong class="text-2xl">{{ $pendingPickup }}</strong></div>
        <div class="rounded bg-white p-4 shadow"><div class="text-sm">Pending delivery</div><strong class="text-2xl">{{ $pendingDelivery }}</strong></div>
        <div class="rounded bg-white p-4 shadow"><div class="text-sm">Low stock</div><strong class="text-2xl">{{ $lowStock }}</strong></div>
    </div>
</div>
