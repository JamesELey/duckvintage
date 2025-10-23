

<?php $__env->startSection('title', 'Products - Duck Vintage'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Products</h1>
        <div style="display: flex; gap: 1rem; align-items: center;">
            <form method="GET" action="<?php echo e(route('products.index')); ?>" style="display: flex; gap: 1rem;">
                <input type="text" name="search" placeholder="Search products..." value="<?php echo e(request('search')); ?>" class="form-control" style="width: 200px;">
                <select name="category" class="form-control" style="width: 150px;">
                    <option value="">All Categories</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                            <?php echo e($category->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button type="submit" class="btn">Search</button>
            </form>
        </div>
    </div>

    <?php if($products->count() > 0): ?>
        <div class="grid grid-3">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="product-card">
                <a href="<?php echo e(route('products.show', $product)); ?>" style="text-decoration: none; color: inherit;">
                    <?php if($product->images && count($product->images) > 0): ?>
                        <img src="<?php echo e(asset('storage/' . $product->images[0])); ?>" alt="<?php echo e($product->name); ?>" class="product-image">
                    <?php else: ?>
                        <div class="product-image" style="background-color: #333; display: flex; align-items: center; justify-content: center; color: #FFD700;">
                            No Image
                        </div>
                    <?php endif; ?>
                    <div class="product-info">
                        <h3 class="product-title"><?php echo e($product->name); ?></h3>
                        <p style="font-size: 0.9rem; color: #CCC; margin-bottom: 0.5rem;"><?php echo e($product->category->name); ?></p>
                        <div class="product-price">
                            <?php if($product->sale_price): ?>
                                <span class="product-sale-price">$<?php echo e(number_format($product->price, 2)); ?></span>
                                $<?php echo e(number_format($product->sale_price, 2)); ?>

                            <?php else: ?>
                                $<?php echo e(number_format($product->price, 2)); ?>

                            <?php endif; ?>
                        </div>
                        <?php if($product->sale_price): ?>
                            <span style="color: #FF6B6B; font-size: 0.8rem;"><?php echo e($product->discount_percentage); ?>% OFF</span>
                        <?php endif; ?>
                        <?php if($product->stock_quantity <= 5 && $product->stock_quantity > 0): ?>
                            <p style="color: #FF6B6B; font-size: 0.8rem; margin-top: 0.5rem;">Only <?php echo e($product->stock_quantity); ?> left!</p>
                        <?php elseif($product->stock_quantity == 0): ?>
                            <p style="color: #FF6B6B; font-size: 0.8rem; margin-top: 0.5rem;">Out of Stock</p>
                        <?php endif; ?>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div style="margin-top: 2rem;">
            <?php echo e($products->links()); ?>

        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 4rem 0;">
            <h2>No products found</h2>
            <p>Try adjusting your search criteria or browse our categories.</p>
            <a href="<?php echo e(route('products.index')); ?>" class="btn">View All Products</a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8_2\htdocs\DuckVintage\resources\views/products/index.blade.php ENDPATH**/ ?>