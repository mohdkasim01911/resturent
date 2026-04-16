@extends('layouts.admin')

@section('title', 'Add New Food')

@section('header', 'Add New Food')

@section('content')
<div class="bg-white rounded-lg shadow">
    <form action="{{ route('admin.foods.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Food Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Food Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <!-- Category -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                <select name="category_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Variant Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Price Type *</label>
                <select name="variant_type" id="variant_type" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="none">Simple (Single Price)</option>
                    <option value="multiple">Multiple Variants (Half/Quarter/Full)</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Select "Multiple Variants" for items like Pizza, Biryani with different sizes</p>
            </div>
            
            <!-- Simple Price Field -->
            <div id="simple_price_div">
                <label class="block text-sm font-medium text-gray-700 mb-2">Price *</label>
                <input type="number" step="0.01" name="price" value="{{ old('price') }}" placeholder="0.00"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
            
            <!-- Multiple Variants Fields -->
            <div id="variants_div" class="md:col-span-2" style="display: none;">
                <label class="block text-sm font-medium text-gray-700 mb-2">Variants (Sizes & Prices)</label>
                <div id="variants_container">
                    <div class="variant-item grid grid-cols-2 gap-4 mb-3">
                        <input type="text" name="variant_names[]" placeholder="Variant Name (e.g., Half)" 
                               class="px-3 py-2 border border-gray-300 rounded-md">
                        <input type="number" step="0.01" name="variant_prices[]" placeholder="Price" 
                               class="px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="variant-item grid grid-cols-2 gap-4 mb-3">
                        <input type="text" name="variant_names[]" placeholder="Variant Name (e.g., Quarter)" 
                               class="px-3 py-2 border border-gray-300 rounded-md">
                        <input type="number" step="0.01" name="variant_prices[]" placeholder="Price" 
                               class="px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="variant-item grid grid-cols-2 gap-4 mb-3">
                        <input type="text" name="variant_names[]" placeholder="Variant Name (e.g., Full)" 
                               class="px-3 py-2 border border-gray-300 rounded-md">
                        <input type="number" step="0.01" name="variant_prices[]" placeholder="Price" 
                               class="px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                </div>
                <button type="button" onclick="addVariant()" class="mt-2 text-blue-600 hover:text-blue-700">
                    + Add Another Variant
                </button>
                <p class="text-xs text-gray-500 mt-2">Example: Half - ₹149, Quarter - ₹99, Full - ₹249</p>
            </div>
            
            <!-- Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Food Image</label>
                <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
            
            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="is_available" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="1">Available</option>
                    <option value="0">Unavailable</option>
                </select>
            </div>
            
            <!-- Description -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                <textarea name="description" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ old('description') }}</textarea>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.foods.index') }}" class="px-4 py-2 bg-gray-300 rounded-md">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Create Food</button>
        </div>
    </form>
</div>

<script>
    const variantType = document.getElementById('variant_type');
    const simplePriceDiv = document.getElementById('simple_price_div');
    const variantsDiv = document.getElementById('variants_div');
    let variantCount = 3; // Already have 3 variants
    
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
            <input type="text" name="variant_names[]" placeholder="Variant Name" 
                   class="px-3 py-2 border border-gray-300 rounded-md">
            <input type="number" step="0.01" name="variant_prices[]" placeholder="Price" 
                   class="px-3 py-2 border border-gray-300 rounded-md">
        `;
        container.appendChild(newVariant);
        variantCount++;
    }
</script>
@endsection