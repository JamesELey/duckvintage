

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
</script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8_2\htdocs\DuckVintage\resources\views/products/show.blade.php ENDPATH**/ ?>