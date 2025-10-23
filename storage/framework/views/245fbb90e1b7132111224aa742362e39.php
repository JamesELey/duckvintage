

<?php $__env->startSection('title', 'Checkout - Duck Vintage'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 style="margin-bottom: 2rem;">Checkout</h1>

    <?php if(auth()->user()->cartItems->count() > 0): ?>
        <div class="grid grid-2" style="gap: 3rem;">
            <!-- Checkout Form -->
            <div>
                <form method="POST" action="<?php echo e(route('payment.process')); ?>">
                    <?php echo csrf_field(); ?>
                    
                    <!-- Shipping Address -->
                    <div class="card" style="margin-bottom: 2rem;">
                        <div class="card-header">
                            <h3>Shipping Address</h3>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="shipping_address[name]" value="<?php echo e(old('shipping_address.name', auth()->user()->name)); ?>" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Street Address</label>
                            <input type="text" name="shipping_address[street]" value="<?php echo e(old('shipping_address.street')); ?>" class="form-control" required>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label class="form-label">City</label>
                                <input type="text" name="shipping_address[city]" value="<?php echo e(old('shipping_address.city')); ?>" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">State</label>
                                <input type="text" name="shipping_address[state]" value="<?php echo e(old('shipping_address.state')); ?>" class="form-control" required>
                            </div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label class="form-label">ZIP Code</label>
                                <input type="text" name="shipping_address[zip]" value="<?php echo e(old('shipping_address.zip')); ?>" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Country</label>
                                <input type="text" name="shipping_address[country]" value="<?php echo e(old('shipping_address.country', 'United States')); ?>" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <!-- Billing Address -->
                    <div class="card" style="margin-bottom: 2rem;">
                        <div class="card-header">
                            <h3>Billing Address</h3>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="billing_address[name]" value="<?php echo e(old('billing_address.name', auth()->user()->name)); ?>" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Street Address</label>
                            <input type="text" name="billing_address[street]" value="<?php echo e(old('billing_address.street')); ?>" class="form-control" required>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label class="form-label">City</label>
                                <input type="text" name="billing_address[city]" value="<?php echo e(old('billing_address.city')); ?>" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">State</label>
                                <input type="text" name="billing_address[state]" value="<?php echo e(old('billing_address.state')); ?>" class="form-control" required>
                            </div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label class="form-label">ZIP Code</label>
                                <input type="text" name="billing_address[zip]" value="<?php echo e(old('billing_address.zip')); ?>" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Country</label>
                                <input type="text" name="billing_address[country]" value="<?php echo e(old('billing_address.country', 'United States')); ?>" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="card" style="margin-bottom: 2rem;">
                        <div class="card-header">
                            <h3>Payment Method</h3>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Select Payment Method *</label>
                            <div style="display: flex; flex-direction: column; gap: 1rem;">
                                <label style="display: flex; align-items: center; gap: 0.5rem; padding: 1rem; border: 1px solid #333; border-radius: 4px; cursor: pointer;">
                                    <input type="radio" name="payment_method" value="stripe" <?php echo e(old('payment_method', 'stripe') === 'stripe' ? 'checked' : ''); ?> required>
                                    <div>
                                        <strong>Credit/Debit Card (Stripe)</strong>
                                        <p style="margin: 0; color: #ccc; font-size: 0.9rem;">Pay securely with your credit or debit card</p>
                                    </div>
                                </label>
                                
                                <label style="display: flex; align-items: center; gap: 0.5rem; padding: 1rem; border: 1px solid #333; border-radius: 4px; cursor: pointer;">
                                    <input type="radio" name="payment_method" value="paypal" <?php echo e(old('payment_method') === 'paypal' ? 'checked' : ''); ?>>
                                    <div>
                                        <strong>PayPal</strong>
                                        <p style="margin: 0; color: #ccc; font-size: 0.9rem;">Pay with your PayPal account</p>
                                    </div>
                                </label>
                                
                                <label style="display: flex; align-items: center; gap: 0.5rem; padding: 1rem; border: 1px solid #333; border-radius: 4px; cursor: pointer;">
                                    <input type="radio" name="payment_method" value="cash_on_delivery" <?php echo e(old('payment_method') === 'cash_on_delivery' ? 'checked' : ''); ?>>
                                    <div>
                                        <strong>Cash on Delivery</strong>
                                        <p style="margin: 0; color: #ccc; font-size: 0.9rem;">Pay when your order is delivered</p>
                                    </div>
                                </label>
                            </div>
                            <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="alert alert-error"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="form-group">
                        <label class="form-label">Order Notes (Optional)</label>
                        <textarea name="notes" rows="3" class="form-control" placeholder="Any special instructions for your order..."><?php echo e(old('notes')); ?></textarea>
                    </div>

                    <button type="submit" class="btn" style="font-size: 1.1rem; padding: 1rem 2rem;">Place Order</button>
                </form>
            </div>

            <!-- Order Summary -->
            <div>
                <div class="card">
                    <div class="card-header">
                        <h3>Order Summary</h3>
                    </div>
                    
                    <?php $__currentLoopData = auth()->user()->cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div style="display: flex; gap: 1rem; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #333;">
                        <?php if($item->product->images && count($item->product->images) > 0): ?>
                            <img src="<?php echo e(asset('storage/' . $item->product->images[0])); ?>" alt="<?php echo e($item->product->name); ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                        <?php else: ?>
                            <div style="width: 60px; height: 60px; background-color: #333; display: flex; align-items: center; justify-content: center; color: #FFD700; border-radius: 4px; font-size: 0.8rem;">
                                No Image
                            </div>
                        <?php endif; ?>
                        
                        <div style="flex: 1;">
                            <h4 style="margin-bottom: 0.25rem;"><?php echo e($item->product->name); ?></h4>
                            <p style="color: #CCC; font-size: 0.9rem; margin-bottom: 0.25rem;"><?php echo e($item->product->category->name); ?></p>
                            <?php if($item->size): ?>
                                <p style="color: #CCC; font-size: 0.8rem; margin-bottom: 0.25rem;">Size: <?php echo e($item->size); ?></p>
                            <?php endif; ?>
                            <?php if($item->color): ?>
                                <p style="color: #CCC; font-size: 0.8rem; margin-bottom: 0.25rem;">Color: <?php echo e($item->color); ?></p>
                            <?php endif; ?>
                            <p style="color: #FFD700; font-weight: bold;">$<?php echo e(number_format($item->product->current_price, 2)); ?> x <?php echo e($item->quantity); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <div style="margin-top: 1rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span>Subtotal:</span>
                            <span>$<?php echo e(number_format(auth()->user()->cart_total, 2)); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span>Tax (8%):</span>
                            <span>$<?php echo e(number_format(auth()->user()->cart_total * 0.08, 2)); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span>Shipping:</span>
                            <span>$10.00</span>
                        </div>
                        <hr style="border-color: #333; margin: 1rem 0;">
                        <div style="display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: bold;">
                            <span>Total:</span>
                            <span style="color: #FFD700;">$<?php echo e(number_format(auth()->user()->cart_total + (auth()->user()->cart_total * 0.08) + 10, 2)); ?></span>
                        </div>
                    </div>
                </div>
                
                <div style="margin-top: 2rem;">
                    <a href="<?php echo e(route('cart.index')); ?>" class="btn btn-secondary" style="width: 100%; text-align: center;">Back to Cart</a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 4rem 0;">
            <h2>Your cart is empty</h2>
            <p style="margin-bottom: 2rem;">Add some products to your cart before checking out.</p>
            <a href="<?php echo e(route('products.index')); ?>" class="btn">Shop Now</a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8_2\htdocs\DuckVintage\resources\views/checkout.blade.php ENDPATH**/ ?>