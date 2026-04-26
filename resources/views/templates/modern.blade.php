<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title>
    @vite(['resources/js/app.jsx'])
</head>
<body class="bg-white">
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-indigo-700 py-20 sm:py-32">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        </div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold tracking-tight text-white mb-6 leading-tight">
                    {{ $salesPage->generated_content['headline'] }}
                </h1>

                <p class="text-xl sm:text-2xl text-indigo-100 mb-10 max-w-3xl mx-auto leading-relaxed">
                    {{ $salesPage->generated_content['subheadline'] }}
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#pricing" class="inline-flex items-center justify-center px-8 py-4 bg-white text-indigo-600 font-bold rounded-lg hover:bg-gray-50 transition duration-200 shadow-lg hover:shadow-xl">
                        Get Started Now
                    </a>
                    <a href="#features" class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:bg-opacity-10 transition duration-200">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    @php
        $benefitsArray = array_slice(array_map(fn($b) => trim($b), explode('.', $salesPage->generated_content['benefits'])), 0, 3);
    @endphp

    <section class="py-16 sm:py-24 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">Why Choose {{ $product->name }}?</h2>
                <p class="text-xl text-gray-600">Unlock the power of intelligent task management</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @forelse($benefitsArray as $index => $benefit)
                    <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-lg transition duration-300">
                        <div class="flex items-center justify-center w-12 h-12 bg-indigo-100 rounded-lg mb-6">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="text-gray-700 leading-relaxed">{{ $benefit }}</p>
                    </div>
                @empty
                    <div class="col-span-3 text-center text-gray-500">
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

    <section id="features" class="py-16 sm:py-24 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">Powerful Features</h2>
                <p class="text-xl text-gray-600">Everything you need to succeed</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @forelse($featuresArray as $feature)
                    <div class="group bg-gradient-to-br from-gray-50 to-white p-8 rounded-xl border border-gray-200 hover:border-indigo-300 hover:shadow-lg transition duration-300">
                        <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg mb-6 group-hover:scale-110 transition duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ $feature }}</h3>
                        <p class="text-gray-600">Streamline your workflow with this essential feature</p>
                    </div>
                @empty
                    <div class="col-span-3 text-center text-gray-500">
                        No features available
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Social Proof / Testimonial Section -->
    <section class="py-16 sm:py-24 bg-indigo-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white rounded-2xl shadow-lg p-8 sm:p-12">
                    <div class="flex items-center justify-center mb-6">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endfor
                    </div>
                    <p class="text-center text-lg text-gray-700 mb-8 italic">
                        "{{ $salesPage->generated_content['description'] }}"
                    </p>
                    <div class="text-center">
                        <p class="font-semibold text-gray-900">{{ $product->target_audience }}</p>
                        <p class="text-gray-600">Satisfied Customers</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-16 sm:py-24 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">Simple, Transparent Pricing</h2>
                <p class="text-xl text-gray-600">Start for free, upgrade when you need more</p>
            </div>

            <div class="max-w-2xl mx-auto">
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 border-2 border-indigo-200 rounded-2xl shadow-xl p-8 sm:p-12 relative">
                    <div class="absolute -top-4 right-8 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-1 rounded-full text-sm font-semibold">
                        Best Value
                    </div>

                    <div class="text-center mb-8">
                        <p class="text-gray-600 text-lg mb-4">Our Standard Plan</p>
                        <div class="text-6xl sm:text-7xl font-bold text-gray-900 mb-2">
                            {{ $salesPage->generated_content['pricing'] }}
                        </div>
                        <p class="text-gray-600">Per month, billed annually</p>
                    </div>

                    <div class="space-y-4 mb-8">
                        <div class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-indigo-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Access to all features</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-indigo-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>24/7 customer support</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-indigo-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Regular updates & improvements</span>
                        </div>
                    </div>

                    <button class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold py-4 px-6 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition duration-200 shadow-lg hover:shadow-xl">
                        {{ $salesPage->generated_content['cta'] }}
                    </button>

                    <p class="text-center text-gray-600 text-sm mt-6">
                        No credit card required. 14-day free trial.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="py-16 sm:py-24 bg-gradient-to-r from-gray-900 to-black relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl"></div>
        </div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl sm:text-5xl font-bold text-white mb-6 leading-tight">
                Ready to Transform Your Productivity?
            </h2>
            <p class="text-xl text-gray-300 mb-10 max-w-2xl mx-auto leading-relaxed">
                Join thousands of professionals who are already using {{ $product->name }} to streamline their workflow and achieve more.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-bold rounded-lg hover:from-indigo-600 hover:to-purple-700 transition duration-200 shadow-lg hover:shadow-xl">
                    Start Your Free Trial
                </button>
                <button class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:bg-opacity-10 transition duration-200">
                    Schedule a Demo
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-white font-semibold mb-4">{{ $product->name }}</h3>
                    <p class="text-sm">{{ $product->description }}</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Product</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#features" class="hover:text-white transition">Features</a></li>
                        <li><a href="#pricing" class="hover:text-white transition">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition">Security</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">About</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Privacy</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms</a></li>
                        <li><a href="#" class="hover:text-white transition">Cookies</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; 2026 {{ $product->name }}. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
