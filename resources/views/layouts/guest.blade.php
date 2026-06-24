<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Fashion Flair') }}</title>
        <meta name="description" content="Sign in to Fashion Flair — your modern fashion destination.">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700;800&family=DM+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="auth-page">
            {{-- Brand Panel --}}
            <div class="auth-brand-panel">
                <div class="auth-shape auth-shape-1"></div>
                <div class="auth-shape auth-shape-2"></div>
                <div class="auth-shape auth-shape-3"></div>
                <div class="auth-shape auth-shape-4"></div>

                <a href="/" class="auth-brand-logo" aria-label="Fashion Flair home">FF</a>
                <h1 class="auth-brand-title">Fashion Flair</h1>
                <p class="auth-brand-tagline">Curated clothing for confident everyday dressing, with soft textures and polished fits.</p>
            </div>

            {{-- Form Panel --}}
            <div class="auth-form-panel">
                <div class="auth-card">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
