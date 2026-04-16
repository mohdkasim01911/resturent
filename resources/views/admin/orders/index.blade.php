@extends('layouts.admin')

@section('title', 'Manage Orders')

@section('header', 'Order Management')

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500">
        <p class="text-sm text-gray-500">Total Orders</p>
        <p class="text-2xl font-bold">{{ $totalOrders }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-500">
        <p class="text-sm text-gray-500">Pending</p>
        <p class="text-2xl font-bold text-yellow-600">{{ $pendingOrders }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500">
        <p class="text-sm text-gray-500">Processing</p>
        <p class="text-2xl font-bold text-blue-600">{{ $processingOrders }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
        <p class="text-sm text-gray-500">Completed</p>
        <p class="text-2xl font-bold text-green-600">{{ $completedOrders }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-red-500">
        <p class="text-sm text-gray-500">Revenue</p>
        <p class="text-2xl font-bold text-green-600">${{ number_format($totalRevenue, 2) }}</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow mb-6 p-4">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <input type="text" name="search" placeholder="Search by Order ID or Customer" 
               value="{{ request('search') }}" class="px-3 py-2 border rounded-md">
        
        <select name="status" class="px-3 py-2 border rounded-md">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        
        <input type="date" name="date_from" value="{{ request('date_from') }}" placeholder="From Date" class="px-3 py-2 border rounded-md">
        <input type="date" name="date_to" value="{{ request('date_to') }}" placeholder="To Date" class="px-3 py-2 border rounded-md">
        
        <div class="md:col-span-4 flex justify-end space-x-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Filter</button>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400">Reset</a>
            <a href="{{ route('admin.orders.export', request()->query()) }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Export CSV</a>
        </div>
    </form>
</div>

<!-- Orders Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <span class="font-medium text-gray-900">#{{ $order->id }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $order->phone }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-semibold text-gray-900">${{ number_format($order->total_amount, 2) }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <select name="status" onchange="this.form.submit()" 
                                    class="text-xs rounded-full px-2 py-1 border-0 
                                        @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status == 'completed') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $order->created_at->format('d M Y, h:i A') }}
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        No orders found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 border-t">
        {{ $orders->withQueryString()->links() }}
    </div>
</div>
@endsection