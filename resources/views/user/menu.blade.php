@extends('layouts.user')

@section('title', 'Menu - FoodieHub')

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-r from-orange-500 to-red-600 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Our Delicious Menu</h1>
            <p class="text-xl opacity-90">Discover the best dishes crafted with love</p>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Filters -->
        <div class="lg:w-1/4">
            <div class="bg-white rounded-xl shadow-lg p-6 sticky top-24">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Filters</h3>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                </div>
                
                <form action="{{ route('user.menu') }}" method="GET" id="filterForm">
                    <!-- Search -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search food..."
                                   class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Category -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Price Range -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                        <div class="flex gap-2">
                            <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}"
                                   class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}"
                                   class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-red-600 text-white py-2 rounded-lg font-semibold hover:from-orange-600 hover:to-red-700 transition transform hover:scale-105">
                        Apply Filters
                    </button>
                    
                    @if(request()->anyFilled(['search', 'category', 'min_price', 'max_price']))
                        <a href="{{ route('user.menu') }}" class="block text-center mt-3 text-sm text-gray-500 hover:text-orange-600">
                            Clear Filters
                        </a>
                    @endif
                </form>
            </div>
        </div>
        
        <!-- Food Items Grid -->
        <div class="lg:w-3/4">
            <!-- Results Count -->
            <div class="mb-6 flex justify-between items-center">
                <p class="text-gray-600">Showing <span class="font-semibold">{{ $foods->total() }}</span> items</p>
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-500">Sort by:</span>
                    <select class="text-sm border border-gray-300 rounded-lg px-3 py-1">
                        <option>Latest</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Popularity</option>
                    </select>
                </div>
            </div>
            
            <!-- Food Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($foods as $food)
                @php
                    // Safe variant parsing
                    $variantsArray = [];
                    $minPrice = 0;
                    $variantsJson = '[]';
                    
                    if ($food->variant_type == 'multiple' && !empty($food->variants)) {
                        // Convert to array
                        if(is_string($food->variants)) {
                            $variantsArray = json_decode($food->variants, true);
                        } elseif(is_array($food->variants)) {
                            $variantsArray = $food->variants;
                        }
                        
                        // Ensure it's an array
                        $variantsArray = is_array($variantsArray) ? array_values($variantsArray) : [];
                        
                        // Calculate min price
                        if(!empty($variantsArray)) {
                            $prices = array_column($variantsArray, 'price');
                            $minPrice = !empty($prices) ? min($prices) : 0;
                        }
                        
                        // Create JSON for JavaScript
                        $variantsJson = json_encode($variantsArray);
                    }
                @endphp
                
                <div class="group bg-white rounded-xl shadow-md overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <!-- Image Container with fixed size -->
                    <div class="relative overflow-hidden" style="height: 200px;">
                        <img src="{{ asset($food->image) ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400&h=200&fit=crop' }}" 
                             alt="{{ $food->name }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                        
                        <!-- Badges -->
                        <div class="absolute top-3 left-3 flex gap-2">
                            @if($food->variant_type == 'multiple')
                                <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded-full shadow-lg">
                                    🎯 Variants
                                </span>
                            @endif
                            @if($minPrice < 100 && $minPrice > 0)
                                <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full shadow-lg">
                                    🔥 Popular
                                </span>
                            @endif
                        </div>
                        
                        <!-- Wishlist Button -->
                        <button class="absolute top-3 right-3 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-red-50 transition">
                            <svg class="w-4 h-4 text-gray-400 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="p-4">
                        <!-- Category Badge -->
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs text-orange-600 font-medium">{{ $food->category->name ?? 'Food' }}</span>
                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                            <span class="text-xs text-gray-500">⭐ 4.5</span>
                        </div>
                        
                        <!-- Title -->
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-orange-600 transition line-clamp-1">
                            {{ $food->name }}
                        </h3>
                        
                        <!-- Description -->
                        <p class="text-gray-500 text-sm mt-1 line-clamp-2">{{ Str::limit($food->description, 70) }}</p>
                        
                        @if($food->variant_type == 'multiple' && !empty($variantsArray))
                            <!-- Variant Food -->
                            <div class="mt-4">
                                <div class="flex items-baseline gap-1 mb-2">
                                    <span class="text-2xl font-bold text-orange-600">₹{{ number_format($minPrice, 2) }}</span>
                                    <span class="text-xs text-gray-400">+</span>
                                </div>
                                <button onclick='openVariantModal({{ $food->id }}, "{{ $food->name }}", {{ $variantsJson }})'
                                        class="w-full bg-gradient-to-r from-orange-500 to-red-500 text-white py-2 rounded-lg font-medium hover:from-orange-600 hover:to-red-600 transition transform hover:scale-105 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                     Add to Cart
                                </button>
                            </div>
                        @else
                            <!-- Simple Food -->
                            <div class="mt-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-2xl font-bold text-orange-600">₹{{ number_format($food->price, 2) }}</span>
                                    @if($food->price < 200)
                                        <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded-full">Best Seller</span>
                                    @endif
                                </div>
                                <form action="{{ route('user.cart.add', $food->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" 
                                            class="w-full bg-gray-900 text-white py-2 rounded-lg font-medium hover:bg-orange-600 transition transform hover:scale-105 flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6M12 18v3"></path>
                                        </svg>
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                        <div class="text-6xl mb-4">🍽️</div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No foods found</h3>
                        <p class="text-gray-500 mb-6">Try adjusting your filters or search criteria</p>
                        <a href="{{ route('user.menu') }}" class="inline-block bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700">
                            Clear Filters
                        </a>
                    </div>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="mt-12">
                {{ $foods->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Fixed image size */
    .group .relative {
        height: 200px;
    }
    
    /* Responsive image height */
    @media (max-width: 640px) {
        .group .relative {
            height: 180px;
        }
    }
</style>
@endsection