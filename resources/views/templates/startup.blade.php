<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title>
    @vite(['resources/js/app.jsx'])
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
    <!-- Hero Section -->
    <section class="relative overflow-hidden py-20 sm:py-32">
        <div class="absolute inset-0">
            <div class="absolute top-0 -left-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute top-40 -right-40 w-80 h-80 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-80 h-80 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="inline-block mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-purple-500 to-pink-500 text-white">
                        ✨ Next Generation Solution
                    </span>
                </div>

                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold tracking-tight text-white mb-6 leading-tight bg-clip-text text-transparent bg-gradient-to-r from-purple-400 via-pink-400 to-blue-400">
                    {{ $salesPage->generated_content['headline'] }}
                </h1>

                <p class="text-xl sm:text-2xl text-gray-300 mb-12 max-w-3xl mx-auto leading-relaxed">
                    {{ $salesPage->generated_content['subheadline'] }}
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#pricing" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold rounded-lg hover:from-purple-700 hover:to-pink-700 transition duration-200 shadow-lg hover:shadow-2xl">
                        Get Started Free
                    </a>
                    <a href="#features" class="inline-flex items-center justify-center px-8 py-4 border-2 border-purple-400 text-purple-300 font-bold rounded-lg hover:bg-purple-400 hover:bg-opacity-10 transition duration-200">
                        Explore Features
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    @php
        $benefitsArray = array_slice(array_map(fn($b) => trim($b), explode('.', $salesPage->generated_content['benefits'])), 0, 3);
    @endphp

    <section class="py-16 sm:py-24 px-4 sm:px-6 lg:px-8 relative">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-4xl sm:text-5xl font-bold text-white mb-16 text-center">Why {{ $product->name }}?</h2>

            <div class="grid md:grid-cols-3 gap-8">
                @forelse($benefitsArray as $index => $benefit)
                    <div class="group relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl blur opacity-25 group-hover:opacity-100 transition duration-300"></div>
                        <div class="relative bg-slate-800 p-8 rounded-xl border border-slate-700 group-hover:border-purple-500 transition duration-300">
                            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg mb-6">
                                <span class="text-xl">{{ chr(64 + $index + 1) }}</span>
                            </div>
                            <p class="text-gray-100 leading-relaxed font-medium">{{ $benefit }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center text-gray-400">
                        No benefits available
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Features Section -->
    @php
        $featuresArray = array_filter(
            array_map(fn($f) => trim($f), explode(',', $salesPage->generated_content['features'])),
            fn($f) => $f !== ''
        );
    @endphp

    <section id="features" class="py-16 sm:py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-4xl sm:text-5xl font-bold text-white mb-16 text-center">Powerful Features</h2>

            <div class="grid md:grid-cols-3 gap-8">
                @forelse($featuresArray as $feature)
                    <div class="group bg-gradient-to-br from-slate-700 to-slate-800 p-8 rounded-xl border border-slate-600 hover:border-purple-500 transition duration-300 hover:shadow-xl hover:shadow-purple-500/20">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg mb-6 group-hover:scale-110 transition duration-300"></div>
                        <h3 class="text-lg font-semibold text-white mb-3">{{ $feature }}</h3>
                        <p class="text-gray-400 leading-relaxed">Supercharge your productivity with advanced capabilities</p>
                    </div>
                @empty
                    <div class="col-span-3 text-center text-gray-400">
                        No features available
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Social Proof Section -->
    <section class="py-16 sm:py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 rounded-2xl blur opacity-25 group-hover:opacity-100 transition duration-300"></div>
                <div class="relative bg-slate-800 rounded-2xl p-8 sm:p-12 border border-slate-700">
                    <div class="flex items-center justify-center mb-6">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endfor
                    </div>
                    <p class="text-center text-lg text-gray-200 mb-8 italic">
                        {{ $salesPage->generated_content['description'] }}
                    </p>
                    <div class="text-center">
                        <p class="font-semibold text-white">{{ $product->target_audience }}</p>
                        <p class="text-gray-400 text-sm">Trusted by industry leaders</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-16 sm:py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-4xl sm:text-5xl font-bold text-white mb-16 text-center">Simple Pricing</h2>

            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl blur opacity-30 group-hover:opacity-100 transition duration-300"></div>
                <div class="relative bg-slate-800 rounded-2xl p-8 sm:p-12 border border-purple-500">
                    <div class="absolute -top-4 left-8">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-gradient-to-r from-purple-600 to-pink-600 text-white">
                            Most Popular
                        </span>
                    </div>

                    <div class="text-center mb-8 mt-4">
                        <p class="text-gray-400 text-lg mb-4">Standard Plan</p>
                        <div class="text-6xl sm:text-7xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400 mb-2">
                            {{ $salesPage->generated_content['pricing'] }}
                        </div>
                        <p class="text-gray-400">Per month, billed annually</p>
                    </div>

                    <div class="space-y-4 mb-8">
                        <div class="flex items-center text-gray-200">
                            <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Full access to all features</span>
                        </div>
                        <div class="flex items-center text-gray-200">
                            <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Priority support</span>
                        </div>
                        <div class="flex items-center text-gray-200">
                            <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Regular updates included</span>
                        </div>
                    </div>

                    <button class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold py-4 px-6 rounded-lg hover:from-purple-700 hover:to-pink-700 transition duration-200 shadow-lg hover:shadow-2xl mb-6">
                        {{ $salesPage->generated_content['cta'] }}
                    </button>

                    <p class="text-center text-gray-400 text-sm">
                        No credit card required. 14-day free trial.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="py-16 sm:py-24 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        </div>

        <div class="relative max-w-4xl mx-auto text-center">
            <h2 class="text-4xl sm:text-5xl font-bold text-white mb-6 leading-tight">
                Ready to Get Started?
            </h2>
            <p class="text-xl text-gray-300 mb-10 max-w-2xl mx-auto leading-relaxed">
                Join {{ $product->target_audience }} using {{ $product->name }} to transform their workflow.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold rounded-lg hover:from-purple-700 hover:to-pink-700 transition duration-200 shadow-lg hover:shadow-2xl">
                    Start Free Trial
                </button>
                <button class="inline-flex items-center justify-center px-8 py-4 border-2 border-purple-500 text-purple-300 font-bold rounded-lg hover:bg-purple-500 hover:bg-opacity-10 transition duration-200">
                    Schedule Demo
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-slate-700 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-white font-bold mb-4">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-400">{{ $product->description }}</p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Product</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#features" class="hover:text-white transition">Features</a></li>
                        <li><a href="#pricing" class="hover:text-white transition">Pricing</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Company</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition">About</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Legal</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Privacy</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-700 pt-8 text-center text-sm text-gray-400">
                <p>&copy; 2026 {{ $product->name }}. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
