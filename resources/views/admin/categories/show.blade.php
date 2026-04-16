@extends('layouts.admin')

@section('title', 'Category Details')

@section('header', 'Category Details')

@section('content')
<div class="space-y-6">
    <!-- Category Info Card -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white text-2xl">
                        {{ substr($category->name, 0, 1) }}
                    </div>
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h2>
                        <p class="text-gray-600 mt-1">Category ID: #{{ $category->id }}</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Edit Category
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
                                onclick="return confirm('Are you sure you want to delete this category?')">
                            Delete Category
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Category Details Card -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold text-gray-900">Category Information</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Category Name</p>
                    <p class="text-lg font-medium text-gray-900">{{ $category->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Created At</p>
                    <p class="text-lg font-medium text-gray-900">{{ $category->created_at->format('d M Y, h:i A') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Last Updated</p>
                    <p class="text-lg font-medium text-gray-900">{{ $category->updated_at->format('d M Y, h:i A') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Foods</p>
                    <p class="text-lg font-medium text-gray-900">{{ $category->foods->count() }} items</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-sm text-gray-500">Description</p>
                    <p class="text-gray-700 mt-1">{{ $category->description ?? 'No description provided.' }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Foods in this Category -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold text-gray-900">Foods in {{ $category->name }}</h3>
        </div>
        
        @if($category->foods->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Image</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($category->foods as $food)
                        <tr>
                            <td class="px-6 py-4">{{ $food->id }}</td>
                            <td class="px-6 py-4">
                                @if($food->image)
                                    <img src="{{ asset($food->image) }}" alt="{{ $food->name }}" class="w-10 h-10 object-cover rounded">
                                @else
                                    <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">No img</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $food->name }}</td>
                            <td class="px-6 py-4">${{ number_format($food->price, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full {{ $food->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $food->is_available ? 'Available' : 'Unavailable' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.foods.show', $food->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-6 text-center">
                <p class="text-gray-500">No foods found in this category.</p>
                <a href="{{ route('admin.foods.create') }}" class="inline-block mt-2 text-blue-600 hover:text-blue-900">
                    + Add Food to this Category
                </a>
            </div>
        @endif
    </div>
    
    <div class="flex justify-between">
        <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
            ← Back to Categories
        </a>
    </div>
</div>
@endsection