@extends('layouts.user')

@section('title', 'My Orders')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">My Orders</h1>
    
    @if($orders->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <div class="text-6xl mb-4">📦</div>
            <p class="text-gray-600 text-lg mb-4">You haven't placed any orders yet!</p>
            <a href="{{ route('user.menu') }}" class="bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 inline-block">
                Browse Menu
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Order #{{ $order->id }}</h3>
                                <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-block px-3 py-1 text-sm rounded-full 
                                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                    @elseif($order->status == 'completed') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="border-t border-b py-4 mb-4">
                            @foreach($order->items as $item)
                                <div class="flex justify-between items-center mb-2">
                                    <div>
                                        <span class="font-medium">{{ $item->food->name }}</span>
                                        <span class="text-gray-600 text-sm"> x {{ $item->quantity }}</span>
                                    </div>
                                    <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-600">Delivery to: {{ $order->shipping_address }}</p>
                                <p class="text-sm text-gray-600">Phone: {{ $order->phone }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-gray-900">Total: ${{ number_format($order->total_amount, 2) }}</p>
                                @if(in_array($order->status, ['pending', 'processing']))
                                    <form action="{{ route('user.order.cancel', $order->id) }}" method="POST" class="mt-2">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-700 text-sm" 
                                                onclick="return confirm('Are you sure you want to cancel this order?')">
                                            Cancel Order
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection