<footer class="bg-gray-900 text-white mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">FoodieHub</h3>
                <p class="text-gray-400">Delicious food delivered to your doorstep</p>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('user.home') }}" class="hover:text-orange-500">Home</a></li>
                    <li><a href="{{ route('user.menu') }}" class="hover:text-orange-500">Menu</a></li>
                    <li><a href="{{ route('user.cart') }}" class="hover:text-orange-500">Cart</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Support</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="#" class="hover:text-orange-500">Contact Us</a></li>
                    <li><a href="#" class="hover:text-orange-500">FAQ</a></li>
                    <li><a href="#" class="hover:text-orange-500">Privacy Policy</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Contact</h4>
                <ul class="space-y-2 text-gray-400">
                    <li>📞 +1 234 567 890</li>
                    <li>✉️ info@foodiehub.com</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; 2024 FoodieHub. All rights reserved.</p>
        </div>
    </div>
</footer>