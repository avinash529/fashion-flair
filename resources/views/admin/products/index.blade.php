@extends('layouts.admin')

@section('page-title', 'Products')

@section('content')
<div class="section-header">
    <div>
        <div class="eyebrow">Catalog</div>
        <h1 class="text-3xl font-bold">Products</h1>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn-primary">Add Product</a>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="w-12 h-14 object-cover rounded">
                            <div>
                                <strong class="block">{{ \Illuminate\Support\Str::limit($product->name, 36) }}</strong>
                                <span class="text-sm text-gray-600">{{ $product->brand ?: 'Fashion Flair' }}</span>
                            </div>
                        </div>
                    </td>
                    <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                    <td>
                        @if($product->hasOffer())
                            <strong>Rs. {{ number_format($product->discountedPrice(), 2) }}</strong>
                            <span class="block text-sm text-gray-500 line-through">Rs. {{ number_format($product->price, 2) }}</span>
                        @else
                            <strong>Rs. {{ number_format($product->price, 2) }}</strong>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $product->stock_qty > 0 ? 'badge-success' : 'badge-danger' }}">{{ $product->stock_qty }}</span>
                    </td>
                    <td>
                        <span class="badge {{ $product->is_active ? 'badge-success' : 'badge-danger' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="action-row">
                            <a href="{{ route('admin.products.edit', $product) }}" class="action-btn">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn btn-delete" onclick="return confirm('Delete this product?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500">
                        No products found.
                        <a href="{{ route('admin.products.create') }}" class="text-rose-700 font-bold">Add the first product</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-8">
    {{ $products->links() }}
</div>
@endsection
