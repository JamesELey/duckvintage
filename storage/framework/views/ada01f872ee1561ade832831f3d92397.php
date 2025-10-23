

<?php $__env->startSection('title', 'My Orders - Duck Vintage'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 style="margin-bottom: 2rem;">My Orders</h1>

    <?php if($orders->count() > 0): ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($order->order_number); ?></td>
                            <td><?php echo e($order->created_at->format('M d, Y')); ?></td>
                            <td>
                                <span class="badge" style="background-color: <?php echo e($order->status === 'completed' ? '#28a745' : ($order->status === 'pending' ? '#ffc107' : '#dc3545')); ?>;">
                                    <?php echo e(ucfirst($order->status)); ?>

                                </span>
                            </td>
                            <td>$<?php echo e(number_format($order->total_amount, 2)); ?></td>
                            <td>
                                <a href="<?php echo e(route('orders.show', $order)); ?>" class="btn">View Details</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 3rem;">
            <h3>No orders found</h3>
            <p style="color: #ccc; margin: 1rem 0;">You haven't placed any orders yet.</p>
            <a href="<?php echo e(route('products.index')); ?>" class="btn">Start Shopping</a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8_2\htdocs\DuckVintage\resources\views/orders/index.blade.php ENDPATH**/ ?>