@extends('layouts.admin')

@section('title', 'Food Details')

@section('header', 'Food Details')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Food Image -->
            <div>
                @if($food->image)
                    <img src="{{ asset($food->image) }}" alt="{{ $food->name }}" class="w-full max-w-md rounded-lg shadow">
                @else
                    <div class="w-full max-w-md h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                        <span class="text-gray-400">No Image Available</span>
                    </div>
                @endif
            </div>
            
            <!-- Food Details -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $food->name }}</h2>
                
                <div class="space-y-3">
                    <div>
                        <span class="text-sm font-medium text-gray-500">Category:</span>
                        <span class="ml-2 text-gray-900">{{ $food->category->name }}</span>
                    </div>
                    
                    <div>
                        <span class="text-sm font-medium text-gray-500">Price:</span>
                        <span class="ml-2 text-2xl font-bold text-blue-600">${{ number_format($food->price, 2) }}</span>
                    </div>
                    
                    <div>
                        <span class="text-sm font-medium text-gray-500">Status:</span>
                        <span class="ml-2 px-2 py-1 text-xs rounded-full {{ $food->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $food->is_available ? 'Available' : 'Unavailable' }}
                        </span>
                    </div>
                    
                    <div>
                        <span class="text-sm font-medium text-gray-500">Created At:</span>
                        <span class="ml-2 text-gray-900">{{ $food->created_at->format('d M Y, h:i A') }}</span>
                    </div>
                    
                    <div>
                        <span class="text-sm font-medium text-gray-500">Last Updated:</span>
                        <span class="ml-2 text-gray-900">{{ $food->updated_at->format('d M Y, h:i A') }}</span>
                    </div>
                    
                    <div class="pt-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                        <p class="text-gray-700">{{ $food->description }}</p>
                    </div>
                </div>
                
                <div class="mt-6 flex space-x-3">
                    <a href="{{ route('admin.foods.edit', $food->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Edit Food
                    </a>
                    <form action="{{ route('admin.foods.destroy', $food->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition" 
                                onclick="return confirm('Are you sure you want to delete this food?')">
                            Delete Food
                        </button>
                    </form>
                    <a href="{{ route('admin.foods.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection