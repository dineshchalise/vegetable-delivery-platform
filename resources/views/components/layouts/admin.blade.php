<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | {{ config('app.name', 'Vegetable Delivery') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-100 text-slate-900">
    <div class="min-h-screen md:flex">
        <aside class="bg-slate-950 p-4 text-white md:w-64">
            <div class="mb-6 font-semibold">Admin</div>
            <nav class="grid gap-2 text-sm">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a href="{{ route('admin.products') }}">Products</a>
                <a href="{{ route('admin.hubs') }}">Hubs</a>
                <a href="{{ route('admin.orders') }}">Orders</a>
                <a href="{{ route('admin.customers') }}">Customers</a>
                <a href="{{ route('admin.categories') }}">Categories</a>
                <a href="{{ route('admin.staff') }}">Staff</a>
                <a href="{{ route('admin.settings') }}">Settings</a>
            </nav>
        </aside>
        <main class="flex-1 p-6">{{ $slot }}</main>
    </div>
    @livewireScripts
</body>
</html>
