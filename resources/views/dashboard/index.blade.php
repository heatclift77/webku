<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <a href="/" class="text-xl font-bold text-gray-800">{{ config('app.name', 'Laravel') }}</a>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-700">Welcome, {{ auth()->user()->name }}!</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="px-4 py-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h1 class="text-2xl font-bold text-gray-900 mb-4">Dashboard</h1>
                        <p class="text-gray-600">Welcome to your dashboard! You are successfully logged in.</p>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Dashboard Cards -->
                            <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                                <h3 class="text-lg font-semibold text-blue-900 mb-2">Profile</h3>
                                <p class="text-blue-700 text-sm mb-4">Manage your account settings and preferences.</p>
                                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View Profile →</a>
                            </div>

                            <div class="bg-green-50 p-6 rounded-lg border border-green-200">
                                <h3 class="text-lg font-semibold text-green-900 mb-2">Settings</h3>
                                <p class="text-green-700 text-sm mb-4">Configure your application settings.</p>
                                <a href="#" class="text-green-600 hover:text-green-800 text-sm font-medium">View Settings →</a>
                            </div>

                            <div class="bg-purple-50 p-6 rounded-lg border border-purple-200">
                                <h3 class="text-lg font-semibold text-purple-900 mb-2">Activity</h3>
                                <p class="text-purple-700 text-sm mb-4">View your recent activity and logs.</p>
                                <a href="#" class="text-purple-600 hover:text-purple-800 text-sm font-medium">View Activity →</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>