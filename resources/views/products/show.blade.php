@extends('layouts.app')

@section('title', $product->name . ' - Duck Vintage')

@section('content')
<div class="container">
    <div class="grid grid-2" style="gap: 3rem;">
        <!-- Product Images -->
        <div>
            @if($product->images && count($product->images) > 0)
                <div style="margin-bottom: 1rem;">
                    <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" style="width: 100%; height: 400px; object-fit: cover; border-radius: 8px;">
                </div>
                @if(count($product->images) > 1)
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        @foreach($product->images as $image)
                            <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; cursor: pointer;" onclick="changeMainImage(this.src)">
                        @endforeach
                    </div>
                @endif
            @else
                <div style="width: 100%; height: 400px; background-color: #333; display: flex; align-items: center; justify-content: center; color: #FFD700; border-radius: 8px;">
                    No Image Available
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div>
            <h1 style="font-size: 2rem; margin-bottom: 1rem;">{{ $product->name }}</h1>
            <p style="color: #CCC; margin-bottom: 1rem;">{{ $product->category->name }}</p>
            
            <div style="margin-bottom: 1rem;">
                @if($product->sale_price)
                    <span style="font-size: 1.5rem; color: #FF6B6B; text-decoration: line-through; margin-right: 0.5rem;">${{ number_format($product->price, 2) }}</span>
                    <span style="font-size: 2rem; font-weight: bold; color: #FFD700;">${{ number_format($product->sale_price, 2) }}</span>
                    <span style="color: #FF6B6B; margin-left: 0.5rem;">{{ $product->discount_percentage }}% OFF</span>
                @else
                    <span style="font-size: 2rem; font-weight: bold; color: #FFD700;">${{ number_format($product->price, 2) }}</span>
                @endif
            </div>

            <div style="margin-bottom: 2rem;">
                <p>{{ $product->description }}</p>
            </div>

            @if($product->stock_quantity > 0)
                <form method="POST" action="{{ route('cart.add') }}" style="margin-bottom: 2rem;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div class="form-group">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="form-control" style="width: 100px;">
                    </div>

                    @if($product->sizes && count($product->sizes) > 0)
                        <div class="form-group">
                            <label class="form-label">Size</label>
                            <select name="size" class="form-control" style="width: 150px;">
                                <option value="">Select Size</option>
                                @foreach($product->sizes as $size)
                                    <option value="{{ $size }}">{{ $size }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    @if($product->colors && count($product->colors) > 0)
                        <div class="form-group">
                            <label class="form-label">Color</label>
                            <select name="color" class="form-control" style="width: 150px;">
                                <option value="">Select Color</option>
                                @foreach($product->colors as $color)
                                    <option value="{{ $color }}">{{ $color }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <button type="submit" class="btn" style="font-size: 1.1rem; padding: 1rem 2rem;">Add to Cart</button>
                </form>
            @else
                <div style="padding: 1rem; background-color: #4d1a1a; border: 1px solid #7a2d2d; border-radius: 4px; margin-bottom: 2rem;">
                    <p style="color: #FFB6C1; margin: 0;">This product is currently out of stock.</p>
                </div>
            @endif

            <div style="border-top: 1px solid #333; padding-top: 1rem;">
                <p style="color: #CCC; margin-bottom: 0.5rem;"><strong>SKU:</strong> {{ $product->sku }}</p>
                <p style="color: #CCC;"><strong>Stock:</strong> {{ $product->stock_quantity }} available</p>
            </div>
        </div>
    </div>

    <!-- Reviews Section (Bread Slices System 🍞) -->
    <div style="margin-top: 4rem; padding-top: 4rem; border-top: 2px solid #333;">
        <h2 style="margin-bottom: 2rem;">Customer Reviews</h2>
        
        <!-- Average Rating Summary -->
        <div style="background-color: #1a1a1a; padding: 2rem; border-radius: 8px; margin-bottom: 2rem;">
            <div style="display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;">
                <div>
                    <div style="font-size: 3rem; font-weight: bold; color: #FFD700;">{{ number_format($product->average_rating, 1) }}</div>
                    <div style="color: #999; font-size: 0.9rem;">out of 10 slices</div>
                </div>
                <div style="flex: 1;">
                    <div style="margin-bottom: 0.5rem;">{!! $product->bread_slices !!}</div>
                    <div style="color: #999;">{{ $product->review_count }} {{ Str::plural('review', $product->review_count) }}</div>
                    @php
                        $avgRating = round($product->average_rating);
                        $loafDescription = '';
                        if ($avgRating >= 9) {
                            $loafDescription = 'Almost a Full Loaf! 🍞';
                        } elseif ($avgRating >= 7) {
                            $loafDescription = 'More than Half a Loaf! 🍞';
                        } elseif ($avgRating == 5) {
                            $loafDescription = 'Half a Loaf 🍞';
                        } elseif ($avgRating >= 3) {
                            $loafDescription = 'A Few Slices 🍞';
                        } else {
                            $loafDescription = 'Just Crumbs 🍞';
                        }
                    @endphp
                    <div style="color: #FFD700; margin-top: 0.5rem;">{{ $loafDescription }}</div>
                </div>
            </div>
        </div>

        <!-- Write a Review Form -->
        @php
            $userReview = null;
            if (auth()->check()) {
                $userReview = $product->reviews()->where('user_id', auth()->id())->first();
            }
        @endphp
        
        @if(!$userReview)
            <div class="card" style="margin-bottom: 3rem;">
                <div class="card-header">
                    <h3>Write a Review 🍞</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('reviews.store', $product) }}">
                        @csrf
                        
                        @guest
                            <div class="form-group">
                                <label class="form-label">Your Name *</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                                @error('name')
                                    <div class="alert alert-error">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Your Email *</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                                @error('email')
                                    <div class="alert alert-error">{{ $message }}</div>
                                @enderror
                            </div>
                        @else
                            <div class="form-group">
                                <label class="form-label">Your Name *</label>
                                <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" readonly style="background-color: #333; color: #999;">
                                <small style="color: #999;">Using your account name</small>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Your Email</label>
                                <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" readonly style="background-color: #333; color: #999;">
                                <small style="color: #999;">Using your account email</small>
                            </div>
                        @endguest
                        
                        <div class="form-group">
                            <label class="form-label">Rating (Bread Slices out of 10) *</label>
                            <div style="display: flex; gap: 0.5rem; align-items: center; margin-top: 0.5rem;">
                                @for($i = 1; $i <= 10; $i++)
                                    <label style="cursor: pointer; font-size: 2rem;">
                                        <input type="radio" name="rating" value="{{ $i }}" required style="display: none;" onchange="updateBreadPreview({{ $i }})">
                                        <span class="bread-slice" data-value="{{ $i }}" style="opacity: 0.3; transition: opacity 0.2s;">🍞</span>
                                    </label>
                                @endfor
                            </div>
                            <div id="ratingText" style="color: #FFD700; margin-top: 0.5rem; font-weight: bold;"></div>
                            @error('rating')
                                <div class="alert alert-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Review Title (optional)</label>
                            <input type="text" name="title" class="form-control" placeholder="Sum up your experience">
                            @error('title')
                                <div class="alert alert-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Your Review (optional)</label>
                            <textarea name="comment" class="form-control" rows="5" placeholder="Share your thoughts about this product..."></textarea>
                            @error('comment')
                                <div class="alert alert-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn">Submit Review</button>
                    </form>
                </div>
            </div>
        @else
            <div style="background-color: #1a4d1a; border: 1px solid #2d7a2d; color: #90EE90; padding: 1rem; border-radius: 4px; margin-bottom: 3rem;">
                <strong>You've already reviewed this product!</strong> Your feedback helps others make better decisions. 🍞
            </div>
        @endif

        <!-- Display Reviews -->
        @if($product->reviews->count() > 0)
            <div style="margin-top: 3rem;">
                <h3 style="margin-bottom: 2rem;">All Reviews ({{ $product->reviews->count() }})</h3>
                @foreach($product->reviews()->latest()->get() as $review)
                    <div class="card" style="margin-bottom: 1.5rem;">
                        <div class="card-body">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                                <div>
                                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                                        <strong>{{ $review->reviewer_name }}</strong>
                                        @if($review->is_verified_purchase)
                                            <span style="background-color: #1a4d1a; color: #90EE90; padding: 0.25rem 0.75rem; border-radius: 4px; font-size: 0.8rem;">✓ Verified Purchase</span>
                                        @endif
                                    </div>
                                    <div style="margin-bottom: 0.5rem;">
                                        {!! $review->bread_slices !!}
                                        <span style="color: #FFD700; margin-left: 0.5rem; font-weight: bold;">{{ $review->rating }}/10 slices</span>
                                    </div>
                                    @if($review->title)
                                        <h4 style="color: #FFD700; margin-bottom: 0.5rem;">{{ $review->title }}</h4>
                                    @endif
                                </div>
                                <div style="text-align: right;">
                                    <div style="color: #999; font-size: 0.9rem;">{{ $review->created_at->diffForHumans() }}</div>
                                    @auth
                                        @if($review->user_id === auth()->id() || auth()->user()->hasRole('admin'))
                                            <form method="POST" action="{{ route('reviews.destroy', $review) }}" style="display: inline; margin-top: 0.5rem;" onsubmit="return confirm('Are you sure you want to delete this review?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background: none; border: none; color: #FF6B6B; cursor: pointer; font-size: 0.9rem; text-decoration: underline;">Delete</button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                            @if($review->comment)
                                <p style="line-height: 1.6; color: #ddd;">{{ $review->comment }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 3rem; color: #999;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🍞</div>
                <p>No reviews yet. Be the first to share your thoughts!</p>
            </div>
        @endif
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div style="margin-top: 4rem;">
            <h2 style="margin-bottom: 2rem;">Related Products</h2>
            <div class="grid grid-4">
                @foreach($relatedProducts as $relatedProduct)
                <div class="product-card">
                    <a href="{{ route('products.show', $relatedProduct) }}" style="text-decoration: none; color: inherit;">
                        @if($relatedProduct->images && count($relatedProduct->images) > 0)
                            <img src="{{ asset('storage/' . $relatedProduct->images[0]) }}" alt="{{ $relatedProduct->name }}" class="product-image">
                        @else
                            <div class="product-image" style="background-color: #333; display: flex; align-items: center; justify-content: center; color: #FFD700;">
                                No Image
                            </div>
                        @endif
                        <div class="product-info">
                            <h3 class="product-title">{{ $relatedProduct->name }}</h3>
                            <div class="product-price">
                                @if($relatedProduct->sale_price)
                                    <span class="product-sale-price">${{ number_format($relatedProduct->price, 2) }}</span>
                                    ${{ number_format($relatedProduct->sale_price, 2) }}
                                @else
                                    ${{ number_format($relatedProduct->price, 2) }}
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
function changeMainImage(src) {
    document.querySelector('.product-image').src = src;
}

// Bread slice rating system
function updateBreadPreview(rating) {
    const slices = document.querySelectorAll('.bread-slice');
    const ratingText = document.getElementById('ratingText');
    
    // Update slice opacity
    slices.forEach(slice => {
        const value = parseInt(slice.getAttribute('data-value'));
        slice.style.opacity = value <= rating ? '1' : '0.3';
    });
    
        // Update rating text with loaf descriptions
        const descriptions = {
            1: '1/10 slices - Just Crumbs 🍞',
            2: '2/10 slices - A Few Crumbs 🍞',
            3: '3/10 slices - A Few Slices 🍞',
            4: '4/10 slices - Getting Better 🍞',
            5: '5/10 slices - Half a Loaf 🍞',
            6: '6/10 slices - More than Half! 🍞',
            7: '7/10 slices - Pretty Good Loaf! 🍞',
            8: '8/10 slices - Really Fresh Loaf! 🍞',
            9: '9/10 slices - Almost a Full Loaf! 🍞',
            10: '10/10 slices - FULL LOAF! Perfect! 🍞'
        };
    
    ratingText.textContent = descriptions[rating];
}

// Hover effect for bread slices
document.addEventListener('DOMContentLoaded', function() {
    const slices = document.querySelectorAll('.bread-slice');
    
    slices.forEach((slice, index) => {
        slice.addEventListener('mouseenter', function() {
            const value = parseInt(this.getAttribute('data-value'));
            slices.forEach(s => {
                const sValue = parseInt(s.getAttribute('data-value'));
                s.style.opacity = sValue <= value ? '1' : '0.3';
            });
        });
        
        slice.parentElement.addEventListener('mouseleave', function() {
            const checked = document.querySelector('input[name="rating"]:checked');
            if (checked) {
                updateBreadPreview(parseInt(checked.value));
            } else {
                slices.forEach(s => s.style.opacity = '0.3');
            }
        });
    });
});
</script>
@endsection


