<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-white text-gray-900 font-light">
    <!-- Hero Section -->
    <section class="py-32 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-6xl sm:text-7xl lg:text-8xl font-light tracking-tighter mb-8 leading-tight">
                {{ $salesPage->generated_content['headline'] }}
            </h1>

            <p class="text-xl sm:text-2xl text-gray-700 mb-12 leading-relaxed max-w-2xl mx-auto font-light">
                {{ $salesPage->generated_content['subheadline'] }}
            </p>

            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                <a href="#pricing" class="inline-flex items-center px-8 py-3 bg-gray-900 text-white hover:bg-gray-800 transition duration-300">
                    Get Started
                </a>
                <a href="#features" class="inline-flex items-center px-8 py-3 border border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white transition duration-300">
                    Learn More
                </a>
            </div>
        </div>
    </section>

    <!-- Divider -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="border-t border-gray-200"></div>
    </div>

    <!-- Benefits Section -->
    @php
        $benefitsArray = array_slice(array_map(fn($b) => trim($b), explode('.', $salesPage->generated_content['benefits'])), 0, 3);
    @endphp

    <section class="py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-5xl font-light mb-16 tracking-tight">Key Benefits</h2>

            <div class="space-y-12">
                @forelse($benefitsArray as $benefit)
                    <div class="border-l-4 border-gray-900 pl-8 py-2">
                        <p class="text-xl text-gray-700 leading-relaxed font-light">{{ $benefit }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">No benefits available</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Divider -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="border-t border-gray-200"></div>
    </div>

    <!-- Features Section -->
    @php
        $featuresArray = array_filter(
            array_map(fn($f) => trim($f), explode(',', $salesPage->generated_content['features'])),
            fn($f) => $f !== ''
        );
    @endphp

    <section id="features" class="py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-5xl font-light mb-16 tracking-tight">Features</h2>

            <div class="grid md:grid-cols-2 gap-16">
                @forelse($featuresArray as $feature)
                    <div class="space-y-4">
                        <div class="w-2 h-2 bg-gray-900"></div>
                        <p class="text-lg text-gray-800 font-light leading-relaxed">{{ $feature }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">No features available</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Divider -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="border-t border-gray-200"></div>
    </div>

    <!-- Description Section -->
    <section class="py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-5xl font-light mb-8 tracking-tight">About</h2>
            <p class="text-xl text-gray-700 leading-relaxed font-light mb-8">
                {{ $salesPage->generated_content['description'] }}
            </p>
            <p class="text-lg text-gray-600 font-light">
                Target Audience: {{ $product->target_audience }}
            </p>
        </div>
    </section>

    <!-- Divider -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="border-t border-gray-200"></div>
    </div>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-5xl font-light mb-16 tracking-tight">Pricing</h2>

            <div class="space-y-8">
                <div>
                    <p class="text-gray-600 text-sm uppercase tracking-widest mb-4 font-light">Standard Plan</p>
                    <div class="text-7xl font-light mb-4">
                        {{ $salesPage->generated_content['pricing'] }}
                    </div>
                    <p class="text-gray-600 font-light">Per month, billed annually</p>
                </div>

                <button class="w-full bg-gray-900 text-white py-4 px-8 hover:bg-gray-800 transition duration-300 font-light">
                    {{ $salesPage->generated_content['cta'] }}
                </button>

                <p class="text-gray-600 text-sm font-light">
                    No credit card required. 14-day free trial.
                </p>
            </div>
        </div>
    </section>

    <!-- Divider -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="border-t border-gray-200"></div>
    </div>

    <!-- Footer -->
    <footer class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 mb-12">
                <div>
                    <h3 class="text-sm font-light uppercase tracking-widest mb-4">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-600 font-light">{{ $product->description }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-light uppercase tracking-widest mb-4">Product</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#features" class="hover:text-gray-900 transition font-light">Features</a></li>
                        <li><a href="#pricing" class="hover:text-gray-900 transition font-light">Pricing</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-light uppercase tracking-widest mb-4">Company</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-gray-900 transition font-light">About</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition font-light">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-light uppercase tracking-widest mb-4">Legal</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-gray-900 transition font-light">Privacy</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition font-light">Terms</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-8">
                <p class="text-center text-sm text-gray-600 font-light">
                    &copy; 2026 {{ $product->name }}. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
