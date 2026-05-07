<div>
    <h1 class="mb-6 text-2xl font-semibold">Hubs</h1>
    <div class="grid gap-4 md:grid-cols-3">
        @foreach($hubs as $hub)
            <article class="rounded bg-white p-4 shadow">
                <h2 class="font-medium">{{ $hub->name }}</h2>
                <p class="text-sm">{{ $hub->address }}</p>
                <p class="text-sm">{{ $hub->pickup_timings }}</p>
                <button wire:click="toggle({{ $hub->id }})" class="mt-3 rounded border px-3 py-2">{{ $hub->is_active ? 'Active' : 'Inactive' }}</button>
            </article>
        @endforeach
    </div>
</div>
