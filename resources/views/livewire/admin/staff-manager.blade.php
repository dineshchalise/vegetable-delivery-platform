<div>
    <h1 class="mb-6 text-2xl font-semibold">Staff</h1>
    <div class="mb-6 grid gap-3 rounded bg-white p-4 shadow md:grid-cols-5">
        <input wire:model="name" class="rounded border p-2" placeholder="Name">
        <input wire:model="email" class="rounded border p-2" placeholder="Email">
        <input wire:model="password" type="password" class="rounded border p-2" placeholder="Password">
        <select wire:model="role" class="rounded border p-2"><option value="staff">Staff</option><option value="admin">Admin</option></select>
        <button wire:click="add" class="rounded bg-emerald-600 px-4 py-2 text-white">Add Staff</button>
    </div>
    <div class="rounded bg-white shadow">
        @foreach($staff as $member)
            <div class="grid gap-3 border-b p-4 md:grid-cols-3">
                <span>{{ $member->name }}</span>
                <span>{{ $member->email }}</span>
                <span>{{ $member->role }}</span>
            </div>
        @endforeach
    </div>
</div>
