@extends('layouts.app')

@section('title', 'Shopping Bag')

@section('content')
<section class="section-tight section-band">
    <div class="container">
        <div class="section-header">
            <div>
                <div class="eyebrow">Bag</div>
                <h1 class="section-title">Your shopping bag</h1>
            </div>
            <a href="{{ route('products.index') }}" class="btn-secondary">Continue Shopping</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        @if(empty($items))
            <div class="panel text-center reveal">
                <h2 class="text-3xl font-bold">Your bag is empty</h2>
                <p class="section-copy mx-auto">Add a dress, co-ord, top, or wardrobe staple to begin checkout.</p>
                <a href="{{ route('products.index') }}" class="btn-primary mt-4">Shop Now</a>
            </div>
        @else
            @php
                $shipping = $total >= 999 ? 0 : 99;
                $grandTotal = $total + $shipping;
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 panel p-0 overflow-hidden reveal-left">
                    @foreach($items as $key => $item)
                        @php($product = $item['product'])
                        <div class="cart-item">
                            <a href="{{ route('products.show', $product->slug) }}" class="cart-item-image">
                                <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}">
                            </a>

                            <div>
                                <p class="product-category">{{ $product->category->name ?? 'Collection' }}</p>
                                <a href="{{ route('products.show', $product->slug) }}" class="font-bold text-lg hover:text-rose-700">{{ $product->name }}</a>
                                @if(($item['size'] ?? null) || ($item['color'] ?? null))
                                    <p class="text-sm text-gray-600 mt-1">
                                        @if($item['size']) Size: {{ $item['size'] }} @endif
                                        @if($item['color']) Color: {{ $item['color'] }} @endif
                                    </p>
                                @endif
                                <div class="product-price mt-3">
                                    <span class="price-sale">Rs. {{ number_format($item['unit_price'], 2) }}</span>
                                    <span class="text-sm text-gray-500">Line total: Rs. {{ number_format($item['total_price'], 2) }}</span>
                                </div>
                            </div>

                            <div class="cart-item-actions">
                                <form action="{{ route('cart.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="key" value="{{ $key }}">
                                    <div class="quantity-control">
                                        <button type="button" onclick="changeCartQty(this, -1)">-</button>
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ max(1, $product->stock_qty) }}" readonly>
                                        <button type="button" onclick="changeCartQty(this, 1)">+</button>
                                    </div>
                                </form>

                                <form action="{{ route('cart.remove') }}" method="POST" class="mt-3 text-right">
                                    @csrf
                                    <input type="hidden" name="key" value="{{ $key }}">
                                    <button type="submit" class="remove-btn">Remove</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <aside class="summary-panel panel reveal-right">
                    <h2 class="panel-title">Order Summary</h2>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <strong>Rs. {{ number_format($total, 2) }}</strong>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <strong>{{ $shipping === 0 ? 'Free' : 'Rs. ' . number_format($shipping, 2) }}</strong>
                    </div>
                    <div class="summary-total">
                        <strong>Total</strong>
                        <span>Rs. {{ number_format($grandTotal, 2) }}</span>
                    </div>

                    @auth
                        <a href="{{ route('checkout.index') }}" class="btn-primary w-full mt-6">Checkout</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary w-full mt-6">Sign In to Checkout</a>
                    @endauth

                    <form action="{{ route('cart.clear') }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="btn-danger w-full">Clear Bag</button>
                    </form>
                </aside>
            </div>
        @endif
    </div>
</section>

<script>
function changeCartQty(button, delta) {
    const form = button.closest('form');
    const input = form.querySelector('input[name="quantity"]');
    const min = parseInt(input.min, 10);
    const max = parseInt(input.max, 10);
    input.value = Math.min(max, Math.max(min, parseInt(input.value, 10) + delta));
    form.submit();
}
</script>
@endsection
