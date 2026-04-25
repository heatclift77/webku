@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Create Product</h1>
            <p class="text-base text-gray-600 mt-1">Add a new product to your portfolio.</p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 sm:p-8 shadow-sm">
            <form method="POST" action="{{ route('products.store') }}" class="space-y-6 max-w-2xl">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-900 mb-2">Product Name</label>
                    <input id="name" name="name" value="{{ old('name') }}" type="text" placeholder="Enter product name" class="block w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none transition" required>
                    @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-900 mb-2">Description</label>
                    <textarea id="description" name="description" rows="4" placeholder="Describe your product..." class="block w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none transition" required>{{ old('description') }}</textarea>
                    @error('description') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="features" class="block text-sm font-semibold text-gray-900 mb-2">Features</label>
                    <input id="features" name="features" value="{{ old('features') }}" type="text" placeholder="Feature 1, Feature 2, Feature 3..." class="block w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none transition" required>
                    <p class="mt-1 text-sm text-gray-500">Separate features with commas</p>
                    @error('features') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="target_audience" class="block text-sm font-semibold text-gray-900 mb-2">Target Audience</label>
                    <input id="target_audience" name="target_audience" value="{{ old('target_audience') }}" type="text" placeholder="Who is this product for?" class="block w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none transition" required>
                    @error('target_audience') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="price" class="block text-sm font-semibold text-gray-900 mb-2">Price</label>
                    <div class="relative">
                        <span class="absolute left-4 top-2.5 text-gray-600">$</span>
                        <input id="price" name="price" value="{{ old('price') }}" type="number" step="0.01" placeholder="0.00" class="block w-full pl-8 pr-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none transition" required>
                    </div>
                    @error('price') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="usp" class="block text-sm font-semibold text-gray-900 mb-2">Unique Selling Proposition</label>
                    <textarea id="usp" name="usp" rows="3" placeholder="What makes your product unique?" class="block w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none transition" required>{{ old('usp') }}</textarea>
                    @error('usp') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-between gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('products.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 rounded-lg border border-gray-300 hover:bg-gray-50 transition">Cancel</a>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg shadow-md hover:bg-indigo-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create Product
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
