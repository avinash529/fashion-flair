@extends('layouts.app')

@section('title', 'Order #' . $order->id)

@section('content')
<section class="section-tight section-band">
    <div class="container">
        <div class="section-header">
            <div>
                <div class="eyebrow">Order #{{ $order->id }}</div>
                <h1 class="section-title">{{ $order->statusLabel() }}</h1>
            </div>
            <a href="{{ route('dashboard') }}" class="btn-secondary">Back to Orders</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="panel reveal-left">
                <h2 class="panel-title">Items</h2>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex gap-4 pb-4 border-b border-gray-200 last:border-b-0">
                            <a href="{{ route('products.show', $item->product->slug) }}" class="cart-item-image">
                                <img src="{{ $item->product->imageUrl() }}" alt="{{ $item->product->name }}">
                            </a>
                            <div class="flex-1">
                                <a href="{{ route('products.show', $item->product->slug) }}" class="font-bold text-lg hover:text-rose-700">{{ $item->product->name }}</a>
                                <p class="text-sm text-gray-600">Qty {{ $item->quantity }}</p>
                                @if($item->size || $item->color)
                                    <p class="text-sm text-gray-600">
                                        @if($item->size) Size: {{ $item->size }} @endif
                                        @if($item->color) Color: {{ $item->color }} @endif
                                    </p>
                                @endif
                                <strong>Rs. {{ number_format($item->total_price, 2) }}</strong>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="panel reveal-left">
                <h2 class="panel-title">Status History</h2>
                <div class="space-y-3">
                    @forelse($order->statusHistories as $history)
                        <div class="border-l-4 border-rose-300 pl-4">
                            <strong>{{ ucfirst($history->status) }}</strong>
                            <p class="text-sm text-gray-600">{{ $history->note ?: 'Status updated.' }}</p>
                            <span class="text-xs text-gray-500">{{ $history->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                    @empty
                        <p class="text-gray-600">No status updates yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <aside class="summary-panel panel reveal-right">
            <h2 class="panel-title">Summary</h2>
            <div class="summary-row">
                <span>Status</span>
                <strong>{{ $order->statusLabel() }}</strong>
            </div>
            <div class="summary-row">
                <span>Subtotal</span>
                <strong>Rs. {{ number_format($order->subtotal, 2) }}</strong>
            </div>
            <div class="summary-row">
                <span>Shipping</span>
                <strong>{{ $order->shipping > 0 ? 'Rs. ' . number_format($order->shipping, 2) : 'Free' }}</strong>
            </div>
            <div class="summary-total">
                <strong>Total</strong>
                <span>Rs. {{ number_format($order->total, 2) }}</span>
            </div>

            <div class="divider"></div>

            <h3 class="font-bold mb-2">Delivery</h3>
            <p class="text-gray-600 leading-relaxed">
                {{ $order->ship_name }}<br>
                {{ $order->ship_phone }}<br>
                {{ $order->ship_line1 }}{{ $order->ship_line2 ? ', ' . $order->ship_line2 : '' }}<br>
                {{ $order->ship_city }}, {{ $order->ship_state }} {{ $order->ship_pincode }}
            </p>
        </aside>
    </div>
</section>
@endsection
