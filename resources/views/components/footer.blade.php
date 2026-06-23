<footer class="bg-dark text-white mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <!-- Brand -->
            <div>
                <h3 class="text-2xl font-bold bg-gradient-to-r from-rose-400 to-purple-400 bg-clip-text text-transparent mb-4">FashionFlair</h3>
                <p class="text-gray-400">Wear Your Style. Express Yourself.</p>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="hover:text-rose-400 transition duration-300"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="hover:text-rose-400 transition duration-300"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-rose-400 transition duration-300"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="hover:text-rose-400 transition duration-300"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>

            <!-- Shop -->
            <div>
                <h4 class="font-bold text-rose-400 mb-4">Shop</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('products.index') }}" class="hover:text-rose-400 transition">All Products</a></li>
                    <li><a href="#" class="hover:text-rose-400 transition">New Arrivals</a></li>
                    <li><a href="#" class="hover:text-rose-400 transition">Best Sellers</a></li>
                    <li><a href="#" class="hover:text-rose-400 transition">Sale</a></li>
                </ul>
            </div>

            <!-- Help -->
            <div>
                <h4 class="font-bold text-rose-400 mb-4">Help</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="#" class="hover:text-rose-400 transition">Contact Us</a></li>
                    <li><a href="#" class="hover:text-rose-400 transition">Shipping Info</a></li>
                    <li><a href="#" class="hover:text-rose-400 transition">Returns</a></li>
                    <li><a href="#" class="hover:text-rose-400 transition">Size Guide</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div>
                <h4 class="font-bold text-rose-400 mb-4">Newsletter</h4>
                <p class="text-gray-400 text-sm mb-4">Subscribe to get special offers and updates!</p>
                <form class="flex">
                    <input type="email" placeholder="Your email" class="px-4 py-2 rounded-l text-dark focus:outline-none w-full">
                    <button type="submit" class="px-4 py-2 bg-rose-500 hover:bg-purple-600 transition duration-300 rounded-r font-medium">→</button>
                </form>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center text-gray-400 text-sm">
                <p>&copy; 2026 FashionFlair. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-rose-400 transition">Privacy Policy</a>
                    <a href="#" class="hover:text-rose-400 transition">Terms of Service</a>
                    <a href="#" class="hover:text-rose-400 transition">Cookie Policy</a>
                </div>
            </div>
        </div>
    </div>
</footer>
