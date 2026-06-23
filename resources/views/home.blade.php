@extends('layouts.app')

@section('title', 'Modern Clothing Store')

@section('content')
<section class="hero">
    <div class="hero-content">
        <div class="hero-kicker">New season edit</div>
        <h1>Soft color. Sharp style. Everyday confidence.</h1>
        <p>Explore dresses, co-ords, tops, and polished wardrobe staples curated for effortless outfit building.</p>
        <div class="hero-actions">
            <a href="{{ route('products.index') }}" class="btn-primary">Shop Collection</a>
            <a href="{{ route('products.index', ['gender' => 'women']) }}" class="btn-ghost">Women Edit</a>
        </div>
        <div class="hero-stats">
            <div class="hero-stat">
                <strong>{{ $categories->count() }}+</strong>
                <span>collections</span>
            </div>
            <div class="hero-stat">
                <strong>{{ $featuredProducts->count() }}+</strong>
                <span>featured picks</span>
            </div>
            <div class="hero-stat">
                <strong>COD</strong>
                <span>available</span>
            </div>
        </div>
    </div>
</section>

@if($categories->count() > 0)
<section class="category-strip">
    <div class="container">
        <div class="category-grid">
            @foreach($categories->take(4) as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="category-card reveal-scale">
                    <img src="{{ $category->imageUrl() }}" alt="{{ $category->name }}" loading="lazy">
                    <div>
                        <h3>{{ $category->name }}</h3>
                        <p>{{ $category->description ?: 'Curated wardrobe pieces' }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section">
    <div class="container">
        <div class="section-header">
            <div>
                <div class="eyebrow">Featured</div>
                <h2 class="section-title">The pieces getting attention</h2>
            </div>
            <a href="{{ route('products.index') }}" class="btn-secondary">View All</a>
        </div>

        @if($featuredProducts->count() > 0)
            <div class="products-grid">
                @foreach($featuredProducts as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
        @else
            <div class="panel text-center">
                <h3 class="text-2xl font-bold">No featured products yet</h3>
                <p class="section-copy mx-auto">Add products from the admin panel and mark them as featured to show them here.</p>
            </div>
        @endif
    </div>
</section>

<section class="section section-band">
    <div class="container">
        <div class="section-header">
            <div>
                <div class="eyebrow">New Arrivals</div>
                <h2 class="section-title">Fresh in the boutique</h2>
            </div>
            <p class="section-copy">New textures, flattering fits, and easy separates for days that move from casual plans to evening moments.</p>
        </div>

        @if($newArrivals->count() > 0)
            <div class="products-grid">
                @foreach($newArrivals as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
        @endif
    </div>
</section>

<section class="section-tight">
    <div class="container">
        <div class="feature-row">
            <div class="feature-item reveal">
                <strong>Fast dispatch</strong>
                <span>Orders are prepared quickly with clean product tracking.</span>
            </div>
            <div class="feature-item reveal">
                <strong>Easy checkout</strong>
                <span>Saved addresses, COD payment, and clear order totals.</span>
            </div>
            <div class="feature-item reveal">
                <strong>Quality finish</strong>
                <span>Soft fabric choices, reliable stitching, and polished everyday details.</span>
            </div>
        </div>
    </div>
</section>
@endsection
