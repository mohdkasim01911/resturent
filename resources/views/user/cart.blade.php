@extends('layouts.user')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 md:py-12">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6 sm:mb-8">Shopping Cart</h1>
    
    @if(empty($cart))
        <div class="bg-white rounded-lg shadow-md p-8 sm:p-12 text-center">
            <div class="text-6xl sm:text-7xl mb-4">🛒</div>
            <p class="text-gray-600 text-base sm:text-lg mb-4">Your cart is empty!</p>
            <a href="{{ route('user.menu') }}" class="bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 inline-block transition">
                Browse Menu
            </a>
        </div>
    @else
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            <!-- Cart Items Section -->
            <div class="lg:w-2/3">
                <!-- DESKTOP TABLE VIEW - Visible only on desktop -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hidden lg:block">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($cart as $key => $item)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                @if(isset($item['image']) && $item['image'])
                                                    <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover rounded-lg">
                                                @else
                                                    <span class="text-2xl">🍕</span>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $item['name'] }}</p>
                                                @if(isset($item['variant_name']) && $item['variant_name'])
                                                    <p class="text-xs text-gray-500">Size: {{ $item['variant_name'] }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">₹{{ number_format($item['price'], 2) }}</td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('user.cart.update', $key) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="99" 
                                                   class="w-16 px-2 py-1 border border-gray-300 rounded-md text-center focus:outline-none focus:ring-2 focus:ring-orange-500">
                                            <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm">Update</button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 font-semibold">₹{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('user.cart.remove', $key) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- MOBILE CARD VIEW - Visible only on mobile/tablet -->
                <div class="space-y-4 lg:hidden">
                    @foreach($cart as $key => $item)
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <!-- Product Header -->
                        <div class="flex gap-4">
                            <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                @if(isset($item['image']) && $item['image'])
                                    <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <span class="text-3xl">🍕</span>
                                @endif
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900">{{ $item['name'] }}</h3>
                                        @if(isset($item['variant_name']) && $item['variant_name'])
                                            <p class="text-xs text-gray-500">Size: {{ $item['variant_name'] }}</p>
                                        @endif
                                        <p class="text-orange-600 font-bold text-lg mt-2">₹{{ number_format($item['price'], 2) }}</p>
                                    </div>
                                    <form action="{{ route('user.cart.remove', $key) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quantity and Total -->
                        <div class="mt-4 pt-3 border-t">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="text-sm text-gray-600">Qty:</span>
                                    <form action="{{ route('user.cart.update', $key) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <div class="flex items-center border border-gray-300 rounded-lg">
                                            <button type="button" onclick="decrementQuantity(this)" class="w-8 h-8 flex items-center justify-center text-gray-600 hover:bg-gray-100 rounded-l-lg">-</button>
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="99" 
                                                   class="w-12 text-center py-1 text-sm focus:outline-none quantity-input">
                                            <button type="button" onclick="incrementQuantity(this)" class="w-8 h-8 flex items-center justify-center text-gray-600 hover:bg-gray-100 rounded-r-lg">+</button>
                                        </div>
                                        <button type="submit" class="text-blue-600 text-sm">Update</button>
                                    </form>
                                </div>
                                <div>
                                    <span class="font-bold text-orange-600">₹{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Action Buttons -->
                <div class="mt-4 flex flex-col sm:flex-row justify-between gap-3">
                    <a href="{{ route('user.menu') }}" class="text-orange-600 hover:text-orange-700 text-center sm:text-left">
                        ← Continue Shopping
                    </a>
                    <form action="{{ route('user.cart.clear') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-center w-full sm:w-auto">
                            Clear Cart
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Order Summary - Desktop -->
            <div class="lg:w-1/3">
                <div class="bg-white rounded-lg shadow-md p-5 sm:p-6 lg:sticky lg:top-20">
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-4">Order Summary</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>₹{{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Delivery Fee</span>
                            <span>₹50.00</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>GST (5%)</span>
                            <span>₹{{ number_format($total * 0.05, 2) }}</span>
                        </div>
                        <div class="border-t pt-3 mt-3">
                            <div class="flex justify-between font-bold text-lg sm:text-xl">
                                <span>Total Amount</span>
                                <span class="text-orange-600">₹{{ number_format($total + 50 + ($total * 0.05), 2) }}</span>
                            </div>
                            <p class="text-xs text-gray-400 mt-1 text-right">Inclusive of all taxes</p>
                        </div>
                    </div>
                    
                    <!-- Promo Code -->
                    <div class="mt-4">
                        <div class="flex gap-2">
                            <input type="text" placeholder="Promo code" 
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
                            <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-sm font-medium">
                                Apply
                            </button>
                        </div>
                    </div>
                    
                    <!-- Checkout Button -->
                    <a href="{{ route('user.checkout') }}" 
                       class="block w-full bg-gradient-to-r from-orange-500 to-red-600 text-white text-center py-3 rounded-lg mt-6 hover:from-orange-600 hover:to-red-700 transition font-semibold">
                        Proceed to Checkout →
                    </a>
                    
                    <!-- Payment Methods -->
                    <div class="mt-4 pt-4 border-t">
                        <p class="text-xs text-gray-500 text-center">Secure Payments</p>
                        <div class="flex justify-center gap-3 mt-2">
                            <span class="text-xl">💳</span>
                            <span class="text-xl">📱</span>
                            <span class="text-xl">💵</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    function incrementQuantity(btn) {
        let input = btn.parentElement.parentElement.querySelector('.quantity-input');
        if(input) {
            let currentVal = parseInt(input.value);
            if (!isNaN(currentVal)) {
                input.value = currentVal + 1;
                let form = btn.closest('form');
                if(form) form.submit();
            }
        }
    }
    
    function decrementQuantity(btn) {
        let input = btn.parentElement.parentElement.querySelector('.quantity-input');
        if(input) {
            let currentVal = parseInt(input.value);
            if (!isNaN(currentVal) && currentVal > 1) {
                input.value = currentVal - 1;
                let form = btn.closest('form');
                if(form) form.submit();
            }
        }
    }
</script>

<style>
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endsection