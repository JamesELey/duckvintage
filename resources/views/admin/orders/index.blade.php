@extends('layouts.app')

@section('title', 'Orders Management')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Orders Management</h2>
    </div>
    <div class="card-body">
        @if($orders->count() > 0)
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
                        @foreach($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td>
                                    <span class="badge" style="background-color: {{ $order->status === 'completed' ? '#28a745' : ($order->status === 'pending' ? '#ffc107' : '#dc3545') }};">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn">View Details</a>
                                    
                                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" style="display: inline-block; margin-left: 0.5rem;">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="form-control" style="display: inline-block; width: auto;">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 2rem;">
                <h3>No orders found</h3>
                <p>Orders will appear here when customers make purchases.</p>
            </div>
        @endif
    </div>
</div>
@endsection
