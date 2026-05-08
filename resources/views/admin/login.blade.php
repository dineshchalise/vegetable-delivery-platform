<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <main class="mx-auto flex min-h-screen max-w-md items-center px-4">
        <form method="POST" action="{{ route('admin.login') }}" class="w-full rounded bg-white p-6 shadow">
            @csrf
            <h1 class="mb-6 text-2xl font-semibold">Admin Login</h1>

            @if($errors->any())
                <div class="mb-4 rounded bg-red-50 p-3 text-sm text-red-700">{{ $errors->first() }}</div>
            @endif

            <label class="mb-4 grid gap-1">
                <span class="text-sm font-medium">Email</span>
                <input name="email" type="email" value="{{ old('email') }}" class="rounded border p-3" required autofocus>
            </label>

            <label class="mb-4 grid gap-1">
                <span class="text-sm font-medium">Password</span>
                <input name="password" type="password" class="rounded border p-3" required>
            </label>

            <label class="mb-6 flex items-center gap-2 text-sm">
                <input name="remember" type="checkbox" value="1">
                <span>Remember me</span>
            </label>

            <button class="w-full rounded bg-emerald-600 px-4 py-3 text-white">Login</button>

            <p class="mt-4 text-sm text-slate-600">
                Demo admin: admin@veg.test / password123
            </p>
        </form>
    </main>
</body>
</html>
