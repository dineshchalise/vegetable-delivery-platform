<div class="mx-auto max-w-md px-4 py-10">
    <div class="rounded bg-white p-6 shadow">
        <h1 class="mb-4 text-2xl font-semibold">Login with OTP</h1>
        @if(! $sent)
            <input wire:model="mobile" class="w-full rounded border p-3" placeholder="10 digit mobile">
            <button wire:click="send" class="mt-4 w-full rounded bg-emerald-600 px-4 py-3 text-white">Send OTP</button>
        @else
            <input wire:model="otp" maxlength="6" class="w-full rounded border p-3 tracking-[0.5em]" placeholder="000000">
            <button wire:click="verify" class="mt-4 w-full rounded bg-emerald-600 px-4 py-3 text-white">Verify</button>
        @endif
    </div>
</div>
