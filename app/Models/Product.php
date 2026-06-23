<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'offer_percent',
        'category_id', 'brand', 'material', 'gender',
        'image', 'gallery', 'stock_qty', 'is_featured', 'is_active',
    ];

    protected $casts = [
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'offer_percent' => 'float',
        'price' => 'float',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function hasOffer(): bool
    {
        return $this->offer_percent > 0;
    }

    public function discountedPrice(): float
    {
        if ($this->offer_percent <= 0) {
            return round($this->price, 2);
        }
        $discounted = $this->price - ($this->price * $this->offer_percent / 100);
        return round(max($discounted, 0), 2);
    }

    public function imageUrl(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        return asset('images/product-placeholder.svg');
    }

    public function availableSizes(): array
    {
        return $this->variants()->whereNotNull('size')->pluck('size')->unique()->values()->toArray();
    }

    public function availableColors(): array
    {
        return $this->variants()->whereNotNull('color')->pluck('color')->unique()->values()->toArray();
    }

    public function inStock(): bool
    {
        return $this->stock_qty > 0;
    }
}
