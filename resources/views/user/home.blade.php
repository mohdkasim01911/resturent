@extends('layouts.user')

@section('title', 'Home - FoodieHub')

@section('content')
<!-- Hero Section with Slider -->
<section class="relative bg-gradient-to-r from-orange-500 to-red-600 text-white overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    
    
    <!-- Wave SVG -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full">
            <path fill="#ffffff" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Why Choose Us Ok please?</h2>
            <p class="text-gray-600 text-lg">We provide the best food delivery experience</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center group">
                <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-orange-200 transition">
                    <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Fast Delivery</h3>
                <p class="text-gray-600">30-40 minutes delivery guaranteed</p>
            </div>
            
            <div class="text-center group">
                <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-orange-200 transition">
                    <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Quality Food</h3>
                <p class="text-gray-600">Fresh ingredients, hygienic preparation</p>
            </div>
            
            <div class="text-center group">
                <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-orange-200 transition">
                    <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Best Prices</h3>
                <p class="text-gray-600">Affordable prices with great deals</p>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Popular Categories</h2>
            <p class="text-gray-600 text-lg">Explore our delicious food categories</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
            <a href="{{ route('user.category.wise', $category->id) }}" 
               class="group bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="h-32 bg-gradient-to-r from-orange-400 to-red-500 flex items-center justify-center">
                    <div class="text-5xl">
                        @if($category->name == 'Pizza') 🍕
                        @elseif($category->name == 'Burger') 🍔
                        @elseif($category->name == 'Biryani') 🍚
                        @elseif($category->name == 'Pasta') 🍝
                        @elseif($category->name == 'Beverages') 🥤
                        @elseif($category->name == 'Desserts') 🍰
                        @else 🍽️
                        @endif
                    </div>
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-semibold text-gray-900 group-hover:text-orange-600 transition">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $category->foods_count }} items</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Foods Section -->
<section id="featured" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Featured Dishes</h2>
            <p class="text-gray-600 text-lg">Most popular items loved by our customers</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
             @foreach($featuredFoods as $food)
@php
    // Properly convert variants to array
    $variantsArray = [];
    $minPrice = 0;
    
    // Check if food has variants
    if($food->variant_type == 'multiple' && !empty($food->variants)) {
        // Convert JSON string to array
        if(is_string($food->variants)) {
            $variantsArray = $food->variants;
        } elseif(is_array($food->variants)) {
            $variantsArray = $food->variants;
        }

       


    }

    $minPrice = $food->getMinPrice();

@endphp

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
    <img src="{{ asset($food->image) ?? 'https://via.placeholder.com/300x200' }}" alt="{{ $food->name }}" class="w-full h-48 object-cover">
    <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-900">{{ $food->name }}</h3>
        <p class="text-gray-600 text-sm mt-1">{{ Str::limit($food->description, 80) }}</p>
        
        @if($food->variant_type == 'multiple')
            <div class="mt-4">
                <div class="text-sm text-gray-500 mb-2">
                    Starting from ₹{{ number_format($minPrice, 2) }}
                </div>
                <button onclick='openVariantModal({{ $food->id }}, "{{ $food->name }}", {{ $variantsArray }})' 
                        class="w-full bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition">
                    Select Variant 
                </button>
            </div>
        @else
            <div class="mt-4 flex justify-between items-center">
                <span class="text-2xl font-bold text-orange-600">₹{{ number_format($food->price, 2) }}</span>
                <form action="{{ route('user.cart.add', $food->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition">
                        Add to Cart
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('user.menu') }}" 
               class="inline-flex items-center bg-gray-900 text-white px-8 py-3 rounded-lg hover:bg-gray-800 transition">
                View Full Menu
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Special Offers Banner -->
<section class="py-16 bg-gradient-to-r from-orange-500 to-red-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Special Offer!</h2>
        <p class="text-xl mb-6">Get 20% off on your first order</p>
        <p class="text-lg mb-8">Use code: <span class="font-mono bg-white bg-opacity-20 px-4 py-2 rounded-lg">FOODIE20</span></p>
        <a href="{{ route('user.menu') }}" 
           class="inline-block bg-white text-orange-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition transform hover:scale-105">
            Order Now
        </a>
    </div>
</section>

<!-- Testimonials Section -->
<!-- <section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">What Our Customers Say</h2>
            <p class="text-gray-600 text-lg">Loved by thousands of food lovers</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">👨</span>
                    </div>
                    <div class="ml-3">
                        <h4 class="font-semibold">Rahul Sharma</h4>
                        <div class="flex text-yellow-400">
                            ★★★★★
                        </div>
                    </div>
                </div>
                <p class="text-gray-600">"Amazing food quality! The delivery was super fast. Highly recommended!"</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">👩</span>
                    </div>
                    <div class="ml-3">
                        <h4 class="font-semibold">Priya Patel</h4>
                        <div class="flex text-yellow-400">
                            ★★★★★
                        </div>
                    </div>
                </div>
                <p class="text-gray-600">"Best pizza in town! The crust is perfect and toppings are fresh."</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">👨</span>
                    </div>
                    <div class="ml-3">
                        <h4 class="font-semibold">Amit Kumar</h4>
                        <div class="flex text-yellow-400">
                            ★★★★★
                        </div>
                    </div>
                </div>
                <p class="text-gray-600">"Great variety of options. The biryani is absolutely delicious!"</p>
            </div>
        </div>
    </div>
</section> -->

<!-- Newsletter Section -->
<!-- <section class="py-16 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Subscribe to Our Newsletter</h2>
        <p class="text-gray-600 mb-6">Get latest offers and discounts directly in your inbox</p>
        
        <form class="flex flex-col sm:flex-row gap-4">
            <input type="email" 
                   placeholder="Enter your email" 
                   class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
            <button type="submit" 
                    class="bg-orange-600 text-white px-8 py-3 rounded-lg hover:bg-orange-700 transition">
                Subscribe
            </button>
        </form>
    </div>
</section> -->
@endsection

@push('styles')
<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fade-in 1s ease-out;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush