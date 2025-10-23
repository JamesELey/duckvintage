

<?php $__env->startSection('title', 'Order Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h2>Order Details: <?php echo e($order->order_number); ?></h2>
    </div>
    <div class="card-body">
        <div class="grid grid-2">
            <div>
                <h3>Order Information</h3>
                <p><strong>Order ID:</strong> <?php echo e($order->order_number); ?></p>
                <p><strong>Status:</strong> 
                    <span class="badge" style="background-color: <?php echo e($order->status === 'completed' ? '#28a745' : ($order->status === 'pending' ? '#ffc107' : '#dc3545')); ?>;">
                        <?php echo e(ucfirst($order->status)); ?>

                    </span>
                </p>
                <p><strong>Total:</strong> $<?php echo e(number_format($order->total_amount, 2)); ?></p>
                <p><strong>Payment Method:</strong> <?php echo e(ucfirst(str_replace('_', ' ', $order->payment_method ?? 'N/A'))); ?></p>
                <p><strong>Payment Status:</strong> 
                    <span class="badge" style="background-color: <?php echo e($order->payment_status === 'completed' ? '#28a745' : ($order->payment_status === 'pending' ? '#ffc107' : '#dc3545')); ?>;">
                        <?php echo e(ucfirst($order->payment_status ?? 'N/A')); ?>

                    </span>
                </p>
                <p><strong>Created:</strong> <?php echo e($order->created_at->format('M d, Y H:i')); ?></p>
                <p><strong>Updated:</strong> <?php echo e($order->updated_at->format('M d, Y H:i')); ?></p>
            </div>
            
            <div>
                <h3>Customer Information</h3>
                <p><strong>Name:</strong> <?php echo e($order->user->name); ?></p>
                <p><strong>Email:</strong> <?php echo e($order->user->email); ?></p>
                <?php if($order->shipping_address): ?>
                    <p><strong>Shipping Address:</strong></p>
                    <div style="background-color: #333; padding: 1rem; border-radius: 4px; margin-top: 0.5rem;">
                        <?php echo e($order->shipping_address); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <h3>Order Items</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item->product->name); ?></td>
                                <td><?php echo e($item->product->sku); ?></td>
                                <td>$<?php echo e(number_format($item->price, 2)); ?></td>
                                <td><?php echo e($item->quantity); ?></td>
                                <td>$<?php echo e(number_format($item->price * $item->quantity, 2)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr style="border-top: 2px solid #333;">
                            <td colspan="4" style="text-align: right;"><strong>Order Total:</strong></td>
                            <td><strong>$<?php echo e(number_format($order->total, 2)); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <h3>Update Order Status</h3>
            <form action="<?php echo e(route('admin.orders.update-status', $order)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                
                <div class="form-group">
                    <label for="status" class="form-label">Order Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="pending" <?php echo e($order->status === 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="processing" <?php echo e($order->status === 'processing' ? 'selected' : ''); ?>>Processing</option>
                        <option value="shipped" <?php echo e($order->status === 'shipped' ? 'selected' : ''); ?>>Shipped</option>
                        <option value="completed" <?php echo e($order->status === 'completed' ? 'selected' : ''); ?>>Completed</option>
                        <option value="cancelled" <?php echo e($order->status === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn">Update Status</button>
                    <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-secondary">Back to Orders</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8_2\htdocs\DuckVintage\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>