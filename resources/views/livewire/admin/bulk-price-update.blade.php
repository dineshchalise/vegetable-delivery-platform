<div class="rounded bg-white p-4 shadow">
    @if(session('status')) <div class="mb-3 rounded bg-emerald-50 p-3 text-emerald-700">{{ session('status') }}</div> @endif
    <table class="w-full text-left text-sm">
        <thead><tr><th class="py-2">Product</th><th>Category</th><th>Price</th></tr></thead>
        <tbody>
            @foreach($products as $product)
                <tr class="border-t">
                    <td class="py-2">{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td><input wire:model.debounce.400ms="prices.{{ $product->id }}" class="w-28 rounded border p-2"></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <button wire:click="save" class="mt-4 rounded bg-emerald-600 px-4 py-3 text-white">Save All Changes</button>
</div>
