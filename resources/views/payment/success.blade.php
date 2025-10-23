@extends('layouts.app')

@section('title', 'Payment Successful - Duck Vintage')

@section('content')
<div class="container">
    <div style="text-align: center; padding: 3rem;">
        <div style="font-size: 4rem; color: #28a745; margin-bottom: 1rem;">✓</div>
        <h1 style="color: #28a745; margin-bottom: 1rem;">Payment Successful!</h1>
        <p style="font-size: 1.2rem; margin-bottom: 2rem; color: #ccc;">Thank you for your order. Your payment has been processed successfully.</p>
        
        <div class="card" style="max-width: 500px; margin: 0 auto 2rem;">
            <div class="card-header">
                <h3>Order Details</h3>
            </div>
            <div class="card-body">
                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                <p><strong>Status:</strong> 
                    <span class="badge" style="background-color: #28a745;">{{ ucfirst($order->status) }}</span>
                </p>
            </div>
        </div>
        
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('orders.show', $order) }}" class="btn">View Order Details</a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Continue Shopping</a>
        </div>
    </div>
</div>
@endsection
