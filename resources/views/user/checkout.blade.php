@extends('layouts.user')

@section('title', 'Checkout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>
    
    <form action="{{ route('user.checkout.process') }}" method="POST">
        @csrf
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Billing Details -->
            <div class="lg:w-2/3">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Delivery Details</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input type="text" value="{{ Auth::user()->name }}" readonly 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" value="{{ Auth::user()->email }}" readonly 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50">
                    </div>
                    
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                        <input type="text" name="phone" id="phone" required value="{{ old('phone', Auth::user()->phone) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    
                    <div class="mb-4">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Delivery Address *</label>
                        <textarea name="address" id="address" rows="3" required 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-orange-500 focus:border-orange-500">{{ old('address', Auth::user()->address) }}</textarea>
                    </div>
                    
                    <!-- Payment Method -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                        <div class="space-y-2">
                            <!-- <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="cod"  class="mr-3">
                                <div>
                                    <span class="font-medium">Cash on Delivery</span>
                                    <p class="text-xs text-gray-500">Pay when you receive the order</p>
                                </div>
                            </label> -->
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" checked value="razorpay" class="mr-3">
                                <div>
                                    <span class="font-medium">Razorpay (Card/UPI/NetBanking)</span>
                                    <p class="text-xs text-gray-500">Pay online securely</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="lg:w-1/3">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-20">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
                    
                    <div class="space-y-3 max-h-96 overflow-y-auto mb-4">
                        @foreach($cart as $item)
                            <div class="flex justify-between text-sm">
                                <div>
                                    <span class="font-medium">{{ $item['name'] }}</span>
                                    <span class="text-gray-600"> x {{ $item['quantity'] }}</span>
                                </div>
                                <span>₹{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="border-t pt-4 space-y-2">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>₹{{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Delivery Fee</span>
                            <span>₹50.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span>GST (5%)</span>
                            <span>₹{{ number_format($total * 0.05, 2) }}</span>
                        </div>
                        <div class="flex justify-between font-bold text-lg pt-2 border-t">
                            <span>Total</span>
                            <span class="text-orange-600">₹{{ number_format($total + 50 + ($total * 0.05), 2) }}</span>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full bg-orange-600 text-white py-3 rounded-lg mt-6 hover:bg-orange-700 transition">
                        Place Order
                    </button>
                    
                    <a href="{{ route('user.cart') }}" class="block text-center mt-4 text-gray-600 hover:text-orange-600">
                        ← Back to Cart
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection