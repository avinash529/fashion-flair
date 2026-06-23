@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<section class="section-tight section-band">
    <div class="container">
        <div class="section-header">
            <div>
                <div class="eyebrow">Account</div>
                <h1 class="section-title">My orders</h1>
            </div>
            <a href="{{ route('products.index') }}" class="btn-secondary">Shop More</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        @if($orders->count() > 0)
            <div class="grid gap-4">
                @foreach($orders as $order)
                    <article class="order-card panel reveal">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <div class="flex flex-wrap gap-2 mb-2">
                                    <span class="badge badge-primary">Order #{{ $order->id }}</span>
                                    <span class="badge {{ $order->status === 'delivered' ? 'badge-success' : ($order->status === 'cancelled' ? 'badge-danger' : 'badge-warning') }}">
                                        {{ $order->statusLabel() }}
                                    </span>
                                </div>
                                <h2 class="text-xl font-bold">{{ $order->items->count() }} item(s)</h2>
                                <p class="text-gray-600">{{ $order->created_at->format('M d, Y') }} - Rs. {{ number_format($order->total, 2) }}</p>
                            </div>
                            <a href="{{ route('orders.show', $order) }}" class="btn-secondary">View Details</a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @else
            <div class="panel text-center reveal">
                <h2 class="text-3xl font-bold">No orders yet</h2>
                <p class="section-copy mx-auto">Your placed orders will appear here with status updates.</p>
                <a href="{{ route('products.index') }}" class="btn-primary mt-4">Start Shopping</a>
            </div>
        @endif
    </div>
</section>
@endsection
