<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Vegetable Delivery') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-50 text-slate-900" x-data="{ cartOpen: false, cart: JSON.parse(localStorage.getItem('cart') || '[]') }" x-effect="localStorage.setItem('cart', JSON.stringify(cart))">
    <header class="sticky top-0 z-20 border-b bg-white">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3">
            <a href="{{ route('home') }}" class="font-semibold">Fresh Veg</a>
            <nav class="flex items-center gap-4 text-sm">
                @auth
                    <a href="{{ route('orders.index') }}">My Orders</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
                @endauth
                <button type="button" class="relative rounded bg-emerald-600 px-3 py-2 text-white" @click="cartOpen = true">
                    Cart <span class="ml-1" x-text="cart.length"></span>
                </button>
            </nav>
        </div>
    </header>
    <main>{{ $slot }}</main>
    <aside class="fixed inset-y-0 right-0 z-30 w-full max-w-md translate-x-full bg-white p-5 shadow-xl transition md:w-96" :class="cartOpen && 'translate-x-0'">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="font-semibold">Your Bag</h2>
            <button type="button" @click="cartOpen = false">Close</button>
        </div>
        <template x-for="item in cart" :key="item.id">
            <div class="border-b py-3">
                <div class="font-medium" x-text="item.name"></div>
                <div class="text-sm text-slate-600">Rs <span x-text="item.price"></span></div>
            </div>
        </template>
        <a href="{{ route('checkout') }}" class="mt-6 block rounded bg-emerald-600 px-4 py-3 text-center text-white">Checkout</a>
    </aside>
    @livewireScripts
</body>
</html>
