@extends('layouts.app')

@section('title', 'Shop')

@section('content')
<section class="section-tight section-band">
    <div class="container">
        <div class="section-header">
            <div>
                <div class="eyebrow">Shop</div>
                <h1 class="section-title">Find your next favorite outfit</h1>
            </div>
            <p class="section-copy">Browse curated clothes by category, style, and price.</p>
        </div>
    </div>
</section>

<section class="section">
    <div class="container shop-layout">
        <aside class="filter-panel panel reveal-left">
            <form method="GET" action="{{ route('products.index') }}">
                <h2 class="panel-title">Filters</h2>

                <div class="field-group">
                    <label for="search">Search</label>
                    <input id="search" type="text" name="search" value="{{ request('search') }}" placeholder="Dress, co-ord, top">
                </div>

                <div class="field-group">
                    <label for="category">Category</label>
                    <select id="category" name="category">
                        <option value="">All categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field-group">
                    <label>Collection</label>
                    @foreach(['women' => 'Women', 'men' => 'Men', 'kids' => 'Kids', 'unisex' => 'Unisex'] as $value => $label)
                        <label class="radio-row">
                            <input type="radio" name="gender" value="{{ $value }}" {{ request('gender') === $value ? 'checked' : '' }}>
                            <span>{{ $label }}</span>
                        </label>
                    @endforeach
                    <label class="radio-row">
                        <input type="radio" name="gender" value="" {{ request('gender') ? '' : 'checked' }}>
                        <span>All</span>
                    </label>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="field-group">
                        <label for="min_price">Min price</label>
                        <input id="min_price" type="number" name="min_price" min="0" value="{{ request('min_price') }}" placeholder="0">
                    </div>
                    <div class="field-group">
                        <label for="max_price">Max price</label>
                        <input id="max_price" type="number" name="max_price" min="0" value="{{ request('max_price') }}" placeholder="5000">
                    </div>
                </div>

                <div class="field-group">
                    <label for="sort_filter">Sort</label>
                    <select id="sort_filter" name="sort">
                        <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>Newest</option>
                        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price low to high</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price high to low</option>
                        <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
                    </select>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="btn-primary flex-1">Apply</button>
                    <a href="{{ route('products.index') }}" class="btn-secondary">Reset</a>
                </div>
            </form>
        </aside>

        <div>
            <div class="section-header" style="margin-bottom: 18px;">
                <p class="text-sm text-gray-600">
                    Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                </p>
                <form method="GET" action="{{ route('products.index') }}" class="w-full sm:w-auto">
                    @foreach(request()->except(['sort', 'page']) as $key => $value)
                        @if($value !== null && $value !== '')
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <select name="sort" onchange="this.form.submit()" aria-label="Sort products">
                        <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>Newest</option>
                        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price low to high</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price high to low</option>
                        <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
                    </select>
                </form>
            </div>

            @if($products->count() > 0)
                <div class="products-grid">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            @else
                <div class="panel text-center reveal">
                    <h2 class="text-3xl font-bold">No products found</h2>
                    <p class="section-copy mx-auto">Try a different category, price range, or search term.</p>
                    <a href="{{ route('products.index') }}" class="btn-primary mt-4">Clear Filters</a>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
