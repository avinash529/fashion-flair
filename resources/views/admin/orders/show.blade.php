@extends('layouts.admin')

@section('page-title', 'Order #' . $order->id)

@section('content')
<div class="section-header">
    <div>
        <div class="eyebrow">Order #{{ $order->id }}</div>
        <h1 class="text-3xl font-bold">{{ $order->statusLabel() }}</h1>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn-secondary">Back to Orders</a>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <div class="xl:col-span-2 space-y-8">
        <section class="panel">
            <h2 class="panel-title">Items</h2>
            <div class="admin-table-wrap shadow-none">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $item->product->imageUrl() }}" alt="{{ $item->product->name }}" class="w-12 h-14 object-cover rounded">
                                        <div>
                                            <strong class="block">{{ $item->product->name }}</strong>
                                            <span class="text-sm text-gray-600">
                                                @if($item->size) Size: {{ $item->size }} @endif
                                                @if($item->color) Color: {{ $item->color }} @endif
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rs. {{ number_format($item->unit_price, 2) }}</td>
                                <td>Rs. {{ number_format($item->total_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section class="panel">
            <h2 class="panel-title">Status update</h2>
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @csrf
                @method('PATCH')
                <div class="field-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        @foreach($statuses as $value => $label)
                            <option value="{{ $value }}" {{ $order->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="field-group md:col-span-2">
                    <label for="note">Note</label>
                    <input id="note" type="text" name="note" value="{{ old('note') }}" placeholder="Optional">
                    @error('note') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="md:col-span-3">
                    <button type="submit" class="btn-primary">Update Status</button>
                </div>
            </form>
        </section>

        <section class="panel">
            <h2 class="panel-title">History</h2>
            <div class="space-y-3">
                @forelse($order->statusHistories as $history)
                    <div class="border-l-4 border-rose-300 pl-4">
                        <strong>{{ ucfirst($history->status) }}</strong>
                        <p class="text-sm text-gray-600">{{ $history->note ?: 'Status updated.' }}</p>
                        <span class="text-xs text-gray-500">{{ $history->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                @empty
                    <p class="text-gray-600">No history yet.</p>
                @endforelse
            </div>
        </section>
    </div>

    <aside class="space-y-8">
        <section class="panel">
            <h2 class="panel-title">Customer</h2>
            <strong>{{ $order->user->name ?? $order->ship_name }}</strong>
            <p class="text-gray-600">{{ $order->user->email ?? '' }}</p>
        </section>

        <section class="panel">
            <h2 class="panel-title">Delivery</h2>
            <p class="text-gray-600 leading-relaxed">
                {{ $order->ship_name }}<br>
                {{ $order->ship_phone }}<br>
                {{ $order->ship_line1 }}{{ $order->ship_line2 ? ', ' . $order->ship_line2 : '' }}<br>
                {{ $order->ship_city }}, {{ $order->ship_state }} {{ $order->ship_pincode }}
            </p>
        </section>

        <section class="panel">
            <h2 class="panel-title">Totals</h2>
            <div class="summary-row"><span>Subtotal</span><strong>Rs. {{ number_format($order->subtotal, 2) }}</strong></div>
            <div class="summary-row"><span>Shipping</span><strong>{{ $order->shipping > 0 ? 'Rs. ' . number_format($order->shipping, 2) : 'Free' }}</strong></div>
            <div class="summary-total"><strong>Total</strong><span>Rs. {{ number_format($order->total, 2) }}</span></div>
        </section>
    </aside>
</div>
@endsection
