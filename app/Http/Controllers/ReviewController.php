<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a new review.
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:10',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'title' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
        ]);

        // For logged-in users, use their email if not provided
        $email = $request->email;
        if (auth()->check() && !$email) {
            $email = auth()->user()->email;
        }

        // Check if email already reviewed this product
        if ($email) {
            $existingReview = Review::where('product_id', $product->id)
                ->where('email', $email)
                ->first();

            if ($existingReview) {
                return back()->withErrors(['review' => 'This email has already reviewed this product.']);
            }
        }

        // Check if user is logged in and has purchased this product
        $hasPurchased = false;
        if (auth()->check()) {
            $hasPurchased = auth()->user()->orders()
                ->whereHas('items', function($query) use ($product) {
                    $query->where('product_id', $product->id);
                })
                ->where('status', 'completed')
                ->exists();
        }

        Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(), // null for guests
            'name' => $request->name,
            'email' => $email,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'is_verified_purchase' => $hasPurchased,
        ]);

        return back()->with('success', 'Thank you for your review!');
    }

    /**
     * Update an existing review.
     */
    public function update(Request $request, Review $review)
    {
        // Check if user owns this review
        if ($review->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:10',
            'title' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
        ]);

        $review->update([
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review updated successfully!');
    }

    /**
     * Delete a review.
     */
    public function destroy(Review $review)
    {
        // Check if user owns this review or is admin
        if ($review->user_id !== auth()->id() && !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $review->delete();

        return back()->with('success', 'Review deleted successfully!');
    }
}
