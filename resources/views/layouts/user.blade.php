<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Food Ordering System')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- User Navigation -->
    @include('layouts.user-navigation')
    
    <!-- Hero Section (Only for home page) -->
    @if(Route::currentRouteName() == 'user.home')
        @include('layouts.user-hero')
    @endif
    
    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        
        @yield('content')
    </main>

    @include('user.partials.variant-modal')
    
    <!-- Footer -->
    @include('layouts.user-footer')

    <!-- Add this before closing </head> -->
@stack('styles')

<!-- Add this before closing </body> -->
@stack('scripts')
    
    <!-- Cart Count Script -->
    <script>
        function updateCartCount() {
            fetch('/cart/count')
                .then(response => response.json())
                .then(data => {
                    const cartCount = document.getElementById('cart-count');
                    if (cartCount) {
                        cartCount.textContent = data.count;
                    }
                });
        }
    </script>

    <script>
    // Update cart count dynamically
    function updateCartCount() {
        fetch('/cart/count')
            .then(response => response.json())
            .then(data => {
                const cartCount = document.getElementById('cart-count');
                if (cartCount) {
                    cartCount.textContent = data.count;
                    if (data.count > 0) {
                        cartCount.classList.remove('hidden');
                    } else {
                        cartCount.classList.add('hidden');
                    }
                }
            });
    }
    
    // Call on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateCartCount();
    });
</script>

 

</body>
</html>