<div class="mx-auto max-w-3xl px-4 py-8" x-init="$wire.set('items', cart.map((item) => ({ product_id: item.id, quantity: item.quantity || 1 })))">
    @if($step === 5)
        <div class="rounded bg-white p-6 shadow">
            <h1 class="text-2xl font-semibold">Order placed</h1>
            <p class="mt-2">Your order number is <strong>{{ $orderNumber }}</strong>.</p>
        </div>
    @else
        <div class="rounded bg-white p-6 shadow">
            <h1 class="mb-6 text-2xl font-semibold">Checkout</h1>
            @if($step === 1)
                <div class="grid gap-4">
                    <input wire:model="name" class="rounded border p-3" placeholder="Name">
                    <input wire:model="mobile" class="rounded border p-3" placeholder="Mobile">
                    <textarea wire:model="address" class="rounded border p-3" placeholder="Address"></textarea>
                    <button wire:click="next" class="rounded bg-emerald-600 px-4 py-3 text-white">Continue</button>
                </div>
            @elseif($step === 2)
                @if($hubs->isEmpty())
                    <div class="rounded bg-amber-50 p-4 text-amber-800">
                        No active hubs are available. Please add or activate a hub from the admin panel.
                    </div>
                @endif
                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach($hubs as $hub)
                        <button wire:click="$set('hub_id', {{ $hub->id }})" class="rounded border p-4 text-left {{ $hub_id === $hub->id ? 'border-emerald-600' : '' }}">
                            <strong>{{ $hub->name }}</strong>
                            <p class="text-sm">{{ $hub->address }}</p>
                            <p class="text-sm">{{ $hub->pickup_timings }}</p>
                        </button>
                    @endforeach
                </div>
                <button wire:click="next" class="mt-4 rounded bg-emerald-600 px-4 py-3 text-white">Continue</button>
            @elseif($step === 3)
                <label class="flex items-center gap-3"><input type="radio" checked disabled> Cash on delivery</label>
                <p class="mt-2 text-sm text-slate-600">Online payment coming soon.</p>
                <button wire:click="next" class="mt-4 rounded bg-emerald-600 px-4 py-3 text-white">Continue</button>
            @else
                <p class="mb-4">Review your order and place it.</p>
                @if(empty($items))
                    <div class="mb-4 rounded bg-amber-50 p-4 text-amber-800">
                        Your cart is empty. Please return to the homepage and add products.
                    </div>
                @endif
                <button type="button" @click="$wire.set('items', cart.map((item) => ({ product_id: item.id, quantity: item.quantity || 1 }))).then(() => $wire.placeOrder())" class="rounded bg-emerald-600 px-4 py-3 text-white">Place Order</button>
            @endif
        </div>
    @endif
</div>
