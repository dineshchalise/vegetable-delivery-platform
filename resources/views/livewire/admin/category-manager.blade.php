<div>
    <h1 class="mb-6 text-2xl font-semibold">Categories</h1>
    <div class="mb-4 flex gap-2">
        <input wire:model="name" class="rounded border p-2" placeholder="Category name">
        <button wire:click="add" class="rounded bg-emerald-600 px-4 py-2 text-white">Add</button>
    </div>
    <div class="rounded bg-white shadow">
        @foreach($categories as $category)
            <div class="flex items-center justify-between border-b p-4">
                <span>{{ $category->display_order }}. {{ $category->name }}</span>
                <button wire:click="toggle({{ $category->id }})" class="rounded border px-3 py-2">{{ $category->is_active ? 'Active' : 'Inactive' }}</button>
            </div>
        @endforeach
    </div>
</div>
