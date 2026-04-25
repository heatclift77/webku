<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">Delete Account</h2>
        <p class="mt-1 text-sm text-gray-600">
            Once your account is deleted, all of its resources and data will be permanently deleted.
        </p>
    </header>

    <button
        type="button"
        id="open-delete-account-modal"
        class="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700"
    >
        Delete Account
    </button>

    <div
        id="delete-account-modal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-900/50 px-4"
        role="dialog"
        aria-modal="true"
        aria-labelledby="delete-account-title"
    >
        <div class="w-full max-w-2xl rounded-lg bg-white p-6 shadow-xl">
            <h2 id="delete-account-title" class="text-lg font-medium text-gray-900">
                Are you sure you want to delete your account?
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Once your account is deleted, all of its resources and data will be permanently deleted.
                Please enter your password to confirm you would like to permanently delete your account.
            </p>

            <form method="post" action="{{ route('profile.destroy') }}" class="mt-6 space-y-6">
                @csrf
                @method('delete')

                <div>
                    <label for="delete_password" class="sr-only">Password</label>
                    <input
                        id="delete_password"
                        name="password"
                        type="password"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 shadow-sm transition focus:border-red-500 focus:ring-red-500 focus:outline-none"
                        placeholder="Password"
                        required
                    />
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex justify-end">
                    <button
                        type="button"
                        id="cancel-delete-account-modal"
                        class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="ml-3 rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700"
                    >
                        Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    (() => {
        const openButton = document.getElementById('open-delete-account-modal');
        const cancelButton = document.getElementById('cancel-delete-account-modal');
        const modal = document.getElementById('delete-account-modal');
        const passwordInput = document.getElementById('delete_password');
        const hasPasswordError = @json($errors->has('password'));

        if (!openButton || !cancelButton || !modal) {
            return;
        }

        const openModal = () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            passwordInput?.focus();
        };

        const closeModal = () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        };

        openButton.addEventListener('click', openModal);
        cancelButton.addEventListener('click', closeModal);
        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                closeModal();
            }
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && modal.classList.contains('flex')) {
                closeModal();
            }
        });

        if (hasPasswordError) {
            openModal();
        }
    })();
</script>
