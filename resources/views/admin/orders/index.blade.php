@extends('layouts.admin')

@section('page-title', 'Orders')

@section('content')
<div class="section-header">
    <div>
        <div class="eyebrow">Sales</div>
        <h1 class="text-3xl font-bold">Orders</h1>
    </div>
    <form method="GET" action="{{ route('admin.orders.index') }}" class="w-full sm:w-64">
        <select name="status" onchange="this.form.submit()" aria-label="Filter by status">
            <option value="">All statuses</option>
            @foreach($statuses as $value => $label)
                <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </form>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Order</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th class="text-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? 'Customer' }}</td>
                    <td>{{ $order->items->count() }}</td>
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
                    <td colspan="7" class="text-center text-gray-500">No orders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-8">
    {{ $orders->links() }}
</div>
@endsection
