@extends('layouts.admin')

@section('page-title', 'Edit Category')

@section('content')
<form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')

    <div class="section-header">
        <div>
            <div class="eyebrow">Catalog</div>
            <h1 class="text-3xl font-bold">Edit category</h1>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.categories.index') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">Update Category</button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 panel">
            <div class="field-group">
                <label for="name">Category name</label>
                <input id="name" type="text" name="name" value="{{ old('name', $category->name) }}" required>
                @error('name') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="field-group">
                <label for="icon">Short label</label>
                <input id="icon" type="text" name="icon" value="{{ old('icon', $category->icon) }}" maxlength="10">
                @error('icon') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="field-group">
                <label for="description">Description</label>
                <textarea id="description" name="description">{{ old('description', $category->description) }}</textarea>
                @error('description') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <label class="check-row">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                <span>Active on store</span>
            </label>
        </div>

        <aside class="panel">
            <h2 class="panel-title">Image</h2>
            @if($category->image)
                <img src="{{ $category->imageUrl() }}" alt="{{ $category->name }}" class="w-full h-48 object-cover rounded mb-4">
            @endif
            <label class="image-upload-area" id="uploadArea">
                <input type="file" name="image" accept="image/*" class="hidden" id="imageInput">
                <span class="text-center text-gray-600">
                    <strong class="block text-gray-900 mb-1">Replace category image</strong>
                    PNG or JPG up to 2MB
                </span>
                <img id="imagePreview" class="hidden" alt="Category preview">
            </label>
            @error('image') <span class="form-error">{{ $message }}</span> @enderror
        </aside>
    </div>
</form>

@include('admin.products.partials.image-preview-script')
@endsection
