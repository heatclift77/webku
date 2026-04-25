<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Update Password</h2>
        <p class="mt-1 text-sm text-gray-600">
            Ensure your account is using a long, random password to stay secure.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
            <input
                id="current_password"
                name="current_password"
                type="password"
                class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 shadow-sm transition focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none"
                autocomplete="current-password"
            />
            @error('current_password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
            <input
                id="password"
                name="password"
                type="password"
                class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 shadow-sm transition focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none"
                autocomplete="new-password"
            />
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 shadow-sm transition focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none"
                autocomplete="new-password"
            />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                Save
            </button>

            @if ($status === 'password-updated')
                <p class="text-sm text-gray-600">Saved.</p>
            @endif
        </div>
    </form>
</section>
