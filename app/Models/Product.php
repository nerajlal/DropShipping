<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'sku', 'short_description', 'description', 'price', 'compare_price',
        'cost_price', 'category_id', 'brand', 'image', 'gallery', 'specifications',
        'stock', 'is_active', 'is_featured', 'supplier_name', 'supplier_sku',
        'supplier_url', 'supplier_price', 'shipping_time', 'weight',
        'views', 'sales_count', 'rating', 'reviews_count',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'supplier_price' => 'decimal:2',
        'gallery' => 'array',
        'specifications' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'rating' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function getDiscountPercentAttribute(): ?int
    {
        if ($this->compare_price && $this->compare_price > $this->price) {
            return round((($this->compare_price - $this->price) / $this->compare_price) * 100);
        }
        return null;
    }

    public function getFormattedPriceAttribute(): string
    {
        return '₹' . number_format($this->price, 0);
    }

    public function getFormattedComparePriceAttribute(): string
    {
        return '₹' . number_format($this->compare_price, 0);
    }
}
