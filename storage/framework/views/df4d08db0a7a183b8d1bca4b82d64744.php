

<?php $__env->startSection('title', 'Order Details - Duck Vintage'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Order Details: #<?php echo e($order->id); ?></h2>
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
                    <p><strong>Created:</strong> <?php echo e($order->created_at->format('M d, Y H:i')); ?></p>
                    <p><strong>Updated:</strong> <?php echo e($order->updated_at->format('M d, Y H:i')); ?></p>
                </div>
                
                <div>
                    <h3>Shipping Information</h3>
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
                <?php if($order->items->count() > 0): ?>
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
                                    <td><strong>$<?php echo e(number_format($order->total_amount, 2)); ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php else: ?>
                    <p>No items found in this order.</p>
                <?php endif; ?>
            </div>

            <div class="form-group" style="margin-top: 2rem;">
                <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-secondary">Back to Orders</a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8_2\htdocs\DuckVintage\resources\views/orders/show.blade.php ENDPATH**/ ?>