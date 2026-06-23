<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', 'Admin') - {{ config('app.name', 'Fashion Flair') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700;800&family=DM+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="admin-body">
<div class="admin-layout">
    <aside class="admin-sidebar" id="adminSidebar">
        <a href="{{ route('admin.dashboard') }}" class="admin-logo">
            <span class="brand-mark">FF</span>
            <span>Fashion Flair</span>
        </a>

        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="admin-nav-item {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                <span>Products</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="admin-nav-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                <span>Categories</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="admin-nav-item {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                <span>Orders</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="admin-nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <span>Users</span>
            </a>

            <div class="admin-nav-divider"></div>

            <a href="{{ route('home') }}" class="admin-nav-item">
                <span>View Store</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="admin-nav-item">Sign Out</button>
            </form>
        </nav>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <button class="sidebar-toggle" id="sidebarToggle" type="button" aria-label="Toggle admin menu">
                <span></span><span></span><span></span>
            </button>
            <div class="admin-topbar-title">@yield('page-title', 'Dashboard')</div>
            <div class="admin-topbar-user">
                <span class="user-avatar small">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <span>{{ auth()->user()->name }}</span>
            </div>
        </header>

        @if(session('success'))
            <div class="admin-flash success">
                {{ session('success') }}
                <button type="button" aria-label="Dismiss" onclick="this.parentElement.remove()">x</button>
            </div>
        @endif

        @if(session('error'))
            <div class="admin-flash error">
                {{ session('error') }}
                <button type="button" aria-label="Dismiss" onclick="this.parentElement.remove()">x</button>
            </div>
        @endif

        <main class="admin-content">
            @yield('content')
        </main>
    </div>
</div>

<script>
document.getElementById('sidebarToggle')?.addEventListener('click', () => {
    document.getElementById('adminSidebar')?.classList.toggle('open');
});

setTimeout(() => {
    document.querySelectorAll('.admin-flash').forEach((flash) => {
        flash.style.opacity = '0';
        setTimeout(() => flash.remove(), 260);
    });
}, 4200);
</script>

@stack('scripts')
</body>
</html>
