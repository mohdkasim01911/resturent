@extends('layouts.user')

@section('title', 'My Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- User Info Card -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-center">
                    <div class="w-24 h-24 bg-orange-500 rounded-full flex items-center justify-center text-white text-4xl mx-auto mb-4">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">{{ Auth::user()->name }}</h3>
                    <p class="text-gray-600">{{ Auth::user()->email }}</p>
                    <p class="text-gray-600 mt-2">📞 {{ Auth::user()->phone ?? 'Not provided' }}</p>
                    <div class="mt-4 pt-4 border-t">
                        <a href="{{ route('profile.edit') }}" class="text-orange-600 hover:text-orange-700">Edit Profile →</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="md:col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow p-6 text-white">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm opacity-90">Total Orders</p>
                            <p class="text-3xl font-bold">{{ $totalOrders }}</p>
                        </div>
                        <div class="text-4xl">📦</div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow p-6 text-white">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm opacity-90">Total Spent</p>
                            <p class="text-3xl font-bold">${{ number_format($totalSpent, 2) }}</p>
                        </div>
                        <div class="text-4xl">💰</div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Orders -->
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Orders</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($recentOrders as $order)
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-gray-900">Order #{{ $order->id }}</p>
                                    <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                                    <p class="text-sm mt-1">
                                        <span class="font-medium">Total:</span> ${{ number_format($order->total_amount, 2) }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-block px-2 py-1 text-xs rounded-full 
                                        @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status == 'completed') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <div class="mt-2">
                                        <a href="{{ route('user.order.show', $order->id) }}" class="text-orange-600 hover:text-orange-700 text-sm">
                                            View Details →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center">
                            <p class="text-gray-500">No orders yet!</p>
                            <a href="{{ route('user.menu') }}" class="inline-block mt-2 text-orange-600 hover:text-orange-700">
                                Start Ordering →
                            </a>
                        </div>
                    @endforelse
                </div>
                @if(count($recentOrders) > 0)
                    <div class="px-6 py-4 border-t">
                        <a href="{{ route('user.orders') }}" class="text-orange-600 hover:text-orange-700">
                            View All Orders →
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection