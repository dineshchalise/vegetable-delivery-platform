<div class="mx-auto max-w-6xl px-4 py-8">
    <section class="mb-8 rounded bg-emerald-700 p-8 text-white">
        <h1 class="text-3xl font-semibold">Fresh vegetables delivered daily</h1>
        <p class="mt-2 max-w-2xl text-emerald-50">Browse today&apos;s produce, add items to your bag, and choose a convenient hub.</p>
    </section>
    <div class="mb-6 flex gap-2 overflow-x-auto">
        <button wire:click="$set('category', null)" class="rounded border px-3 py-2">All</button>
        @foreach($categories as $category)
            <button wire:click="$set('category', '{{ $category->slug }}')" class="rounded border px-3 py-2">{{ $category->name }}</button>
        @endforeach
    </div>
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($products as $product)
            <article class="rounded border bg-white p-4">
                <div class="aspect-square rounded bg-slate-100"></div>
                <h2 class="mt-3 font-medium">{{ $product->name }}</h2>
                <p class="text-sm text-slate-600">Rs {{ $product->price }} / {{ $product->unit }}</p>
                <button type="button" class="mt-3 w-full rounded bg-emerald-600 px-3 py-2 text-white" @click="
                    const existing = cart.find((item) => item.id === {{ $product->id }});
                    if (existing) {
                        existing.quantity = Number(existing.quantity || 1) + 1;
                    } else {
                        cart.push({ id: {{ $product->id }}, name: '{{ addslashes($product->name) }}', price: '{{ $product->price }}', quantity: 1 });
                    }
                ">Add to Bag</button>
            </article>
        @endforeach
    </div>
</div>
