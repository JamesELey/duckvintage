@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>User Details: {{ $user->name }}</h2>
    </div>
    <div class="card-body">
        <div class="grid grid-2">
            <div>
                <h3>Basic Information</h3>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Email Verified:</strong> {{ $user->email_verified_at ? 'Yes' : 'No' }}</p>
                <p><strong>Created:</strong> {{ $user->created_at->format('M d, Y') }}</p>
                <p><strong>Last Updated:</strong> {{ $user->updated_at->format('M d, Y') }}</p>
            </div>
            
            <div>
                <h3>Roles & Permissions</h3>
                @if($user->roles->count() > 0)
                    <p><strong>Roles:</strong></p>
                    <ul>
                        @foreach($user->roles as $role)
                            <li>
                                <span class="badge">{{ $role->name }}</span>
                                @if($role->permissions->count() > 0)
                                    <ul style="margin-left: 1rem; margin-top: 0.5rem;">
                                        @foreach($role->permissions as $permission)
                                            <li style="font-size: 0.9rem; color: #ccc;">{{ $permission->name }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p><strong>Roles:</strong> <span class="badge" style="background-color: #6c757d;">No Role Assigned</span></p>
                @endif
            </div>
        </div>

        @if($user->orders->count() > 0)
            <div style="margin-top: 2rem;">
                <h3>Order History</h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->orders->take(5) as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>${{ number_format($order->total, 2) }}</td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $order->status === 'completed' ? '#28a745' : ($order->status === 'pending' ? '#ffc107' : '#dc3545') }};">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn">View Order</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($user->orders->count() > 5)
                    <p style="text-align: center; margin-top: 1rem;">
                        <a href="{{ route('admin.orders.index', ['user' => $user->id]) }}" class="btn btn-secondary">
                            View All {{ $user->orders->count() }} Orders
                        </a>
                    </p>
                @endif
            </div>
        @endif

        <div class="form-group" style="margin-top: 2rem;">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn">Edit User</a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back to Users</a>
            
            @if($user->id !== auth()->id())
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline-block; margin-left: 1rem;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn" style="background-color: #dc3545; color: white;" onclick="return confirm('Are you sure you want to delete this user?')">
                        Delete User
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
