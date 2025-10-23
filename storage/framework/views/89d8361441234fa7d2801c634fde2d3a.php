

<?php $__env->startSection('title', 'Orders Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h2>Orders Management</h2>
    </div>
    <div class="card-body">
        <?php if($orders->count() > 0): ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>#<?php echo e($order->id); ?></td>
                                <td><?php echo e($order->user->name); ?></td>
                                <td>$<?php echo e(number_format($order->total, 2)); ?></td>
                                <td>
                                    <span class="badge" style="background-color: <?php echo e($order->status === 'completed' ? '#28a745' : ($order->status === 'pending' ? '#ffc107' : '#dc3545')); ?>;">
                                        <?php echo e(ucfirst($order->status)); ?>

                                    </span>
                                </td>
                                <td><?php echo e($order->created_at->format('M d, Y')); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn">View Details</a>
                                    
                                    <form action="<?php echo e(route('admin.orders.update-status', $order)); ?>" method="POST" style="display: inline-block; margin-left: 0.5rem;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <select name="status" onchange="this.form.submit()" class="form-control" style="display: inline-block; width: auto;">
                                            <option value="pending" <?php echo e($order->status === 'pending' ? 'selected' : ''); ?>>Pending</option>
                                            <option value="processing" <?php echo e($order->status === 'processing' ? 'selected' : ''); ?>>Processing</option>
                                            <option value="shipped" <?php echo e($order->status === 'shipped' ? 'selected' : ''); ?>>Shipped</option>
                                            <option value="completed" <?php echo e($order->status === 'completed' ? 'selected' : ''); ?>>Completed</option>
                                            <option value="cancelled" <?php echo e($order->status === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 2rem;">
                <h3>No orders found</h3>
                <p>Orders will appear here when customers make purchases.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8_2\htdocs\DuckVintage\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>