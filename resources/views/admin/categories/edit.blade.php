@extends('layouts.admin')

@section('title', 'Edit Category')

@section('header', 'Edit Category')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl mx-auto">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <!-- Category Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category Name *</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                       placeholder="e.g., Pizza, Burger, Beverages"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Category Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                <textarea name="description" rows="4" 
                          placeholder="Describe what this category is about..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Stats Box -->
            <div class="bg-gray-50 rounded-md p-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Total Foods in Category</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $category->foods()->count() }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Created At</p>
                        <p class="text-sm font-medium text-gray-900">{{ $category->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Warning Box for categories with foods -->
            @if($category->foods()->count() > 0)
                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Note</h3>
                            <div class="mt-1 text-xs text-yellow-700">
                                <p>This category has {{ $category->foods()->count() }} food(s). Deleting this category will not be allowed until all foods are moved or deleted.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Update Category
            </button>
        </div>
    </form>
</div>
@endsection