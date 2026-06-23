<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'offer_percent' => 'nullable|numeric|min:0|max:100',
            'category_id'   => 'required|exists:categories,id',
            'brand'         => 'nullable|string|max:100',
            'material'      => 'nullable|string|max:100',
            'gender'        => 'required|in:women,men,unisex,kids',
            'stock_qty'     => 'required|integer|min:0',
            'is_featured'   => 'boolean',
            'is_active'     => 'boolean',
            'image'         => 'nullable|image|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|max:2048',
        ]);

        unset($data['gallery_images']);

        $data['slug'] = Str::slug($request->name) . '-' . Str::random(5);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active', true);
        $data['offer_percent'] = $request->offer_percent ?? 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('gallery_images')) {
            $data['gallery'] = collect($request->file('gallery_images'))
                ->map(fn($image) => $image->store('products/gallery', 'public'))
                ->values()
                ->all();
        }

        $product = Product::create($data);

        // Handle variants
        if ($request->filled('sizes') || $request->filled('colors')) {
            $sizes  = array_filter(explode(',', $request->input('sizes', '')));
            $colors = array_filter(explode(',', $request->input('colors', '')));

            foreach ($sizes as $size) {
                foreach (($colors ?: ['']) as $color) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'size'       => trim($size),
                        'color'      => trim($color) ?: null,
                        'stock_qty'  => intval($request->input('variant_stock', 10)),
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        $product->load('variants');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'offer_percent' => 'nullable|numeric|min:0|max:100',
            'category_id'   => 'required|exists:categories,id',
            'brand'         => 'nullable|string|max:100',
            'material'      => 'nullable|string|max:100',
            'gender'        => 'required|in:women,men,unisex,kids',
            'stock_qty'     => 'required|integer|min:0',
            'is_featured'   => 'boolean',
            'is_active'     => 'boolean',
            'image'         => 'nullable|image|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|max:2048',
        ]);

        unset($data['gallery_images']);

        $data['is_featured']   = $request->boolean('is_featured');
        $data['is_active']     = $request->boolean('is_active', true);
        $data['offer_percent'] = $request->offer_percent ?? 0;

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('gallery_images')) {
            $newImages = collect($request->file('gallery_images'))
                ->map(fn($image) => $image->store('products/gallery', 'public'))
                ->values()
                ->all();

            $data['gallery'] = array_values(array_merge($product->gallery ?? [], $newImages));
        }

        $product->update($data);

        if ($request->filled('sizes') || $request->filled('colors')) {
            $product->variants()->delete();

            $sizes = array_filter(array_map('trim', explode(',', $request->input('sizes', ''))));
            $colors = array_filter(array_map('trim', explode(',', $request->input('colors', ''))));

            foreach (($sizes ?: ['']) as $size) {
                foreach (($colors ?: ['']) as $color) {
                    if ($size === '' && $color === '') {
                        continue;
                    }

                    ProductVariant::create([
                        'product_id' => $product->id,
                        'size' => $size ?: null,
                        'color' => $color ?: null,
                        'stock_qty' => intval($request->input('variant_stock', 10)),
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        foreach ($product->gallery ?? [] as $image) {
            Storage::disk('public')->delete($image);
        }

        $product->delete();
        return back()->with('success', 'Product deleted.');
    }
}
