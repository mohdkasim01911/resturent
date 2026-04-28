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

  <script>
        // Page load pe automatically execute hoga
        window.addEventListener('load', function() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        // Success
                        let lat = position.coords.latitude;
                        let lng = position.coords.longitude;
                        
                        document.getElementById('locationStatus').innerHTML = 'Location mil gayi!';
                        document.getElementById('locationData').innerHTML = 
                            `<strong>Latitude:</strong> ${lat}<br>
                             <strong>Longitude:</strong> ${lng}`;
                        
                        // Laravel controller me bhejna
                        fetch('{{url("save-location")}}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                latitude: lat,
                                longitude: lng
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Server response:', data);

                             if(data.distance > 5) {
                                window.location.href = '{{ route("save.location.restriction") }}?error=Sorry, we do not deliver to your location.'; 
                            }


                            if(data.success) {
                                document.getElementById('locationStatus').innerHTML = 'Location saved successfully!';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            document.getElementById('locationStatus').innerHTML = 'Server error!';
                        });
                    },
                    function(error) {
                        // Error handling
                        let errorMsg = '';
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMsg = 'Permission deny kar di.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMsg = 'Location unavailable.';
                                break;
                            case error.TIMEOUT:
                                errorMsg = 'Timeout ho gaya.';
                                break;
                        }
                        document.getElementById('locationStatus').innerHTML = 'Error: ' + errorMsg;
                    }
                );
            } else {
                document.getElementById('locationStatus').innerHTML = 'Browser geolocation support nahi karta.';
            }
        });
    </script>


<script>
function carousel() {
    return {
        currentSlide: 0,
        slides: [
            { title: 'Delicious Food Delivered to Your Doorstep', subtitle: 'Order from the best restaurants in town', btnText: 'Order Now' },
            { title: 'Fast & Fresh Delivery', subtitle: 'Hot meals delivered in 30 minutes or less', btnText: 'Explore Menu' },
            { title: 'Special Discounts Every Day', subtitle: 'Get up to 50% off on your first order', btnText: 'Claim Offer' }
        ],
        init() {
            setInterval(() => {
                this.nextSlide();
            }, 5000);
        },
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.slides.length;
        },
        prevSlide() {
            this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
        }
    }
}
</script>
 

</body>
</html>