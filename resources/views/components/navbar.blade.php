<nav class="bg-white shadow-md sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="text-3xl font-bold bg-gradient-to-r from-rose-500 to-purple-600 bg-clip-text text-transparent hover:from-purple-600 hover:to-rose-500 transition duration-300">
                    ✨ FashionFlair
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-dark hover:text-rose-500 font-medium transition duration-300">Home</a>
                <a href="{{ route('products.index') }}" class="text-dark hover:text-rose-500 font-medium transition duration-300">Shop</a>
                <a href="#" class="text-dark hover:text-rose-500 font-medium transition duration-300">About</a>
                <a href="#" class="text-dark hover:text-rose-500 font-medium transition duration-300">Contact</a>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center space-x-6">
                <!-- Search -->
                <div class="hidden lg:block relative">
                    <form action="{{ route('products.index') }}" method="GET" class="flex">
                        <input type="text" name="search" placeholder="Search products..." class="px-4 py-2 rounded-full bg-gray-100 focus:outline-none focus:ring-2 focus:ring-rose-500 transition duration-300 w-48">
                        <button type="submit" class="ml-2 text-rose-500 hover:text-purple-600 transition">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="relative group">
                    <i class="fas fa-shopping-bag text-2xl text-dark group-hover:text-rose-500 transition duration-300"></i>
                    @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-rose-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center group-hover:bg-purple-600 transition duration-300">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <!-- Auth Menu -->
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-dark hover:text-rose-500 transition duration-300">
                            <i class="fas fa-user-circle text-2xl"></i>
                            <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                        </button>
                        <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 animate-fadeIn">
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-dark hover:bg-rose-50 hover:text-rose-500 transition">
                                    <i class="fas fa-cog mr-2"></i> Admin Dashboard
                                </a>
                                <hr class="my-2">
                            @endif
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-dark hover:bg-rose-50 hover:text-rose-500 transition">
                                <i class="fas fa-box mr-2"></i> My Orders
                            </a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-dark hover:bg-rose-50 hover:text-rose-500 transition">
                                <i class="fas fa-user mr-2"></i> Profile
                            </a>
                            <hr class="my-2">
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-dark hover:bg-rose-50 hover:text-rose-500 transition">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-dark hover:text-rose-500 font-medium transition duration-300">Login</a>
                    <a href="{{ route('register') }}" class="px-6 py-2 bg-gradient-to-r from-rose-500 to-purple-600 text-white rounded-full hover:from-purple-600 hover:to-rose-500 font-medium transition duration-300 transform hover:scale-105">Register</a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center space-x-4">
                <button class="text-dark hover:text-rose-500 text-xl">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
</nav>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out;
    }
</style>
