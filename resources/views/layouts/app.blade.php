<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>webku</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 text-gray-900">
    <div class="min-h-screen">
        <header class="bg-white border-b border-gray-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between gap-4">
                <div>
                    <a href="{{ route('products.index') }}" class="text-lg font-bold text-indigo-600">webku</a>
                </div>

                <nav class="flex flex-wrap items-center gap-3 text-sm text-gray-700">
                    <a href="{{ route('products.index') }}" class="hover:text-gray-900 font-medium">Products</a>
                    <a href="{{ route('profile.edit') }}" class="hover:text-gray-900 font-medium">Profile</a>
                    <span class="hidden sm:inline">|</span>
                    <span class="text-gray-500">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-indigo-600 hover:text-indigo-800 font-medium">Logout</button>
                    </form>
                </nav>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if (session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-900">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
