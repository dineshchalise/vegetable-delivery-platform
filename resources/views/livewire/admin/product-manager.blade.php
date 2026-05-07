<div>
    <h1 class="mb-6 text-2xl font-semibold">Products</h1>
    <div class="mb-4 flex gap-2">
        <button wire:click="$set('tab', 'grid')" class="rounded border px-3 py-2">Grid</button>
        <button wire:click="$set('tab', 'prices')" class="rounded border px-3 py-2">Bulk Prices</button>
    </div>
    @if($tab === 'prices')
        <livewire:admin.bulk-price-update />
    @else
        <div class="grid gap-4 md:grid-cols-3">
            @foreach($products as $product)
                <article class="rounded bg-white p-4 shadow">
                    <h2 class="font-medium">{{ $product->name }}</h2>
                    <p class="text-sm text-slate-600">{{ $product->category->name }} · Rs {{ $product->price }}</p>
                    <p class="text-sm">Stock: {{ $product->stock_quantity }} {{ $product->unit }}</p>
                </article>
            @endforeach
        </div>
        <div class="mt-6">{{ $products->links() }}</div>
    @endif
</div>
