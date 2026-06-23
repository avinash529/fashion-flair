@extends('layouts.app')

@section('title', $product->name)

@section('content')
<section class="section-tight">
    <div class="container">
        <nav class="text-sm text-gray-600 flex flex-wrap gap-2">
            <a href="{{ route('home') }}" class="hover:text-rose-700">Home</a>
            <span>/</span>
            <a href="{{ route('products.index') }}" class="hover:text-rose-700">Shop</a>
            <span>/</span>
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-rose-700">{{ $product->category->name }}</a>
            <span>/</span>
            <span>{{ $product->name }}</span>
        </nav>
    </div>
</section>

<section class="section-tight">
    <div class="container grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
        <div class="reveal-left">
            <div class="gallery-main">
                <img id="mainImage" src="{{ $product->imageUrl() }}" alt="{{ $product->name }}">
            </div>

            @php
                $galleryImages = collect($product->gallery ?? [])->prepend($product->image)->filter()->values();
            @endphp

            @if($galleryImages->count() > 1)
                <div class="gallery-thumbnails">
                    @foreach($galleryImages as $image)
                        <button type="button" class="gallery-thumb {{ $loop->first ? 'active' : '' }}" onclick="changeImage(this)">
                            <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }} image {{ $loop->iteration }}">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="reveal-right">
            <div class="flex flex-wrap gap-2 mb-4">
                <span class="badge badge-primary">{{ $product->category->name }}</span>
                @if($product->hasOffer())
                    <span class="badge badge-danger">{{ rtrim(rtrim(number_format($product->offer_percent, 2), '0'), '.') }}% off</span>
                @endif
                @if($product->is_featured)
                    <span class="badge badge-success">Featured</span>
                @endif
            </div>

            <h1 class="section-title">{{ $product->name }}</h1>

            <div class="product-price my-6">
                @if($product->hasOffer())
                    <span class="price-sale text-3xl">Rs. {{ number_format($product->discountedPrice(), 2) }}</span>
                    <span class="price-original text-lg">Rs. {{ number_format($product->price, 2) }}</span>
                @else
                    <span class="price-sale text-3xl">Rs. {{ number_format($product->price, 2) }}</span>
                @endif
            </div>

            <p class="section-copy">{{ $product->description ?: 'A polished wardrobe piece designed for comfort, movement, and a flattering everyday fit.' }}</p>

            <div class="grid grid-cols-2 gap-4 my-8">
                @if($product->material)
                    <div class="panel">
                        <div class="eyebrow">Material</div>
                        <strong>{{ $product->material }}</strong>
                    </div>
                @endif
                @if($product->brand)
                    <div class="panel">
                        <div class="eyebrow">Brand</div>
                        <strong>{{ $product->brand }}</strong>
                    </div>
                @endif
                <div class="panel">
                    <div class="eyebrow">Stock</div>
                    <strong>{{ $product->stock_qty > 0 ? $product->stock_qty . ' available' : 'Sold out' }}</strong>
                </div>
                <div class="panel">
                    <div class="eyebrow">Collection</div>
                    <strong>{{ ucfirst($product->gender ?? 'unisex') }}</strong>
                </div>
            </div>

            @php
                $sizes = $product->variants->pluck('size')->filter()->unique()->values();
                $colors = $product->variants->pluck('color')->filter()->unique()->values();
            @endphp

            <form action="{{ route('cart.add', $product) }}" method="POST" class="panel">
                @csrf

                @if($sizes->count() > 0)
                    <div class="field-group">
                        <label>Size</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($sizes as $size)
                                <label class="badge badge-primary cursor-pointer">
                                    <input type="radio" name="size" value="{{ $size }}" class="mr-2" {{ $loop->first ? 'checked' : '' }}>
                                    {{ $size }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($colors->count() > 0)
                    <div class="field-group">
                        <label>Color</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($colors as $color)
                                <label class="badge badge-primary cursor-pointer">
                                    <input type="radio" name="color" value="{{ $color }}" class="mr-2" {{ $loop->first ? 'checked' : '' }}>
                                    {{ $color }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row gap-4 items-end">
                    <div>
                        <label class="form-label" for="quantity">Quantity</label>
                        <div class="quantity-control">
                            <button type="button" onclick="decreaseQty()">-</button>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ max(1, $product->stock_qty) }}" readonly>
                            <button type="button" onclick="increaseQty({{ max(1, $product->stock_qty) }})">+</button>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary flex-1 w-full" {{ $product->stock_qty <= 0 ? 'disabled' : '' }}>
                        Add to Bag
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@if($related->count() > 0)
<section class="section section-band">
    <div class="container">
        <div class="section-header">
            <div>
                <div class="eyebrow">More to love</div>
                <h2 class="section-title">You may also like</h2>
            </div>
        </div>
        <div class="products-grid">
            @foreach($related as $item)
                @include('partials.product-card', ['product' => $item])
            @endforeach
        </div>
    </div>
</section>
@endif

<script>
function changeImage(element) {
    const image = element.querySelector('img');
    document.getElementById('mainImage').src = image.src;
    document.querySelectorAll('.gallery-thumb').forEach((thumb) => thumb.classList.remove('active'));
    element.classList.add('active');
}

function increaseQty(max) {
    const qty = document.getElementById('quantity');
    qty.value = Math.min(parseInt(qty.value, 10) + 1, max);
}

function decreaseQty() {
    const qty = document.getElementById('quantity');
    qty.value = Math.max(parseInt(qty.value, 10) - 1, 1);
}
</script>
@endsection
