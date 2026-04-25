<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>webku - Register</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Create Account</h2>
                <p class="text-gray-600 mt-2">Join us today! Create your new account.</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input id="name" class="block mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none transition"
                           type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" class="block mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none transition"
                           type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" class="block mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none transition"
                           type="password" name="password" required autocomplete="new-password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input id="password_confirmation" class="block mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none transition"
                           type="password" name="password_confirmation" required autocomplete="new-password">
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end mt-6">
                    <a class="text-sm text-indigo-600 hover:text-indigo-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        Already registered?
                    </a>

                    <button type="submit" class="ml-3 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Register
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    By creating an account, you agree to our
                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Terms of Service</a> and
                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Privacy Policy</a>.
                </p>
            </div>
        </div>
    </div>
</body>
</html>