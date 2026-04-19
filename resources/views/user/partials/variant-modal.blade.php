<!-- Variant Selection Modal -->
<div id="variantModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900" id="modalFoodName">Select Variant</h3>
                <button onclick="closeVariantModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div id="variantsList" class="space-y-3 mb-6">
                <!-- Variants will be loaded here -->
            </div>
            
            <div class="flex justify-end space-x-3">
                <button onclick="closeVariantModal()" class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400">Cancel</button>
                <button onclick="addToCartWithVariant()" class="px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700">
                    Add to Cart
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentFoodId = null;
    let selectedVariant = null;
    let currentVariants = [];
    
    // Main function to open modal
    function openVariantModal(foodId, foodName, variants) {
        console.log('Opening modal:', foodId, foodName, variants);
        
        currentFoodId = foodId;
        currentVariants = variants;
        selectedVariant = null;
        
        // Set food name
        document.getElementById('modalFoodName').innerText = foodName;
        
        // Build variants HTML
        const variantsList = document.getElementById('variantsList');
        let html = '';
        
        variants.forEach((variant, index) => {
            html += `
                <div class="variant-item border-2 rounded-lg p-4 cursor-pointer hover:border-orange-500 transition-all" 
                     onclick="selectVariant(${index})">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-semibold text-gray-900">${variant.name}</p>
                            <p class="text-orange-600 font-bold mt-1">₹${parseFloat(variant.price).toFixed(2)}</p>
                        </div>
                        <div class="w-5 h-5 border-2 border-gray-300 rounded-full"></div>
                    </div>
                </div>
            `;
        });
        
        variantsList.innerHTML = html;
        
        // Show modal
        document.getElementById('variantModal').classList.remove('hidden');
        document.getElementById('variantModal').classList.add('flex');
    }
    
    // Select variant function
    function selectVariant(index) {
        selectedVariant = currentVariants[index];
        
        // Update UI - remove selected class from all
        document.querySelectorAll('.variant-item').forEach(item => {
            item.classList.remove('border-orange-500', 'bg-orange-50');
            const radio = item.querySelector('.w-5.h-5');
            if (radio) {
                radio.classList.remove('bg-orange-500', 'border-orange-500');
                radio.classList.add('border-gray-300');
            }
        });
        
        // Add selected class to clicked variant
        const selectedItem = document.querySelectorAll('.variant-item')[index];
        if (selectedItem) {
            selectedItem.classList.add('border-orange-500', 'bg-orange-50');
            const radio = selectedItem.querySelector('.w-5.h-5');
            if (radio) {
                radio.classList.remove('border-gray-300');
                radio.classList.add('bg-orange-500', 'border-orange-500');
            }
        }
        
        console.log('Selected variant:', selectedVariant);
    }
    
    // Add to cart function
    function addToCartWithVariant() {
        if (!selectedVariant) {
            alert('Please select a variant first');
            return;
        }
        
        console.log('Adding to cart:', currentFoodId, selectedVariant);
        
        // Create form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{url('/cart/add/${currentFoodId}')}}`;
        
        // Add CSRF token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
        form.appendChild(csrfInput);
        
        // Add variant name
        const variantInput = document.createElement('input');
        variantInput.type = 'hidden';
        variantInput.name = 'variant_name';
        variantInput.value = selectedVariant.name;
        form.appendChild(variantInput);
        
        // Add quantity
        const quantityInput = document.createElement('input');
        quantityInput.type = 'hidden';
        quantityInput.name = 'quantity';
        quantityInput.value = 1;
        form.appendChild(quantityInput);
        
        document.body.appendChild(form);
        form.submit();
    }
    
    // Close modal function
    function closeVariantModal() {
        document.getElementById('variantModal').classList.add('hidden');
        document.getElementById('variantModal').classList.remove('flex');
        currentFoodId = null;
        selectedVariant = null;
        currentVariants = [];
    }
    
    // Close modal when clicking outside
    document.getElementById('variantModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeVariantModal();
        }
    });
</script>