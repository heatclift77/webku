@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Products</h1>
                <p class="text-base text-gray-600 mt-1">Create and manage your products to generate AI-powered sales pages.</p>
            </div>

            <a href="{{ route('products.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-md hover:bg-indigo-700 transition duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create Product
            </a>
        </div>

        <!-- Products Grid -->
        @forelse ($products as $product)
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm hover:shadow-md transition duration-200">
                <div class="p-6 sm:p-8">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <!-- Product Info -->
                        <div class="flex-1 min-w-0">
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 break-words">{{ $product->name }}</h2>
                            <p class="text-sm text-gray-600 mt-2">{{ \Illuminate\Support\Str::limit($product->description, 100) }}</p>
                            
                            <div class="mt-4 flex flex-wrap gap-3">
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Price</p>
                                    <p class="text-lg font-bold text-indigo-600">${{ number_format($product->price, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Audience</p>
                                    <p class="text-base font-medium text-gray-700">{{ \Illuminate\Support\Str::limit($product->target_audience, 20) }}</p>
                                </div>
                            </div>

                            <div class="mt-4">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">USP</p>
                                <p class="text-sm text-gray-700">{{ \Illuminate\Support\Str::limit($product->usp, 80) }}</p>
                            </div>
                        </div>

                        <!-- Sales Page Status -->
                        <div class="flex-shrink-0 sm:text-right">
                            @if ($product->salesPage)
                                <div class="inline-flex items-center gap-2 rounded-full bg-green-50 px-3 py-1 text-sm font-medium text-green-700 border border-green-200">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Generated
                                </div>
                            @else
                                <div class="inline-flex items-center gap-2 rounded-full bg-yellow-50 px-3 py-1 text-sm font-medium text-yellow-700 border border-yellow-200">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Not Generated
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 flex flex-wrap gap-2 sm:gap-3">
                        <a href="{{ route('products.show', $product) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-indigo-600 text-indigo-600 font-medium hover:bg-indigo-50 transition duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            View Details
                        </a>

                        <a href="{{ route('products.edit', $product) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </a>

                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-red-300 text-red-600 font-medium hover:bg-red-50 transition duration-200" onclick="return confirm('Are you sure you want to delete this product?');">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 p-12">
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">No products yet</h3>
                    <p class="mt-2 text-base text-gray-600">Get started by creating your first product. You can then generate AI-powered sales pages for each product.</p>
                    <a href="{{ route('products.create') }}" class="mt-6 inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-md hover:bg-indigo-700 transition duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create Your First Product
                    </a>
                </div>
            </div>
        @endforelse
    </div>
@endsection
