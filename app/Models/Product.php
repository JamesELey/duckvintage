<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'sku',
        'stock_quantity',
        'images',
        'sizes',
        'colors',
        'category_id',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'images' => 'array',
        'sizes' => 'array',
        'colors' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getCurrentPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->sale_price && $this->sale_price < $this->price) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    /**
     * Get average rating out of 10 (bread slices).
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Get total review count.
     */
    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }

    /**
     * Get bread slices display for average rating.
     */
    public function getBreadSlicesAttribute(): string
    {
        $rating = round($this->average_rating);
        $fullSlices = $rating;
        $emptySlices = 10 - $fullSlices;
        
        $html = '';
        
        // Individual bread slices
        for ($i = 0; $i < $fullSlices; $i++) {
            $html .= '<span style="color: #FFD700; font-size: 1.2rem; margin-right: 2px;">🍞</span>';
        }
        
        // Empty bread slices (lighter)
        for ($i = 0; $i < $emptySlices; $i++) {
            $html .= '<span style="color: #444; font-size: 1.2rem; opacity: 0.3; margin-right: 2px;">🍞</span>';
        }
        
        // Add the loaf representation
        $loafSize = $this->getLoafSize();
        $html .= '<span style="margin-left: 10px; font-size: ' . $loafSize . 'rem;">🍞</span>';
        
        return $html;
    }

    /**
     * Get loaf size based on average rating (0.5rem to 2rem).
     */
    public function getLoafSize(): float
    {
        $rating = round($this->average_rating);
        // Scale from 0.5rem (1 slice) to 2rem (10 slices)
        return 0.5 + (($rating - 1) / 9) * 1.5;
    }
}


