<article class="product-card reveal">
    <a href="{{ route('products.show', $product->slug) }}" class="product-image" aria-label="View {{ $product->name }}">
        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy">
        @if($product->hasOffer())
            <span class="product-badge">{{ rtrim(rtrim(number_format($product->offer_percent, 2), '0'), '.') }}% OFF</span>
        @elseif($product->is_featured)
            <span class="product-badge">Featured</span>
        @endif
    </a>

    <div class="product-info">
        <p class="product-category">{{ $product->category->name ?? 'Collection' }}</p>
        <a href="{{ route('products.show', $product->slug) }}" class="product-name">{{ $product->name }}</a>

        <div class="product-meta">
            <div class="product-price">
                @if($product->hasOffer())
                    <span class="price-sale">Rs. {{ number_format($product->discountedPrice(), 0) }}</span>
                    <span class="price-original">Rs. {{ number_format($product->price, 0) }}</span>
                @else
                    <span class="price-sale">Rs. {{ number_format($product->price, 0) }}</span>
                @endif
            </div>
        </div>

        <form action="{{ route('cart.add', $product) }}" method="POST">
            @csrf
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="add-to-cart-btn" {{ $product->inStock() ? '' : 'disabled' }}>
                {{ $product->inStock() ? 'Add to Bag' : 'Sold out' }}
            </button>
        </form>
    </div>
</article>
