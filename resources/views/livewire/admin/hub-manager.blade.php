<div>
    <h1 class="mb-6 text-2xl font-semibold">Hubs</h1>
    @if(session('status')) <div class="mb-4 rounded bg-emerald-50 p-3 text-emerald-700">{{ session('status') }}</div> @endif

    <div class="mb-6 rounded bg-white p-4 shadow">
        <h2 class="mb-4 font-semibold">{{ $editingId ? 'Edit Hub' : 'Add Hub' }}</h2>
        <div class="grid gap-3 md:grid-cols-2">
            <input wire:model="name" class="rounded border p-3" placeholder="Hub name">
            <input wire:model="contact_number" class="rounded border p-3" placeholder="Contact number">
            <input wire:model="pickup_timings" class="rounded border p-3" placeholder="Pickup timings">
            <input wire:model="photo_url" class="rounded border p-3" placeholder="Photo URL">
            <textarea wire:model="address" class="rounded border p-3 md:col-span-2" placeholder="Address"></textarea>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" wire:model="is_active">
                <span>Active</span>
            </label>
        </div>
        <div class="mt-4 flex gap-2">
            <button wire:click="save" class="rounded bg-emerald-600 px-4 py-2 text-white">{{ $editingId ? 'Update Hub' : 'Add Hub' }}</button>
            @if($editingId)
                <button wire:click="resetForm" class="rounded border px-4 py-2">Cancel</button>
            @endif
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-3">
        @foreach($hubs as $hub)
            <article class="rounded bg-white p-4 shadow">
                <h2 class="font-medium">{{ $hub->name }}</h2>
                <p class="text-sm">{{ $hub->address }}</p>
                <p class="text-sm">{{ $hub->pickup_timings }}</p>
                <div class="mt-3 flex flex-wrap gap-2">
                    <button wire:click="edit({{ $hub->id }})" class="rounded border px-3 py-2">Edit</button>
                    <button wire:click="toggle({{ $hub->id }})" class="rounded border px-3 py-2">{{ $hub->is_active ? 'Active' : 'Inactive' }}</button>
                    <button wire:click="delete({{ $hub->id }})" wire:confirm="Delete this hub?" class="rounded border border-red-200 px-3 py-2 text-red-700">Delete</button>
                </div>
            </article>
        @endforeach
    </div>
</div>
