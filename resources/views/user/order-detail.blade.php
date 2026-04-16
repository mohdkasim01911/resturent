@extends('layouts.user')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('user.orders') }}" class="text-orange-600 hover:text-orange-700">← Back to Orders</a>
    </div>
    
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
            <div class="flex justify-between items-center text-white">
                <div>
                    <h1 class="text-2xl font-bold">Order #{{ $order->id }}</h1>
                    <p class="text-sm opacity-90">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
                </div>
                <div>
                    <span class="inline-block px-3 py-1 text-sm rounded-full bg-white 
                        @if($order->status == 'pending') text-yellow-600
                        @elseif($order->status == 'processing') text-blue-600
                        @elseif($order->status == 'completed') text-green-600
                        @else text-red-600 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Order Status Timeline -->
        <div class="px-6 py-6 border-b">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Status</h3>
            <div class="flex justify-between">
                <div class="text-center flex-1">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white mx-auto mb-2">✓</div>
                    <p class="text-sm font-medium">Order Placed</p>
                    <p class="text-xs text-gray-500">{{ $order->created_at->format('d M, h:i A') }}</p>
                </div>
                <div class="text-center flex-1">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2 
                        {{ in_array($order->status, ['processing', 'completed']) ? 'bg-green-500' : 'bg-gray-300' }}">
                        {{ in_array($order->status, ['processing', 'completed']) ? '✓' : '●' }}
                    </div>
                    <p class="text-sm font-medium">Processing</p>
                </div>
                <div class="text-center flex-1">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2 
                        {{ $order->status == 'completed' ? 'bg-green-500' : 'bg-gray-300' }}">
                        {{ $order->status == 'completed' ? '✓' : '●' }}
                    </div>
                    <p class="text-sm font-medium">Delivered</p>
                </div>
            </div>
        </div>
        
        <!-- Order Items -->
        <div class="px-6 py-6 border-b">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Items</h3>
            <div class="space-y-3">
                @foreach($order->items as $item)
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-900">{{ $item->food->name }}</p>
                            <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                        </div>
                        <p class="font-medium">${{ number_format($item->price * $item->quantity, 2) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Delivery Details -->
        <div class="px-6 py-6 border-b">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Delivery Details</h3>
            <div class="space-y-2">
                <p><span class="font-medium">Address:</span> {{ $order->shipping_address }}</p>
                <p><span class="font-medium">Phone:</span> {{ $order->phone }}</p>
            </div>
        </div>
        
        <!-- Payment Summary -->
        <div class="px-6 py-6 bg-gray-50">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-lg font-semibold text-gray-900">Total Amount</p>
                    <p class="text-sm text-gray-600">Including all taxes</p>
                </div>
                <p class="text-2xl font-bold text-orange-600">${{ number_format($order->total_amount, 2) }}</p>
            </div>
            
            @if(in_array($order->status, ['pending', 'processing']))
                <div class="mt-4 pt-4 border-t">
                    <form action="{{ route('user.order.cancel', $order->id) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to cancel this order?')">
                        @csrf
                        <button type="submit" class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700">
                            Cancel Order
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection