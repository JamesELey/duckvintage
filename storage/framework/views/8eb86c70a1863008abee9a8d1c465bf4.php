

<?php $__env->startSection('title', 'Commission Management - Duck Vintage'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Commission Management</h1>
        <a href="<?php echo e(route('admin.commissions.create')); ?>" class="btn">Add Commission Setting</a>
    </div>

    <!-- Commission Statistics -->
    <div class="grid grid-4" style="margin-bottom: 3rem;">
        <div class="card" style="text-align: center;">
            <h3 style="color: #FFD700; font-size: 2rem; margin-bottom: 0.5rem;">$<?php echo e(number_format($stats['total_commission'], 2)); ?></h3>
            <p>Total Commission</p>
        </div>
        
        <div class="card" style="text-align: center;">
            <h3 style="color: #28a745; font-size: 2rem; margin-bottom: 0.5rem;">$<?php echo e(number_format($stats['paid_commission'], 2)); ?></h3>
            <p>Paid Commission</p>
        </div>
        
        <div class="card" style="text-align: center;">
            <h3 style="color: #ffc107; font-size: 2rem; margin-bottom: 0.5rem;">$<?php echo e(number_format($stats['pending_commission'], 2)); ?></h3>
            <p>Pending Commission</p>
        </div>
        
        <div class="card" style="text-align: center;">
            <h3 style="color: #FFD700; font-size: 2rem; margin-bottom: 0.5rem;"><?php echo e($stats['total_orders']); ?></h3>
            <p>Total Orders</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-2" style="margin-bottom: 3rem;">
        <div class="card">
            <div class="card-header">
                <h3>Quick Actions</h3>
            </div>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <a href="<?php echo e(route('admin.commissions.orders')); ?>" class="btn">View Commission Orders</a>
                <form method="POST" action="<?php echo e(route('admin.commissions.mark-all-paid')); ?>" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <button type="submit" class="btn btn-secondary" onclick="return confirm('Mark all pending commissions as paid?')">Mark All as Paid</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Commission Summary</h3>
            </div>
            <div>
                <p><strong>Paid Orders:</strong> <?php echo e($stats['paid_orders']); ?></p>
                <p><strong>Pending Orders:</strong> <?php echo e($stats['pending_orders']); ?></p>
                <p><strong>Average Commission per Order:</strong> $<?php echo e($stats['total_orders'] > 0 ? number_format($stats['total_commission'] / $stats['total_orders'], 2) : '0.00'); ?></p>
            </div>
        </div>
    </div>

    <!-- Commission Settings -->
    <div class="card">
        <div class="card-header">
            <h3>Commission Settings</h3>
        </div>
        <div class="card-body">
            <?php if($settings->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Percentage</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($setting->name); ?></td>
                                    <td><?php echo e($setting->description); ?></td>
                                    <td><?php echo e($setting->percentage); ?>%</td>
                                    <td>
                                        <span class="badge" style="background-color: <?php echo e($setting->is_active ? '#28a745' : '#dc3545'); ?>;">
                                            <?php echo e($setting->is_active ? 'Active' : 'Inactive'); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($setting->created_at->format('M d, Y')); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.commissions.edit', $setting)); ?>" class="btn" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Edit</a>
                                        <form method="POST" action="<?php echo e(route('admin.commissions.destroy', $setting)); ?>" style="display: inline;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-secondary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 2rem;">
                    <h3>No Commission Settings</h3>
                    <p style="color: #ccc; margin: 1rem 0;">Create your first commission setting to get started.</p>
                    <a href="<?php echo e(route('admin.commissions.create')); ?>" class="btn">Create Commission Setting</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8_2\htdocs\DuckVintage\resources\views/admin/commissions/index.blade.php ENDPATH**/ ?>