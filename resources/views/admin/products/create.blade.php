@extends('layouts.admin')

@section('page-title', 'Add Product')

@section('content')
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf

    <div class="section-header">
        <div>
            <div class="eyebrow">Catalog</div>
            <h1 class="text-3xl font-bold">Add product</h1>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.products.index') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">Save Product</button>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <div class="xl:col-span-2 panel">
            <h2 class="panel-title">Product details</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="field-group md:col-span-2">
                    <label for="name">Product name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required placeholder="Rose Satin Midi Dress">
                    @error('name') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="field-group">
                    <label for="category_id">Category</label>
                    <select id="category_id" name="category_id" required>
                        <option value="">Select category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="field-group">
                    <label for="gender">Collection</label>
                    <select id="gender" name="gender" required>
                        <option value="women" {{ old('gender', 'women') === 'women' ? 'selected' : '' }}>Women</option>
                        <option value="men" {{ old('gender') === 'men' ? 'selected' : '' }}>Men</option>
                        <option value="kids" {{ old('gender') === 'kids' ? 'selected' : '' }}>Kids</option>
                        <option value="unisex" {{ old('gender') === 'unisex' ? 'selected' : '' }}>Unisex</option>
                    </select>
                    @error('gender') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="field-group">
                    <label for="price">Price</label>
                    <input id="price" type="number" name="price" value="{{ old('price') }}" min="0" step="0.01" required>
                    @error('price') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="field-group">
                    <label for="offer_percent">Discount percent</label>
                    <input id="offer_percent" type="number" name="offer_percent" value="{{ old('offer_percent', 0) }}" min="0" max="100" step="0.01">
                    @error('offer_percent') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="field-group">
                    <label for="brand">Brand</label>
                    <input id="brand" type="text" name="brand" value="{{ old('brand', 'Fashion Flair') }}">
                    @error('brand') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="field-group">
                    <label for="material">Material</label>
                    <input id="material" type="text" name="material" value="{{ old('material') }}" placeholder="Cotton, satin, linen blend">
                    @error('material') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="field-group">
                    <label for="stock_qty">Stock quantity</label>
                    <input id="stock_qty" type="number" name="stock_qty" value="{{ old('stock_qty', 10) }}" min="0" required>
                    @error('stock_qty') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="field-group md:col-span-2">
                    <label for="description">Description</label>
                    <textarea id="description" name="description">{{ old('description') }}</textarea>
                    @error('description') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <aside class="space-y-8">
            <div class="panel">
                <h2 class="panel-title">Images</h2>
                <label class="image-upload-area" id="uploadArea">
                    <input type="file" name="image" accept="image/*" class="hidden" id="imageInput">
                    <span class="text-center text-gray-600">
                        <strong class="block text-gray-900 mb-1">Main product image</strong>
                        PNG or JPG up to 2MB
                    </span>
                    <img id="imagePreview" class="hidden" alt="Product preview">
                </label>
                @error('image') <span class="form-error">{{ $message }}</span> @enderror

                <div class="field-group mt-4">
                    <label for="gallery_images">Gallery images</label>
                    <input id="gallery_images" type="file" name="gallery_images[]" accept="image/*" multiple>
                    @error('gallery_images.*') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="panel">
                <h2 class="panel-title">Status</h2>
                <label class="check-row">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                    <span>Featured product</span>
                </label>
                <label class="check-row">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <span>Active on store</span>
                </label>
            </div>

            <div class="panel">
                <h2 class="panel-title">Variants</h2>
                <div class="field-group">
                    <label for="sizes">Sizes</label>
                    <input id="sizes" type="text" name="sizes" value="{{ old('sizes', 'XS, S, M, L, XL') }}">
                </div>
                <div class="field-group">
                    <label for="colors">Colors</label>
                    <input id="colors" type="text" name="colors" value="{{ old('colors') }}" placeholder="Blush, Ivory, Sage">
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
