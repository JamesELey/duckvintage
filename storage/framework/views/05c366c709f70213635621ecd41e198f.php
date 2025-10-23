

<?php $__env->startSection('title', 'Admin - Products - Duck Vintage'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Product Management</h1>
        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn">Add New Product</a>
    </div>

    <?php if($products->count() > 0): ?>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid #333;">
                        <th style="padding: 1rem; text-align: left;">Image</th>
                        <th style="padding: 1rem; text-align: left;">Name</th>
                        <th style="padding: 1rem; text-align: left;">Category</th>
                        <th style="padding: 1rem; text-align: left;">Price</th>
                        <th style="padding: 1rem; text-align: left;">Stock</th>
                        <th style="padding: 1rem; text-align: left;">Status</th>
                        <th style="padding: 1rem; text-align: left;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr style="border-bottom: 1px solid #333;">
                        <td style="padding: 1rem;">
                            <?php if($product->images && count($product->images) > 0): ?>
                                <img src="<?php echo e(asset('storage/' . $product->images[0])); ?>" alt="<?php echo e($product->name); ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                            <?php else: ?>
                                <div style="width: 50px; height: 50px; background-color: #333; display: flex; align-items: center; justify-content: center; color: #FFD700; border-radius: 4px; font-size: 0.8rem;">
                                    No Image
                                </div>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 1rem;">
                            <strong><?php echo e($product->name); ?></strong>
                            <br>
                            <small style="color: #CCC;">SKU: <?php echo e($product->sku); ?></small>
                        </td>
                        <td style="padding: 1rem;"><?php echo e($product->category->name); ?></td>
                        <td style="padding: 1rem;">
                            <?php if($product->sale_price): ?>
                                <span style="color: #FF6B6B; text-decoration: line-through;">$<?php echo e(number_format($product->price, 2)); ?></span>
                                <br>
                                <span style="color: #FFD700; font-weight: bold;">$<?php echo e(number_format($product->sale_price, 2)); ?></span>
                            <?php else: ?>
                                <span style="color: #FFD700; font-weight: bold;">$<?php echo e(number_format($product->price, 2)); ?></span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 1rem;">
                            <span style="color: <?php echo e($product->stock_quantity > 10 ? '#90EE90' : ($product->stock_quantity > 0 ? '#FFD700' : '#FF6B6B')); ?>">
                                <?php echo e($product->stock_quantity); ?>

                            </span>
                        </td>
                        <td style="padding: 1rem;">
                            <span style="padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; text-transform: uppercase;
                                <?php if($product->is_active): ?> background-color: #1a4d1a; color: #90EE90;
                                <?php else: ?> background-color: #4d1a1a; color: #FFB6C1;
                                <?php endif; ?>">
                                <?php echo e($product->is_active ? 'Active' : 'Inactive'); ?>

                            </span>
                            <?php if($product->is_featured): ?>
                                <br>
                                <span style="padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; background-color: #4d3d1a; color: #FFD700; margin-top: 0.25rem; display: inline-block;">
                                    Featured
                                </span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 1rem;">
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="<?php echo e(route('admin.products.show', $product)); ?>" class="btn" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">View</a>
                                <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn btn-secondary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Edit</a>
                                <form method="POST" action="<?php echo e(route('admin.products.destroy', $product)); ?>" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-secondary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem; background-color: #4d1a1a; color: #FFB6C1;">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 2rem;">
            <?php echo e($products->links()); ?>

        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 4rem 0;">
            <h2>No products found</h2>
            <p style="margin-bottom: 2rem;">Get started by adding your first product.</p>
            <a href="<?php echo e(route('admin.products.create')); ?>" class="btn">Add New Product</a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8_2\htdocs\DuckVintage\resources\views/admin/products/index.blade.php ENDPATH**/ ?>