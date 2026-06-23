@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<div class="metric-grid mb-8">
    <div class="metric-card">
        <span>Revenue</span>
        <strong>Rs. {{ number_format($stats['total_revenue'], 2) }}</strong>
    </div>
    <div class="metric-card">
        <span>Orders</span>
        <strong>{{ $stats['total_orders'] }}</strong>
    </div>
    <div class="metric-card">
        <span>Products</span>
        <strong>{{ $stats['total_products'] }}</strong>
    </div>
    <div class="metric-card">
        <span>Customers</span>
        <strong>{{ $stats['total_users'] }}</strong>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <section class="xl:col-span-2">
        <div class="section-header">
            <div>
                <div class="eyebrow">Recent</div>
                <h1 class="text-3xl font-bold">Orders</h1>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="btn-secondary">View All</a>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? 'Customer' }}</td>
                            <td>Rs. {{ number_format($order->total, 2) }}</td>
                            <td>
                                <span class="badge {{ $order->status === 'delivered' ? 'badge-success' : ($order->status === 'cancelled' ? 'badge-danger' : 'badge-warning') }}">
                                    {{ $order->statusLabel() }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="action-btn">Open</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500">No orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section>
        <div class="section-header">
            <div>
                <div class="eyebrow">Inventory</div>
                <h2 class="text-3xl font-bold">Low stock</h2>
            </div>
        </div>

        <div class="panel">
            <div class="space-y-4">
                @forelse($lowStock as $product)
                    <div class="flex items-center justify-between gap-4 pb-4 border-b border-gray-200 last:border-b-0">
                        <div class="flex items-center gap-3">
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="w-12 h-14 object-cover rounded">
                            <div>
                                <strong class="block">{{ \Illuminate\Support\Str::limit($product->name, 28) }}</strong>
                                <span class="text-sm text-gray-600">{{ $product->stock_qty }} left</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.products.edit', $product) }}" class="action-btn">Edit</a>
                    </div>
                @empty
                    <p class="text-gray-600">Inventory looks healthy.</p>
                @endforelse
            </div>
        </div>
    </section>
</div>
@endsection
