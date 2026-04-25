import { usePage } from '@inertiajs/react';

export default function AuthenticatedLayout({ header, children }) {
    const user = usePage().props.auth.user;

    return (
        <div className="min-h-screen bg-gray-100">
            <nav className="border-b border-gray-200 bg-white shadow-sm">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between gap-4">
                    <div>
                        <a href={route('products.index')}>
                            <span className="text-lg font-bold text-indigo-600">webku</span>
                        </a>
                    </div>

                    <div className="flex flex-wrap items-center gap-3 text-sm text-gray-700">
                        <a href={route('products.index')} className="hover:text-gray-900 font-medium">
                            Products
                        </a>
                        <a href={route('profile.edit')} className="hover:text-gray-900 font-medium">
                            Profile
                        </a>
                        <span className="hidden sm:inline">|</span>
                        <span className="hidden sm:inline text-gray-500">{user.name}</span>
                        <form method="POST" action={route('logout')} className="inline">
                            <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.content ?? ''} />
                            <button type="submit" className="text-indigo-600 hover:text-indigo-800 font-medium">
                                Logout
                            </button>
                        </form>
                    </div>

                </div>
            </nav>

            <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">{children}</main>
        </div>
    );
}
