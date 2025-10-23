

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

    <!-- Change Password Section -->
    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <h3>Change Password</h3>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('profile.password.update')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                
                <div class="form-group">
                    <label for="current_password" class="form-label">Current Password *</label>
                    <input type="password" id="current_password" name="current_password" class="form-control" required>
                    <?php $__errorArgs = ['current_password'];
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

                <div class="form-group">
                    <label for="password" class="form-label">New Password * (minimum 8 characters)</label>
                    <input type="password" id="password" name="password" class="form-control" required minlength="8">
                    <?php $__errorArgs = ['password'];
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

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm New Password *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required minlength="8">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn">Change Password</button>
                </div>
            </form>
        </div>
    </div>

    <!-- GDPR Data Management -->
    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <h3>Data & Privacy</h3>
        </div>
        <div class="card-body">
            <p style="margin-bottom: 1.5rem;">In compliance with GDPR and data protection regulations, you have full control over your personal data.</p>
            
            <div class="grid grid-2">
                <div>
                    <h4 style="color: #FFD700; margin-bottom: 0.5rem;">Export Your Data</h4>
                    <p style="margin-bottom: 1rem; font-size: 0.9rem;">Download all your personal data in a machine-readable JSON format.</p>
                    <a href="<?php echo e(route('profile.export-data')); ?>" class="btn btn-secondary">
                        Export My Data
                    </a>
                </div>
                
                <div>
                    <h4 style="color: #dc3545; margin-bottom: 0.5rem;">Delete Account</h4>
                    <p style="margin-bottom: 1rem; font-size: 0.9rem;">Permanently delete your account and all associated data.</p>
                    <button type="button" class="btn" style="background-color: #dc3545;" onclick="document.getElementById('deleteAccountModal').style.display='block'">
                        Delete Account
                    </button>
                </div>
            </div>
            
            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #333;">
                <p style="font-size: 0.9rem; margin-bottom: 0.5rem;">Learn more about your rights:</p>
                <a href="<?php echo e(route('privacy-policy')); ?>" style="color: #FFD700; margin-right: 1rem;">Privacy Policy</a>
                <a href="<?php echo e(route('cookie-policy')); ?>" style="color: #FFD700;">Cookie Policy</a>
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

<!-- Delete Account Confirmation Modal -->
<div id="deleteAccountModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.8);">
    <div style="background-color:#1a1a1a; margin:5% auto; padding:2rem; border:2px solid #FFD700; width:90%; max-width:500px; border-radius:8px;">
        <h2 style="color:#dc3545; margin-bottom:1rem;">⚠️ Delete Account</h2>
        <p style="margin-bottom:1.5rem; line-height:1.6;">This action is <strong>permanent</strong> and cannot be undone. All your data including orders, cart items, and personal information will be deleted.</p>
        
        <form action="<?php echo e(route('profile.delete-account')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            
            <div class="form-group">
                <label for="delete_password" class="form-label">Confirm Your Password *</label>
                <input type="password" id="delete_password" name="password" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="delete_confirmation" class="form-label">Type "DELETE" to confirm *</label>
                <input type="text" id="delete_confirmation" name="confirmation" class="form-control" required placeholder="DELETE">
            </div>
            
            <div style="display:flex; gap:1rem; margin-top:1.5rem;">
                <button type="submit" class="btn" style="background-color:#dc3545;">Yes, Delete My Account</button>
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('deleteAccountModal').style.display='none'">Cancel</button>
            </div>
        </form>
    </div>
</div>

<?php if($errors->any()): ?>
<script>
    // Show modal if there are validation errors
    document.getElementById('deleteAccountModal').style.display='block';
</script>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8_2\htdocs\DuckVintage\resources\views/profile/show.blade.php ENDPATH**/ ?>