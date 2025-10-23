@extends('layouts.app')

@section('title', 'My Orders - Duck Vintage')

@section('content')
<div class="container">
    <h1 style="margin-bottom: 2rem;">My Orders</h1>

    @if($orders->count() > 0)
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
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="badge" style="background-color: {{ $order->status === 'completed' ? '#28a745' : ($order->status === 'pending' ? '#ffc107' : '#dc3545') }};">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>${{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <a href="{{ route('orders.show', $order) }}" class="btn">View Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div style="text-align: center; padding: 3rem;">
            <h3>No orders found</h3>
            <p style="color: #ccc; margin: 1rem 0;">You haven't placed any orders yet.</p>
            <a href="{{ route('products.index') }}" class="btn">Start Shopping</a>
        </div>
    @endif
</div>
@endsection
