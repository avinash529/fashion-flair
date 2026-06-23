<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Fashion Flair') }} @hasSection('title') - @yield('title') @endif</title>
    <meta name="description" content="@yield('meta_desc', 'Modern clothing collections, curated outfits, and effortless everyday fashion.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700;800&family=DM+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
@if(session('success'))
    <div class="flash flash-success">
        <span>{{ session('success') }}</span>
        <button type="button" aria-label="Dismiss" onclick="this.parentElement.remove()">x</button>
    </div>
@endif

@if(session('error'))
    <div class="flash flash-error">
        <span>{{ session('error') }}</span>
        <button type="button" aria-label="Dismiss" onclick="this.parentElement.remove()">x</button>
    </div>
@endif

<nav class="navbar" id="navbar">
    <div class="nav-inner">
        <a href="{{ route('home') }}" class="nav-brand" aria-label="Fashion Flair home">
            <span class="brand-mark">FF</span>
            <span>Fashion Flair</span>
        </a>

        <div class="nav-links" id="navLinks">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('products.index') }}">Shop</a>
            <a href="{{ route('products.index', ['gender' => 'women']) }}">Women</a>
            <a href="{{ route('products.index', ['gender' => 'men']) }}">Men</a>
            <a href="{{ route('products.index', ['gender' => 'kids']) }}">Kids</a>
        </div>

        <div class="nav-actions">
            <a href="{{ route('cart.index') }}" class="nav-cart" aria-label="Cart">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 8h12l-1 13H7L6 8Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8a3 3 0 0 1 6 0"/>
                </svg>
                @php $cartCount = array_sum(array_column(session('cart', []), 'quantity')); @endphp
                @if($cartCount > 0)
                    <span class="cart-badge">{{ $cartCount }}</span>
                @endif
            </a>

            @auth
                <div class="nav-user-menu">
                    <button class="nav-user-btn" id="userBtn" type="button" aria-label="Account menu">
                        <span class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </button>
                    <div class="user-dropdown" id="userDropdown">
                        <a href="{{ route('dashboard') }}">My Orders</a>
                        <a href="{{ route('profile.edit') }}">Profile</a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}">Admin Panel</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-logout">Sign Out</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="nav-cta">Sign In</a>
            @endauth

            <button class="nav-hamburger" id="hamburger" type="button" aria-label="Open menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>

<main>
    @isset($header)
        <section class="section-tight section-band">
            <div class="container">
                {{ $header }}
            </div>
        </section>
    @endisset

    @isset($slot)
        {{ $slot }}
    @else
        @yield('content')
    @endisset
</main>

<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">
                    <span class="brand-mark">FF</span>
                    <span>Fashion Flair</span>
                </div>
                <p>Curated clothing for confident everyday dressing, with soft textures, polished fits, and easy outfit building.</p>
            </div>
            <div>
                <div class="footer-heading">Shop</div>
                <ul class="footer-links">
                    <li><a href="{{ route('products.index', ['gender' => 'women']) }}">Women</a></li>
                    <li><a href="{{ route('products.index', ['gender' => 'men']) }}">Men</a></li>
                    <li><a href="{{ route('products.index', ['gender' => 'kids']) }}">Kids</a></li>
                    <li><a href="{{ route('products.index') }}">New Arrivals</a></li>
                </ul>
            </div>
            <div>
                <div class="footer-heading">Care</div>
                <ul class="footer-links">
                    <li><a href="{{ route('cart.index') }}">Shopping Bag</a></li>
                    <li><a href="{{ route('dashboard') }}">Orders</a></li>
                    <li><a href="{{ route('profile.edit') }}">Account</a></li>
                </ul>
            </div>
            <div>
                <div class="footer-heading">Contact</div>
                <ul class="footer-links">
                    <li>hello@fashionflair.test</li>
                    <li>Mon-Sat, 10am-6pm</li>
                    <li>India shipping available</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} Fashion Flair. All rights reserved.</span>
            <span>Modern fashion storefront and admin system.</span>
        </div>
    </div>
</footer>

<script>
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    navbar?.classList.toggle('scrolled', window.scrollY > 30);
});

const userBtn = document.getElementById('userBtn');
const userDropdown = document.getElementById('userDropdown');
if (userBtn && userDropdown) {
    userBtn.addEventListener('click', () => userDropdown.classList.toggle('open'));
    document.addEventListener('click', (event) => {
        if (!userBtn.contains(event.target) && !userDropdown.contains(event.target)) {
            userDropdown.classList.remove('open');
        }
    });
}

const hamburger = document.getElementById('hamburger');
const navLinks = document.getElementById('navLinks');
if (hamburger && navLinks) {
    hamburger.addEventListener('click', () => navLinks.classList.toggle('open'));
}

setTimeout(() => {
    document.querySelectorAll('.flash').forEach((flash) => {
        flash.style.opacity = '0';
        flash.style.transform = 'translateY(-6px)';
        setTimeout(() => flash.remove(), 260);
    });
}, 4200);

if ('IntersectionObserver' in window) {
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -30px 0px' });

    document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale').forEach((element) => {
        revealObserver.observe(element);
    });
} else {
    document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale').forEach((element) => {
        element.classList.add('visible');
    });
}
</script>

@stack('scripts')
</body>
</html>
