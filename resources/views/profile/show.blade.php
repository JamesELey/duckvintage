@extends('layouts.app')

@section('title', 'My Profile - Duck Vintage')

@section('content')
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
                    <p style="background-color: #333; padding: 0.75rem; border-radius: 4px; margin: 0;">{{ auth()->user()->name }}</p>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <p style="background-color: #333; padding: 0.75rem; border-radius: 4px; margin: 0;">{{ auth()->user()->email }}</p>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Member Since</label>
                    <p style="background-color: #333; padding: 0.75rem; border-radius: 4px; margin: 0;">{{ auth()->user()->created_at->format('F d, Y') }}</p>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Role</label>
                    <p style="background-color: #333; padding: 0.75rem; border-radius: 4px; margin: 0;">
                        @foreach(auth()->user()->roles as $role)
                            <span class="badge" style="background-color: {{ $role->name === 'admin' ? '#28a745' : '#ffc107' }}; color: #000; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; text-transform: uppercase; margin-right: 0.5rem;">
                                {{ ucfirst($role->name) }}
                            </span>
                        @endforeach
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
                    <p style="background-color: #333; padding: 0.75rem; border-radius: 4px; margin: 0; font-size: 1.5rem; color: #FFD700;">{{ auth()->user()->orders()->count() }}</p>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Items in Cart</label>
                    <p style="background-color: #333; padding: 0.75rem; border-radius: 4px; margin: 0; font-size: 1.5rem; color: #FFD700;">{{ auth()->user()->cartItems()->count() }}</p>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Total Spent</label>
                    <p style="background-color: #333; padding: 0.75rem; border-radius: 4px; margin: 0; font-size: 1.5rem; color: #FFD700;">${{ number_format(auth()->user()->orders()->sum('total_amount'), 2) }}</p>
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
            <form action="{{ route('profile.password.update') }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="form-group">
                    <label for="current_password" class="form-label">Current Password *</label>
                    <input type="password" id="current_password" name="current_password" class="form-control" required>
                    @error('current_password')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">New Password * (minimum 8 characters)</label>
                    <input type="password" id="password" name="password" class="form-control" required minlength="8">
                    @error('password')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
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
                    <a href="{{ route('profile.export-data') }}" class="btn btn-secondary">
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
                <a href="{{ route('privacy-policy') }}" style="color: #FFD700; margin-right: 1rem;">Privacy Policy</a>
                <a href="{{ route('cookie-policy') }}" style="color: #FFD700;">Cookie Policy</a>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <h3>Quick Actions</h3>
        </div>
        <div class="card-body">
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('orders.index') }}" class="btn">View My Orders</a>
                <a href="{{ route('cart.index') }}" class="btn btn-secondary">View Cart</a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Continue Shopping</a>
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}" class="btn" style="background-color: #28a745;">Admin Dashboard</a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Confirmation Modal -->
<div id="deleteAccountModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.8);">
    <div style="background-color:#1a1a1a; margin:5% auto; padding:2rem; border:2px solid #FFD700; width:90%; max-width:500px; border-radius:8px;">
        <h2 style="color:#dc3545; margin-bottom:1rem;">⚠️ Delete Account</h2>
        <p style="margin-bottom:1.5rem; line-height:1.6;">This action is <strong>permanent</strong> and cannot be undone. All your data including orders, cart items, and personal information will be deleted.</p>
        
        <form action="{{ route('profile.delete-account') }}" method="POST">
            @csrf
            @method('DELETE')
            
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

@if($errors->any())
<script>
    // Show modal if there are validation errors
    document.getElementById('deleteAccountModal').style.display='block';
</script>
@endif

@endsection
