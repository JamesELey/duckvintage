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
@endsection
