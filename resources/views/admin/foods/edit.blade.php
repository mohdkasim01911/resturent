@extends('layouts.admin')

@section('title', 'Edit Food')

@section('header', 'Edit Food')

@section('content')
<div class="bg-white rounded-lg shadow">
    <form action="{{ route('admin.foods.update', $food->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Food Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Food Name *</label>
                <input type="text" name="name" value="{{ old('name', $food->name) }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <!-- Category -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                <select name="category_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $food->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Variant Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Price Type *</label>
                <select name="variant_type" id="variant_type" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="none" {{ $food->variant_type == 'none' ? 'selected' : '' }}>Simple (Single Price)</option>
                    <option value="multiple" {{ $food->variant_type == 'multiple' ? 'selected' : '' }}>Multiple Variants (Half/Quarter/Full)</option>
                </select>
            </div>
            
            <!-- Simple Price Field -->
            <div id="simple_price_div" style="{{ $food->variant_type == 'multiple' ? 'display: none;' : '' }}">
                <label class="block text-sm font-medium text-gray-700 mb-2">Price *</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $food->price) }}" placeholder="0.00"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
            
            <!-- Multiple Variants Fields -->
            <div id="variants_div" class="md:col-span-2" style="{{ $food->variant_type == 'none' ? 'display: none;' : '' }}">
                <label class="block text-sm font-medium text-gray-700 mb-2">Variants (Sizes & Prices)</label>
                <div id="variants_container">
                    @php
                        // Parse variants JSON to array
                        $variantsArray = [];
                        if($food->variants) {
                            if(is_string($food->variants)) {
                                $variantsArray = json_decode(json_decode($food->variants, true),true);
                            } elseif(is_array($food->variants)) {
                                $variantsArray = $food->variants;
                            }
                        }
                    @endphp
                    
                    @if(!empty($variantsArray) && count($variantsArray) > 0)
                        @foreach($variantsArray as $index => $variant)
                            <div class="variant-item grid grid-cols-2 gap-4 mb-3">
                                <input type="text" name="variant_names[]" value="{{ $variant['name'] }}" 
                                       placeholder="Variant Name (e.g., Half)" 
                                       class="px-3 py-2 border border-gray-300 rounded-md">
                                <input type="number" step="0.01" name="variant_prices[]" value="{{ $variant['price'] }}" 
                                       placeholder="Price" 
                                       class="px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                        @endforeach
                    @else
                        <div class="variant-item grid grid-cols-2 gap-4 mb-3">
                            <input type="text" name="variant_names[]" placeholder="Half" 
                                   class="px-3 py-2 border border-gray-300 rounded-md">
                            <input type="number" step="0.01" name="variant_prices[]" placeholder="Price" 
                                   class="px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div class="variant-item grid grid-cols-2 gap-4 mb-3">
                            <input type="text" name="variant_names[]" placeholder="Quarter" 
                                   class="px-3 py-2 border border-gray-300 rounded-md">
                            <input type="number" step="0.01" name="variant_prices[]" placeholder="Price" 
                                   class="px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div class="variant-item grid grid-cols-2 gap-4 mb-3">
                            <input type="text" name="variant_names[]" placeholder="Full" 
                                   class="px-3 py-2 border border-gray-300 rounded-md">
                            <input type="number" step="0.01" name="variant_prices[]" placeholder="Price" 
                                   class="px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                    @endif
                </div>
                <button type="button" onclick="addVariant()" class="mt-2 text-blue-600 hover:text-blue-700">
                    + Add Another Variant
                </button>
            </div>
            
            <!-- Current Image -->
            @if($food->image)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                <img src="{{ asset($food->image) }}" alt="{{ $food->name }}" class="w-32 h-32 object-cover rounded">
            </div>
            @endif
            
            <!-- New Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Change Image</label>
                <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
            
            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="is_available" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="1" {{ $food->is_available ? 'selected' : '' }}>Available</option>
                    <option value="0" {{ !$food->is_available ? 'selected' : '' }}>Unavailable</option>
                </select>
            </div>
            
            <!-- Description -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                <textarea name="description" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ old('description', $food->description) }}</textarea>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.foods.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update Food</button>
        </div>
    </form>
</div>

<script>
    const variantType = document.getElementById('variant_type');
    const simplePriceDiv = document.getElementById('simple_price_div');
    const variantsDiv = document.getElementById('variants_div');
    
    variantType.addEventListener('change', function() {
        if (this.value === 'multiple') {
            simplePriceDiv.style.display = 'none';
            variantsDiv.style.display = 'block';
        } else {
            simplePriceDiv.style.display = 'block';
            variantsDiv.style.display = 'none';
        }
    });
    
    function addVariant() {
        const container = document.getElementById('variants_container');
        const newVariant = document.createElement('div');
        newVariant.className = 'variant-item grid grid-cols-2 gap-4 mb-3';
        newVariant.innerHTML = `
            <input type="text" name="variant_names[]" placeholder="New Variant Name" 
                   class="px-3 py-2 border border-gray-300 rounded-md">
            <input type="number" step="0.01" name="variant_prices[]" placeholder="Price" 
                   class="px-3 py-2 border border-gray-300 rounded-md">
        `;
        container.appendChild(newVariant);
    }
</script>
@endsection