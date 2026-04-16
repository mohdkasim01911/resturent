@extends('layouts.admin')

@section('title', 'Order #' . $order->id)

@section('header', 'Order Details')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Order Info -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-semibold">Order Items</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Item</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium">{{ $item->food->name }}</p>
                                    @if($item->portion_name)
                                        <p class="text-sm text-gray-500">Portion: {{ $item->portion_name }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">${{ number_format($item->price, 2) }}</td>
                            <td class="px-6 py-4">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 font-medium">${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-semibold">Subtotal:</td>
                            <td class="px-6 py-4">${{ number_format($order->total_amount - 5, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-semibold">Delivery Fee:</td>
                            <td class="px-6 py-4">$5.00</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-bold text-lg">Total:</td>
                            <td class="px-6 py-4 font-bold text-lg">${{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Sidebar Info -->
    <div class="space-y-6">
        <!-- Status Update -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Update Status</h3>
            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <select name="status" class="w-full px-3 py-2 border rounded-md mb-3">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">Update Status</button>
            </form>
        </div>
        
        <!-- Customer Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Customer Information</h3>
            <div class="space-y-2">
                <p><span class="font-medium">Name:</span> {{ $order->user->name }}</p>
                <p><span class="font-medium">Email:</span> {{ $order->user->email }}</p>
                <p><span class="font-medium">Phone:</span> {{ $order->phone }}</p>
                <p><span class="font-medium">Address:</span> {{ $order->shipping_address }}</p>
            </div>
        </div>
        
        <!-- Order Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Order Information</h3>
            <div class="space-y-2">
                <p><span class="font-medium">Order ID:</span> #{{ $order->id }}</p>
                <p><span class="font-medium">Date:</span> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                <p><span class="font-medium">Status:</span> 
                    <span class="px-2 py-1 text-xs rounded-full 
                        @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                        @elseif($order->status == 'completed') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Actions</h3>
            <div class="space-y-2">
                <a href="{{ route('admin.orders.invoice', $order->id) }}" class="block text-center bg-gray-600 text-white py-2 rounded-md hover:bg-gray-700">
                    Download Invoice
                </a>
                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 text-white py-2 rounded-md hover:bg-red-700">
                        Delete Order
                    </button>
                </form>
                <a href="{{ route('admin.orders.index') }}" class="block text-center bg-gray-300 text-gray-700 py-2 rounded-md hover:bg-gray-400">
                    Back to Orders
                </a>
            </div>
        </div>
    </div>
</div>
@endsection