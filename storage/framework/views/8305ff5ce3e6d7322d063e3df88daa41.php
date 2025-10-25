

<?php $__env->startSection('title', $product->name . ' - Duck Vintage'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="grid grid-2" style="gap: 3rem;">
        <!-- Product Images -->
        <div>
            <?php if($product->images && count($product->images) > 0): ?>
                <div style="margin-bottom: 1rem;">
                    <img src="<?php echo e(asset('storage/' . $product->images[0])); ?>" alt="<?php echo e($product->name); ?>" style="width: 100%; height: 400px; object-fit: cover; border-radius: 8px;">
                </div>
                <?php if(count($product->images) > 1): ?>
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <img src="<?php echo e(asset('storage/' . $image)); ?>" alt="<?php echo e($product->name); ?>" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; cursor: pointer;" onclick="changeMainImage(this.src)">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div style="width: 100%; height: 400px; background-color: #333; display: flex; align-items: center; justify-content: center; color: #FFD700; border-radius: 8px;">
                    No Image Available
                </div>
            <?php endif; ?>
        </div>

        <!-- Product Details -->
        <div>
            <h1 style="font-size: 2rem; margin-bottom: 1rem;"><?php echo e($product->name); ?></h1>
            <p style="color: #CCC; margin-bottom: 1rem;"><?php echo e($product->category->name); ?></p>
            
            <div style="margin-bottom: 1rem;">
                <?php if($product->sale_price): ?>
                    <span style="font-size: 1.5rem; color: #FF6B6B; text-decoration: line-through; margin-right: 0.5rem;">$<?php echo e(number_format($product->price, 2)); ?></span>
                    <span style="font-size: 2rem; font-weight: bold; color: #FFD700;">$<?php echo e(number_format($product->sale_price, 2)); ?></span>
                    <span style="color: #FF6B6B; margin-left: 0.5rem;"><?php echo e($product->discount_percentage); ?>% OFF</span>
                <?php else: ?>
                    <span style="font-size: 2rem; font-weight: bold; color: #FFD700;">$<?php echo e(number_format($product->price, 2)); ?></span>
                <?php endif; ?>
            </div>

            <div style="margin-bottom: 2rem;">
                <p><?php echo e($product->description); ?></p>
            </div>

            <?php if($product->stock_quantity > 0): ?>
                <form method="POST" action="<?php echo e(route('cart.add')); ?>" style="margin-bottom: 2rem;">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                    
                    <div class="form-group">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" value="1" min="1" max="<?php echo e($product->stock_quantity); ?>" class="form-control" style="width: 100px;">
                    </div>

                    <?php if($product->sizes && count($product->sizes) > 0): ?>
                        <div class="form-group">
                            <label class="form-label">Size</label>
                            <select name="size" class="form-control" style="width: 150px;">
                                <option value="">Select Size</option>
                                <?php $__currentLoopData = $product->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($size); ?>"><?php echo e($size); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <?php if($product->colors && count($product->colors) > 0): ?>
                        <div class="form-group">
                            <label class="form-label">Color</label>
                            <select name="color" class="form-control" style="width: 150px;">
                                <option value="">Select Color</option>
                                <?php $__currentLoopData = $product->colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($color); ?>"><?php echo e($color); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <button type="submit" class="btn" style="font-size: 1.1rem; padding: 1rem 2rem;">Add to Cart</button>
                </form>
            <?php else: ?>
                <div style="padding: 1rem; background-color: #4d1a1a; border: 1px solid #7a2d2d; border-radius: 4px; margin-bottom: 2rem;">
                    <p style="color: #FFB6C1; margin: 0;">This product is currently out of stock.</p>
                </div>
            <?php endif; ?>

            <div style="border-top: 1px solid #333; padding-top: 1rem;">
                <p style="color: #CCC; margin-bottom: 0.5rem;"><strong>SKU:</strong> <?php echo e($product->sku); ?></p>
                <p style="color: #CCC;"><strong>Stock:</strong> <?php echo e($product->stock_quantity); ?> available</p>
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
                    <div style="font-size: 3rem; font-weight: bold; color: #FFD700;"><?php echo e(number_format($product->average_rating, 1)); ?></div>
                    <div style="color: #999; font-size: 0.9rem;">out of 10 slices</div>
                </div>
                <div style="flex: 1;">
                    <div style="margin-bottom: 0.5rem;"><?php echo $product->bread_slices; ?></div>
                    <div style="color: #999;"><?php echo e($product->review_count); ?> <?php echo e(Str::plural('review', $product->review_count)); ?></div>
                    <?php
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
                    ?>
                    <div style="color: #FFD700; margin-top: 0.5rem;"><?php echo e($loafDescription); ?></div>
                </div>
            </div>
        </div>

        <!-- Write a Review Form -->
        <?php
            $userReview = null;
            if (auth()->check()) {
                $userReview = $product->reviews()->where('user_id', auth()->id())->first();
            }
        ?>
        
        <?php if(!$userReview): ?>
            <div class="card" style="margin-bottom: 3rem;">
                <div class="card-header">
                    <h3>Write a Review 🍞</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('reviews.store', $product)); ?>">
                        <?php echo csrf_field(); ?>
                        
                        <?php if(auth()->guard()->guest()): ?>
                            <div class="form-group">
                                <label class="form-label">Your Name *</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="alert alert-error"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Your Email *</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="alert alert-error"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        <?php else: ?>
                            <div class="form-group">
                                <label class="form-label">Your Name *</label>
                                <input type="text" name="name" class="form-control" value="<?php echo e(auth()->user()->name); ?>" readonly style="background-color: #333; color: #999;">
                                <small style="color: #999;">Using your account name</small>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Your Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo e(auth()->user()->email); ?>" readonly style="background-color: #333; color: #999;">
                                <small style="color: #999;">Using your account email</small>
                            </div>
                        <?php endif; ?>
                        
                        <div class="form-group">
                            <label class="form-label">Rating (Bread Slices out of 10) *</label>
                            <div style="display: flex; gap: 0.5rem; align-items: center; margin-top: 0.5rem;">
                                <?php for($i = 1; $i <= 10; $i++): ?>
                                    <label style="cursor: pointer; font-size: 2rem;">
                                        <input type="radio" name="rating" value="<?php echo e($i); ?>" required style="display: none;" onchange="updateBreadPreview(<?php echo e($i); ?>)">
                                        <span class="bread-slice" data-value="<?php echo e($i); ?>" style="opacity: 0.3; transition: opacity 0.2s;">🍞</span>
                                    </label>
                                <?php endfor; ?>
                            </div>
                            <div id="ratingText" style="color: #FFD700; margin-top: 0.5rem; font-weight: bold;"></div>
                            <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="alert alert-error"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Review Title (optional)</label>
                            <input type="text" name="title" class="form-control" placeholder="Sum up your experience">
                            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="alert alert-error"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Your Review (optional)</label>
                            <textarea name="comment" class="form-control" rows="5" placeholder="Share your thoughts about this product..."></textarea>
                            <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="alert alert-error"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <button type="submit" class="btn">Submit Review</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div style="background-color: #1a4d1a; border: 1px solid #2d7a2d; color: #90EE90; padding: 1rem; border-radius: 4px; margin-bottom: 3rem;">
                <strong>You've already reviewed this product!</strong> Your feedback helps others make better decisions. 🍞
            </div>
        <?php endif; ?>

        <!-- Display Reviews -->
        <?php if($product->reviews->count() > 0): ?>
            <div style="margin-top: 3rem;">
                <h3 style="margin-bottom: 2rem;">All Reviews (<?php echo e($product->reviews->count()); ?>)</h3>
                <?php $__currentLoopData = $product->reviews()->latest()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card" style="margin-bottom: 1.5rem;">
                        <div class="card-body">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                                <div>
                                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                                        <strong><?php echo e($review->reviewer_name); ?></strong>
                                        <?php if($review->is_verified_purchase): ?>
                                            <span style="background-color: #1a4d1a; color: #90EE90; padding: 0.25rem 0.75rem; border-radius: 4px; font-size: 0.8rem;">✓ Verified Purchase</span>
                                        <?php endif; ?>
                                    </div>
                                    <div style="margin-bottom: 0.5rem;">
                                        <?php echo $review->bread_slices; ?>

                                        <span style="color: #FFD700; margin-left: 0.5rem; font-weight: bold;"><?php echo e($review->rating); ?>/10 slices</span>
                                    </div>
                                    <?php if($review->title): ?>
                                        <h4 style="color: #FFD700; margin-bottom: 0.5rem;"><?php echo e($review->title); ?></h4>
                                    <?php endif; ?>
                                </div>
                                <div style="text-align: right;">
                                    <div style="color: #999; font-size: 0.9rem;"><?php echo e($review->created_at->diffForHumans()); ?></div>
                                    <?php if(auth()->guard()->check()): ?>
                                        <?php if($review->user_id === auth()->id() || auth()->user()->hasRole('admin')): ?>
                                            <form method="POST" action="<?php echo e(route('reviews.destroy', $review)); ?>" style="display: inline; margin-top: 0.5rem;" onsubmit="return confirm('Are you sure you want to delete this review?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" style="background: none; border: none; color: #FF6B6B; cursor: pointer; font-size: 0.9rem; text-decoration: underline;">Delete</button>
                                            </form>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if($review->comment): ?>
                                <p style="line-height: 1.6; color: #ddd;"><?php echo e($review->comment); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 3rem; color: #999;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🍞</div>
                <p>No reviews yet. Be the first to share your thoughts!</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Related Products -->
    <?php if($relatedProducts->count() > 0): ?>
        <div style="margin-top: 4rem;">
            <h2 style="margin-bottom: 2rem;">Related Products</h2>
            <div class="grid grid-4">
                <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="product-card">
                    <a href="<?php echo e(route('products.show', $relatedProduct)); ?>" style="text-decoration: none; color: inherit;">
                        <?php if($relatedProduct->images && count($relatedProduct->images) > 0): ?>
                            <img src="<?php echo e(asset('storage/' . $relatedProduct->images[0])); ?>" alt="<?php echo e($relatedProduct->name); ?>" class="product-image">
                        <?php else: ?>
                            <div class="product-image" style="background-color: #333; display: flex; align-items: center; justify-content: center; color: #FFD700;">
                                No Image
                            </div>
                        <?php endif; ?>
                        <div class="product-info">
                            <h3 class="product-title"><?php echo e($relatedProduct->name); ?></h3>
                            <div class="product-price">
                                <?php if($relatedProduct->sale_price): ?>
                                    <span class="product-sale-price">$<?php echo e(number_format($relatedProduct->price, 2)); ?></span>
                                    $<?php echo e(number_format($relatedProduct->sale_price, 2)); ?>

                                <?php else: ?>
                                    $<?php echo e(number_format($relatedProduct->price, 2)); ?>

                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>
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
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8_2\htdocs\DuckVintage\resources\views/products/show.blade.php ENDPATH**/ ?>