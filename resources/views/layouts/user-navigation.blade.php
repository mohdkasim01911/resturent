<nav class="bg-white shadow-lg fixed w-full z-50 top-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('user.home') }}" class="text-2xl font-bold text-orange-600">
                    🍛 Al Azhari
                </a>
                
                <div class="hidden md:flex ml-10 space-x-8">
                    <a href="{{ route('user.home') }}" class="text-gray-700 hover:text-orange-600 px-3 py-2 text-sm font-medium">Home</a>
                    <a href="{{ route('user.menu') }}" class="text-gray-700 hover:text-orange-600 px-3 py-2 text-sm font-medium">Menu</a>
                </div>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Search Box -->
                <form action="{{ route('user.menu') }}" method="GET" class="hidden md:block">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Search food..." 
                               class="w-64 px-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:border-orange-500">
                        <button type="submit" class="absolute right-3 top-2 text-gray-400">
                            🔍
                        </button>
                    </div>
                </form>
                
                <!-- Cart -->
                <a href="{{ route('user.cart') }}" class="relative">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6M12 18v3"></path>
                    </svg>
                    <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full px-2 py-1">
                        {{ count(session('cart', [])) }}
                    </span>
                </a>
                
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="text-gray-700">{{ Auth::user()->name }}</span>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                            <a href="{{ route('user.orders') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">My Orders</a>
                            <!-- <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a> -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-600">Login</a>
                    <a href="{{ route('register') }}" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">Sign Up</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Add margin top to body to account for fixed navbar -->
<style>
    body {
        padding-top: 64px;
    }
</style>