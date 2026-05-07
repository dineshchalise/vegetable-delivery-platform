<div>
    <h1 class="mb-6 text-2xl font-semibold">Customers</h1>
    <div class="mb-4 flex gap-3">
        <input wire:model.live="search" class="rounded border p-2" placeholder="Search customers">
        <select wire:model.live="blocked" class="rounded border p-2">
            <option value="">All</option>
            <option value="0">Active</option>
            <option value="1">Blocked</option>
        </select>
        <a href="{{ url('/api/admin/customers?export=csv') }}" class="rounded border px-4 py-2">Export CSV</a>
    </div>
    <div class="rounded bg-white shadow">
        @foreach($customers as $customer)
            <div class="grid gap-3 border-b p-4 md:grid-cols-4">
                <span>{{ $customer->name ?: 'Guest customer' }}</span>
                <span>{{ $customer->mobile }}</span>
                <span>{{ $customer->address }}</span>
                <button wire:click="toggle({{ $customer->id }})" class="rounded border px-3 py-2">{{ $customer->is_blocked ? 'Unblock' : 'Block' }}</button>
            </div>
        @endforeach
    </div>
    <div class="mt-6">{{ $customers->links() }}</div>
</div>
