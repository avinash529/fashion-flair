@extends('layouts.admin')

@section('page-title', 'Categories')

@section('content')
<div class="section-header">
    <div>
        <div class="eyebrow">Catalog</div>
        <h1 class="text-3xl font-bold">Categories</h1>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn-primary">Add Category</a>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Category</th>
                <th>Slug</th>
                <th>Products</th>
                <th>Status</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <img src="{{ $category->imageUrl() }}" alt="{{ $category->name }}" class="w-14 h-12 object-cover rounded">
                            <div>
                                <strong class="block">{{ $category->name }}</strong>
                                <span class="text-sm text-gray-600">{{ $category->description ? \Illuminate\Support\Str::limit($category->description, 46) : 'No description' }}</span>
                            </div>
                        </div>
                    </td>
                    <td>{{ $category->slug }}</td>
                    <td>{{ $category->products_count ?? 0 }}</td>
                    <td>
                        <span class="badge {{ $category->is_active ? 'badge-success' : 'badge-danger' }}">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="action-row">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="action-btn">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn btn-delete" onclick="return confirm('Delete this category?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-gray-500">No categories found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
