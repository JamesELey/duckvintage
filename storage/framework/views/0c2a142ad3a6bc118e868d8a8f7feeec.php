

<?php $__env->startSection('title', 'My Profile - Duck Vintage'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 style="margin-bottom: 2rem;">My Profile</h1>

    <div class="grid grid-2">
        <div class="card">
            <div class="card-header">
                <h3>Profile Information</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Name</label>
                    <p style="background-color: #333; padding: 0.75rem; border-radius: 4px; margin: 0;"><?php echo e(auth()->user()->name); ?></p>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <p style="background-color: #333; padding: 0.75rem; border-radius: 4px; margin: 0;"><?php echo e(auth()->user()->email); ?></p>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Member Since</label>
                    <p style="background-color: #333; padding: 0.75rem; border-radius: 4px; margin: 0;"><?php echo e(auth()->user()->created_at->format('F d, Y')); ?></p>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Role</label>
                    <p style="background-color: #333; padding: 0.75rem; border-radius: 4px; margin: 0;">
                        <?php $__currentLoopData = auth()->user()->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge" style="background-color: <?php echo e($role->name === 'admin' ? '#28a745' : '#ffc107'); ?>; color: #000; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; text-transform: uppercase; margin-right: 0.5rem;">
                                <?php echo e(ucfirst($role->name)); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Account Statistics</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Total Orders</label>
                    <p style="background-color: #333; padding: 0.75rem; border-radius: 4px; margin: 0; font-size: 1.5rem; color: #FFD700;"><?php echo e(auth()->user()->orders()->count()); ?></p>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Items in Cart</label>
                    <p style="background-color: #333; padding: 0.75rem; border-radius: 4px; margin: 0; font-size: 1.5rem; color: #FFD700;"><?php echo e(auth()->user()->cartItems()->count()); ?></p>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Total Spent</label>
                    <p style="background-color: #333; padding: 0.75rem; border-radius: 4px; margin: 0; font-size: 1.5rem; color: #FFD700;">$<?php echo e(number_format(auth()->user()->orders()->sum('total_amount'), 2)); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <h3>Quick Actions</h3>
        </div>
        <div class="card-body">
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="<?php echo e(route('orders.index')); ?>" class="btn">View My Orders</a>
                <a href="<?php echo e(route('cart.index')); ?>" class="btn btn-secondary">View Cart</a>
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-secondary">Continue Shopping</a>
                <?php if(auth()->user()->hasRole('admin')): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn" style="background-color: #28a745;">Admin Dashboard</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8_2\htdocs\DuckVintage\resources\views/profile/show.blade.php ENDPATH**/ ?>