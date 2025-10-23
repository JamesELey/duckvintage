

<?php $__env->startSection('title', 'Shopping Cart - Duck Vintage'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 style="margin-bottom: 2rem;">Shopping Cart</h1>

    <?php if($cartItems->count() > 0): ?>
        <div class="grid grid-2" style="gap: 3rem;">
            <!-- Cart Items -->
            <div>
                <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card" style="margin-bottom: 1rem;">
                    <div style="display: flex; gap: 1rem;">
                        <?php if($item->product->images && count($item->product->images) > 0): ?>
                            <img src="<?php echo e(asset('storage/' . $item->product->images[0])); ?>" alt="<?php echo e($item->product->name); ?>" style="width: 100px; height: 100px; object-fit: cover; border-radius: 4px;">
                        <?php else: ?>
                            <div style="width: 100px; height: 100px; background-color: #333; display: flex; align-items: center; justify-content: center; color: #FFD700; border-radius: 4px;">
                                No Image
                            </div>
                        <?php endif; ?>
                        
                        <div style="flex: 1;">
                            <h3 style="margin-bottom: 0.5rem;"><?php echo e($item->product->name); ?></h3>
                            <p style="color: #CCC; margin-bottom: 0.5rem;"><?php echo e($item->product->category->name); ?></p>
                            
                            <?php if($item->size): ?>
                                <p style="color: #CCC; margin-bottom: 0.5rem;"><strong>Size:</strong> <?php echo e($item->size); ?></p>
                            <?php endif; ?>
                            
                            <?php if($item->color): ?>
                                <p style="color: #CCC; margin-bottom: 0.5rem;"><strong>Color:</strong> <?php echo e($item->color); ?></p>
                            <?php endif; ?>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <span style="font-size: 1.2rem; font-weight: bold; color: #FFD700;">$<?php echo e(number_format($item->product->current_price, 2)); ?></span>
                                    <span style="color: #CCC;">x <?php echo e($item->quantity); ?></span>
                                </div>
                                
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <form method="POST" action="<?php echo e(route('cart.update')); ?>" style="display: inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <input type="hidden" name="cart_item_id" value="<?php echo e($item->id); ?>">
                                        <input type="number" name="quantity" value="<?php echo e($item->quantity); ?>" min="1" max="<?php echo e($item->product->stock_quantity); ?>" style="width: 60px; padding: 0.25rem; background-color: #111; border: 1px solid #333; border-radius: 4px; color: #FFD700;">
                                        <button type="submit" class="btn" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Update</button>
                                    </form>
                                    
                                    <form method="POST" action="<?php echo e(route('cart.remove')); ?>" style="display: inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <input type="hidden" name="cart_item_id" value="<?php echo e($item->id); ?>">
                                        <button type="submit" class="btn btn-secondary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Remove</button>
                                    </form>
                                </div>
                            </div>
                            
                            <div style="margin-top: 0.5rem;">
                                <strong style="color: #FFD700;">Total: $<?php echo e(number_format($item->total_price, 2)); ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Order Summary -->
            <div>
                <div class="card">
                    <div class="card-header">
                        <h3>Order Summary</h3>
                    </div>
                    
                    <div style="margin-bottom: 1rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span>Subtotal:</span>
                            <span>$<?php echo e(number_format($total, 2)); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span>Tax (8%):</span>
                            <span>$<?php echo e(number_format($total * 0.08, 2)); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span>Shipping:</span>
                            <span>$10.00</span>
                        </div>
                        <hr style="border-color: #333; margin: 1rem 0;">
                        <div style="display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: bold;">
                            <span>Total:</span>
                            <span style="color: #FFD700;">$<?php echo e(number_format($total + ($total * 0.08) + 10, 2)); ?></span>
                        </div>
                    </div>
                    
                    <a href="<?php echo e(route('checkout')); ?>" class="btn" style="width: 100%; text-align: center; font-size: 1.1rem; padding: 1rem;">Proceed to Checkout</a>
                </div>
                
                <div style="margin-top: 2rem;">
                    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-secondary" style="width: 100%; text-align: center;">Continue Shopping</a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 4rem 0;">
            <h2>Your cart is empty</h2>
            <p style="margin-bottom: 2rem;">Add some products to get started!</p>
            <a href="<?php echo e(route('products.index')); ?>" class="btn">Shop Now</a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8_2\htdocs\DuckVintage\resources\views/cart/index.blade.php ENDPATH**/ ?>