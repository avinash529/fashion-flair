@extends('layouts.admin')

@section('page-title', 'Edit Product')

@section('content')
@php
    $sizeList = $product->variants->pluck('size')->filter()->unique()->implode(', ');
    $colorList = $product->variants->pluck('color')->filter()->unique()->implode(', ');
@endphp

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')

    <div class="section-header">
        <div>
            <div class="eyebrow">Catalog</div>
            <h1 class="text-3xl font-bold">Edit product</h1>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.products.index') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">Update Product</button>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <div class="xl:col-span-2 panel">
            <h2 class="panel-title">Product details</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="field-group md:col-span-2">
                    <label for="name">Product name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $product->name) }}" required>
                    @error('name') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="field-group">
                    <label for="category_id">Category</label>
                    <select id="category_id" name="category_id" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="field-group">
                    <label for="gender">Collection</label>
                    <select id="gender" name="gender" required>
                        @foreach(['women' => 'Women', 'men' => 'Men', 'kids' => 'Kids', 'unisex' => 'Unisex'] as $value => $label)
                            <option value="{{ $value }}" {{ old('gender', $product->gender) === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('gender') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="field-group">
                    <label for="price">Price</label>
                    <input id="price" type="number" name="price" value="{{ old('price', $product->price) }}" min="0" step="0.01" required>
                    @error('price') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="field-group">
                    <label for="offer_percent">Discount percent</label>
                    <input id="offer_percent" type="number" name="offer_percent" value="{{ old('offer_percent', $product->offer_percent) }}" min="0" max="100" step="0.01">
                    @error('offer_percent') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="field-group">
                    <label for="brand">Brand</label>
                    <input id="brand" type="text" name="brand" value="{{ old('brand', $product->brand) }}">
                    @error('brand') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="field-group">
                    <label for="material">Material</label>
                    <input id="material" type="text" name="material" value="{{ old('material', $product->material) }}">
                    @error('material') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="field-group">
                    <label for="stock_qty">Stock quantity</label>
                    <input id="stock_qty" type="number" name="stock_qty" value="{{ old('stock_qty', $product->stock_qty) }}" min="0" required>
                    @error('stock_qty') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="field-group md:col-span-2">
                    <label for="description">Description</label>
                    <textarea id="description" name="description">{{ old('description', $product->description) }}</textarea>
                    @error('description') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <aside class="space-y-8">
            <div class="panel">
                <h2 class="panel-title">Images</h2>
                @if($product->image)
                    <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="w-full h-56 object-cover rounded mb-4">
                @endif

                <label class="image-upload-area" id="uploadArea">
                    <input type="file" name="image" accept="image/*" class="hidden" id="imageInput">
                    <span class="text-center text-gray-600">
                        <strong class="block text-gray-900 mb-1">Replace main image</strong>
                        PNG or JPG up to 2MB
                    </span>
                    <img id="imagePreview" class="hidden" alt="Product preview">
                </label>
                @error('image') <span class="form-error">{{ $message }}</span> @enderror

                @if($product->gallery)
                    <div class="grid grid-cols-3 gap-2 mt-4">
                        @foreach($product->gallery as $image)
                            <img src="{{ asset('storage/' . $image) }}" alt="Gallery image" class="h-20 w-full object-cover rounded">
                        @endforeach
                    </div>
                @endif

                <div class="field-group mt-4">
                    <label for="gallery_images">Add gallery images</label>
                    <input id="gallery_images" type="file" name="gallery_images[]" accept="image/*" multiple>
                    @error('gallery_images.*') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="panel">
                <h2 class="panel-title">Status</h2>
                <label class="check-row">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                    <span>Featured product</span>
                </label>
                <label class="check-row">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                    <span>Active on store</span>
                </label>
            </div>

            <div class="panel">
                <h2 class="panel-title">Variants</h2>
                <div class="field-group">
                    <label for="sizes">Sizes</label>
                    <input id="sizes" type="text" name="sizes" value="{{ old('sizes', $sizeList) }}">
                </div>
                <div class="field-group">
                    <label for="colors">Colors</label>
                    <input id="colors" type="text" name="colors" value="{{ old('colors', $colorList) }}">
                </div>
                <div class="field-group">
                    <label for="variant_stock">Stock per variant</label>
                    <input id="variant_stock" type="number" name="variant_stock" value="{{ old('variant_stock', 10) }}" min="0">
                </div>
            </div>
        </aside>
    </div>
</form>

@include('admin.products.partials.image-preview-script')
@endsection
