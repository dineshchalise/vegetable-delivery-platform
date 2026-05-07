<div class="max-w-2xl">
    <h1 class="mb-6 text-2xl font-semibold">Settings</h1>
    @if(session('status')) <div class="mb-3 rounded bg-emerald-50 p-3 text-emerald-700">{{ session('status') }}</div> @endif
    <div class="grid gap-4 rounded bg-white p-4 shadow">
        @foreach(['site_name', 'contact_info', 'footer_text', 'delivery_fee', 'free_delivery_minimum', 'cod_enabled', 'online_payment_enabled'] as $key)
            <label class="grid gap-1">
                <span class="text-sm font-medium">{{ str_replace('_', ' ', $key) }}</span>
                <input wire:model="settings.{{ $key }}" class="rounded border p-2">
            </label>
        @endforeach
        <button wire:click="save" class="rounded bg-emerald-600 px-4 py-3 text-white">Save Settings</button>
    </div>
</div>
