<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>
        <p class="mt-1 text-sm text-gray-600">
            Update your account's profile information and email address.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 shadow-sm transition focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none"
                value="{{ old('name', auth()->user()->name) }}"
                required
                autofocus
                autocomplete="name"
            />
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 shadow-sm transition focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none"
                value="{{ old('email', auth()->user()->email) }}"
                required
                autocomplete="username"
            />
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        @if ($mustVerifyEmail && auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
            <div>
                <p class="mt-2 text-sm text-gray-800">
                    Your email address is unverified.
                    <button form="send-verification" class="rounded-md text-sm text-gray-600 underline hover:text-gray-900">
                        Click here to re-send the verification email.
                    </button>
                </p>

                @if ($status === 'verification-link-sent')
                    <p class="mt-2 text-sm font-medium text-green-600">
                        A new verification link has been sent to your email address.
                    </p>
                @endif
            </div>
        @endif

        <div class="flex items-center gap-4">
            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                Save
            </button>

            @if ($status === 'profile-updated')
                <p class="text-sm text-gray-600">Saved.</p>
            @endif
        </div>
    </form>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
</section>
