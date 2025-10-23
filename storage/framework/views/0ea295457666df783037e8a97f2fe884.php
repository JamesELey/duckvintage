

<?php $__env->startSection('title', 'Categories Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Categories Management</h2>
            <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn">Add New Category</a>
        </div>
    </div>
    <div class="card-body">
        <?php if($categories->count() > 0): ?>
            <div class="grid grid-3">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card">
                        <div class="card-header">
                            <h3><?php echo e($category->name); ?></h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Slug:</strong> <?php echo e($category->slug); ?></p>
                            <p><strong>Description:</strong> <?php echo e($category->description); ?></p>
                            <p><strong>Status:</strong> <?php echo e($category->is_active ? 'Active' : 'Inactive'); ?></p>
                            <p><strong>Products:</strong> <?php echo e($category->products->count()); ?></p>
                            <p><strong>Created:</strong> <?php echo e($category->created_at->format('M d, Y')); ?></p>
                        </div>
                        <div style="padding: 1rem; border-top: 1px solid #333;">
                            <a href="<?php echo e(route('admin.categories.show', $category)); ?>" class="btn" style="margin-right: 0.5rem;">View</a>
                            <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" class="btn btn-secondary" style="margin-right: 0.5rem;">Edit</a>
                            
                            <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" method="POST" style="display: inline-block;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn" style="background-color: #dc3545; color: white;" onclick="return confirm('Are you sure you want to delete this category?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 2rem;">
                <h3>No categories found</h3>
                <p>Get started by creating your first category.</p>
                <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn">Create Category</a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8_2\htdocs\DuckVintage\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>