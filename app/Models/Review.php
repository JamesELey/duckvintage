<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'name',
        'email',
        'rating',
        'title',
        'comment',
        'is_verified_purchase',
    ];

    protected $casts = [
        'is_verified_purchase' => 'boolean',
        'rating' => 'integer',
    ];

    /**
     * Get the product that owns the review.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user that wrote the review.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the reviewer name (user name or guest name).
     */
    public function getReviewerNameAttribute(): string
    {
        return $this->user ? $this->user->name : $this->name;
    }

    /**
     * Get bread slices HTML for display (out of 10).
     */
    public function getBreadSlicesAttribute(): string
    {
        $fullSlices = $this->rating;
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
     * Get loaf size based on rating (0.5rem to 2rem).
     */
    public function getLoafSize(): float
    {
        // Scale from 0.5rem (1 slice) to 2rem (10 slices)
        return 0.5 + (($this->rating - 1) / 9) * 1.5;
    }

    /**
     * Get loaf description based on rating.
     */
    public function getLoafDescriptionAttribute(): string
    {
        if ($this->rating >= 9) {
            return 'Almost a Full Loaf!';
        } elseif ($this->rating >= 7) {
            return 'More than Half a Loaf!';
        } elseif ($this->rating == 5) {
            return 'Half a Loaf';
        } elseif ($this->rating >= 3) {
            return 'A Few Slices';
        } else {
            return 'Just Crumbs';
        }
    }
}
