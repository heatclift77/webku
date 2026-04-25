@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">{{ $product->name }}</h1>
                <p class="text-sm text-gray-600">Product details and generated sales page</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">Back to Products</a>
                @if($salesPage)
                    <a href="{{ route('sales-pages.show', $product) }}" target="_blank" class="inline-flex items-center justify-center rounded-md border border-purple-300 bg-purple-50 px-4 py-2 text-sm font-semibold text-purple-700 shadow-sm hover:bg-purple-100">
                        👁 View Landing Page
                    </a>
                    <a href="{{ route('sales-pages.export', $salesPage) }}" class="inline-flex items-center justify-center rounded-md border border-green-300 bg-green-50 px-4 py-2 text-sm font-semibold text-green-700 shadow-sm hover:bg-green-100">
                        ⬇ Download HTML
                    </a>
                @endif
                <form method="POST" action="{{ route('products.generate', $product) }}" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                        {{ $salesPage ? 'Regenerate' : 'Generate' }} Sales Page
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Product Details -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Product Information</h2>

                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                        <dd class="text-sm text-gray-900">{{ $product->name }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                        <dd class="text-sm text-gray-900">{{ $product->description }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Features</dt>
                        <dd class="text-sm text-gray-900">
                            <ul class="list-disc list-inside">
                                @foreach($product->features ?? [] as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                            </ul>
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Target Audience</dt>
                        <dd class="text-sm text-gray-900">{{ $product->target_audience }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Price</dt>
                        <dd class="text-sm text-gray-900">${{ number_format($product->price, 2) }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Unique Selling Proposition</dt>
                        <dd class="text-sm text-gray-900">{{ $product->usp }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Generated Sales Page -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Generated Sales Page</h2>

                @if($salesPage)
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-md font-medium text-gray-900">Headline</h3>
                            <p class="text-sm text-gray-700">{{ $salesPage->generated_content['headline'] }}</p>
                        </div>

                        <div>
                            <h3 class="text-md font-medium text-gray-900">Subheadline</h3>
                            <p class="text-sm text-gray-700">{{ $salesPage->generated_content['subheadline'] }}</p>
                        </div>

                        <div>
                            <h3 class="text-md font-medium text-gray-900">Description</h3>
                            <p class="text-sm text-gray-700">{{ $salesPage->generated_content['description'] }}</p>
                        </div>

                        <div>
                            <h3 class="text-md font-medium text-gray-900">Benefits</h3>
                            <p class="text-sm text-gray-700">{{ $salesPage->generated_content['benefits'] }}</p>
                        </div>

                        <div>
                            <h3 class="text-md font-medium text-gray-900">Features</h3>
                            <p class="text-sm text-gray-700">{{ $salesPage->generated_content['features'] }}</p>
                        </div>

                        <div>
                            <h3 class="text-md font-medium text-gray-900">Pricing</h3>
                            <p class="text-sm text-gray-700">{{ $salesPage->generated_content['pricing'] }}</p>
                        </div>

                        <div>
                            <h3 class="text-md font-medium text-gray-900">Call to Action</h3>
                            <p class="text-sm text-gray-700">{{ $salesPage->generated_content['cta'] }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-sm text-gray-500">No sales page generated yet. Click "Generate Sales Page" to create one.</p>
                @endif
            </div>
        </div>

        @if($salesPage)
        <!-- Template Selector Section -->
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Choose Template Design</h2>
            <p class="text-sm text-gray-600 mb-6">Select how your landing page should look:</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach(['modern' => 'Modern', 'minimal' => 'Minimal', 'startup' => 'Startup'] as $templateKey => $templateName)
                    <form method="POST" action="{{ route('products.template.update', $product) }}" class="inline w-full">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="template" value="{{ $templateKey }}">

                        <button type="submit" class="w-full group">
                            <div class="relative overflow-hidden rounded-lg border-2 transition-all duration-200 {{ $salesPage->template === $templateKey ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200 bg-white hover:border-gray-300' }}">
                                <!-- Template Preview Cards -->
                                <div class="p-6 space-y-4">
                                    @if($templateKey === 'modern')
                                        <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded w-3/4"></div>
                                        <div class="h-1 bg-gray-200 rounded w-full"></div>
                                        <div class="h-1 bg-gray-200 rounded w-2/3"></div>
                                        <div class="pt-2 space-y-2">
                                            <div class="h-2 bg-indigo-100 rounded w-1/2"></div>
                                            <div class="h-2 bg-indigo-100 rounded w-full"></div>
                                        </div>
                                    @elseif($templateKey === 'minimal')
                                        <div class="h-3 bg-gray-900 rounded w-2/3"></div>
                                        <div class="h-1 bg-gray-300 rounded w-full mt-4"></div>
                                        <div class="h-1 bg-gray-300 rounded w-full"></div>
                                        <div class="h-1 bg-gray-300 rounded w-3/4"></div>
                                    @else
                                        <div class="space-y-2">
                                            <div class="h-2 bg-gradient-to-r from-purple-500 via-pink-500 to-blue-500 rounded w-full"></div>
                                            <div class="flex gap-2">
                                                <div class="h-2 bg-purple-200 rounded flex-1"></div>
                                                <div class="h-2 bg-pink-200 rounded flex-1"></div>
                                                <div class="h-2 bg-blue-200 rounded flex-1"></div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                                    <p class="font-semibold text-gray-900">{{ $templateName }}</p>
                                    <p class="text-xs text-gray-600 mt-1">
                                        @if($templateKey === 'modern')
                                            Colorful & Modern
                                        @elseif($templateKey === 'minimal')
                                            Clean & Minimal
                                        @else
                                            Bold & Energetic
                                        @endif
                                    </p>
                                </div>

                                @if($salesPage->template === $templateKey)
                                    <div class="absolute top-3 right-3">
                                        <div class="flex items-center justify-center w-6 h-6 bg-indigo-600 rounded-full">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </button>
                    </form>
                @endforeach
            </div>

            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-700">
                    <strong>Preview:</strong> Visit the landing page to see the template in action. The design changes will be visible immediately.
                </p>
            </div>
        </div>
        @endif
    </div>
@endsection
