

<?php $__env->startSection('title', $category->name . ' - Duck Vintage'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1><?php echo e($category->name); ?></h1>
        <?php if($category->description): ?>
            <p style="color: #ccc; font-size: 1.1rem;"><?php echo e($category->description); ?></p>
        <?php endif; ?>
    </div>

    <?php if($products->count() > 0): ?>
        <div class="grid grid-3">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="product-card">
                    <div class="product-image">
                        <?php if($product->image): ?>
                            <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <div style="width: 100%; height: 100%; background-color: #333; display: flex; align-items: center; justify-content: center; color: #666;">
                                No Image
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="product-info">
                        <h3 class="product-title"><?php echo e($product->name); ?></h3>
                        <div class="product-price">
                            <?php if($product->sale_price): ?>
                                <span class="product-sale-price">$<?php echo e(number_format($product->price, 2)); ?></span>
                                $<?php echo e(number_format($product->sale_price, 2)); ?>

                            <?php else: ?>
                                $<?php echo e(number_format($product->price, 2)); ?>

                            <?php endif; ?>
                        </div>
                        <p style="color: #ccc; font-size: 0.9rem; margin: 0.5rem 0;"><?php echo e(Str::limit($product->description, 100)); ?></p>
                        <a href="<?php echo e(route('products.show', $product)); ?>" class="btn" style="margin-top: 1rem;">View Details</a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div style="margin-top: 2rem;">
            <?php echo e($products->links()); ?>

        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 3rem;">
            <h3>No products found in this category</h3>
            <p style="color: #ccc; margin: 1rem 0;">Check back later for new arrivals!</p>
            <a href="<?php echo e(route('products.index')); ?>" class="btn">Browse All Products</a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8_2\htdocs\DuckVintage\resources\views/categories/show.blade.php ENDPATH**/ ?>