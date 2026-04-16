@if($food->hasVariants())
    <!-- Variant selection form -->
    <form id="addToCartForm" action="{{ route('user.cart.add', $food->id) }}" method="POST">
        @csrf
        <input type="hidden" name="variant_name" id="selected_variant" value="{{ $food->getDefaultVariant()['name'] ?? '' }}">
        <input type="hidden" name="quantity" value="1">
        <button type="submit" class="w-full bg-orange-600 text-white py-3 rounded-lg hover:bg-orange-700 transition">
            Add to Cart - $<span id="selected_price">{{ number_format(($food->getDefaultVariant()['price'] ?? $food->price), 2) }}</span>
        </button>
    </form>
@else
    <!-- Simple add to cart -->
    <form action="{{ route('user.cart.add', $food->id) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
            <input type="number" name="quantity" value="1" min="1" max="99"
                   class="w-32 px-3 py-2 border border-gray-300 rounded-md">
        </div>
        <button type="submit" class="w-full bg-orange-600 text-white py-3 rounded-lg hover:bg-orange-700 transition">
            Add to Cart - ${{ number_format($food->price, 2) }}
        </button>
    </form>
@endif