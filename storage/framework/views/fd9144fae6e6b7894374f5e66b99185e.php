

<?php $__env->startSection('title', 'Admin Dashboard - Duck Vintage'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 style="margin-bottom: 2rem;">Admin Dashboard</h1>

    <!-- Statistics Cards -->
    <div class="grid grid-4" style="margin-bottom: 3rem;">
        <div class="card" style="text-align: center;">
            <h3 style="color: #FFD700; font-size: 2rem; margin-bottom: 0.5rem;"><?php echo e($stats['total_products']); ?></h3>
            <p>Total Products</p>
        </div>
        
        <div class="card" style="text-align: center;">
            <h3 style="color: #FFD700; font-size: 2rem; margin-bottom: 0.5rem;"><?php echo e($stats['total_categories']); ?></h3>
            <p>Categories</p>
        </div>
        
        <div class="card" style="text-align: center;">
            <h3 style="color: #FFD700; font-size: 2rem; margin-bottom: 0.5rem;"><?php echo e($stats['total_orders']); ?></h3>
            <p>Total Orders</p>
        </div>
        
        <div class="card" style="text-align: center;">
            <h3 style="color: #FFD700; font-size: 2rem; margin-bottom: 0.5rem;"><?php echo e($stats['total_users']); ?></h3>
            <p>Registered Users</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-2" style="margin-bottom: 3rem;">
        <div class="card">
            <div class="card-header">
                <h3>Quick Actions</h3>
            </div>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <a href="<?php echo e(route('admin.products.create')); ?>" class="btn">Add New Product</a>
                <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn">Add New Category</a>
                <a href="<?php echo e(route('admin.users.create')); ?>" class="btn">Add New User</a>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-secondary">View All Orders</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Pending Orders</h3>
            </div>
            <div style="text-align: center; padding: 2rem;">
                <h2 style="color: #FFD700; font-size: 3rem; margin-bottom: 0.5rem;"><?php echo e($stats['pending_orders']); ?></h2>
                <p>Orders awaiting processing</p>
                <?php if($stats['pending_orders'] > 0): ?>
                    <a href="<?php echo e(route('admin.orders.index')); ?>?status=pending" class="btn" style="margin-top: 1rem;">View Pending Orders</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <?php if($stats['recent_orders']->count() > 0): ?>
        <div class="card">
            <div class="card-header">
                <h3>Recent Orders</h3>
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid #333;">
                            <th style="padding: 1rem; text-align: left;">Order #</th>
                            <th style="padding: 1rem; text-align: left;">Customer</th>
                            <th style="padding: 1rem; text-align: left;">Status</th>
                            <th style="padding: 1rem; text-align: left;">Total</th>
                            <th style="padding: 1rem; text-align: left;">Date</th>
                            <th style="padding: 1rem; text-align: left;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $stats['recent_orders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr style="border-bottom: 1px solid #333;">
                            <td style="padding: 1rem;"><?php echo e($order->order_number); ?></td>
                            <td style="padding: 1rem;"><?php echo e($order->user->name); ?></td>
                            <td style="padding: 1rem;">
                                <span style="padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; text-transform: uppercase;
                                    <?php if($order->status === 'pending'): ?> background-color: #4d1a1a; color: #FFB6C1;
                                    <?php elseif($order->status === 'processing'): ?> background-color: #4d3d1a; color: #FFD700;
                                    <?php elseif($order->status === 'shipped'): ?> background-color: #1a4d3d; color: #90EE90;
                                    <?php elseif($order->status === 'delivered'): ?> background-color: #1a4d1a; color: #90EE90;
                                    <?php else: ?> background-color: #4d1a1a; color: #FFB6C1;
                                    <?php endif; ?>">
                                    <?php echo e($order->status); ?>

                                </span>
                            </td>
                            <td style="padding: 1rem;">$<?php echo e(number_format($order->total_amount, 2)); ?></td>
                            <td style="padding: 1rem;"><?php echo e($order->created_at->format('M j, Y')); ?></td>
                            <td style="padding: 1rem;">
                                <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">View</a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8_2\htdocs\DuckVintage\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>