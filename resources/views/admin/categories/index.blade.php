@extends('layouts.admin')

@section('title', 'Manage Categories')

@section('header', 'Category Management')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b flex justify-between items-center">
        <h3 class="text-lg font-semibold">All Categories</h3>
        <a href="{{ route('admin.categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            + Add New Category
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Foods</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($categories as $category)
                <tr>
                    <td class="px-6 py-4">{{ $category->id }}</td>
                    <td class="px-6 py-4 font-medium">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white text-sm mr-2">
                                {{ substr($category->name, 0, 1) }}
                            </div>
                            {{ $category->name }}
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ Str::limit($category->description, 50) ?? 'No description' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                            {{ $category->foods_count }} Foods
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $category->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.categories.show', $category->id) }}" class="text-green-600 hover:text-green-900 mr-3">View</a>
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" 
                                    onclick="return confirm('Are you sure you want to delete this category?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            No categories found. 
                            <a href="{{ route('admin.categories.create') }}" class="text-blue-600 hover:text-blue-900">Create your first category</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4">
        {{ $categories->links() }}
    </div>
</div>
@endsection