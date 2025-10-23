@extends('layouts.app')

@section('title', 'Payment Cancelled - Duck Vintage')

@section('content')
<div class="container">
    <div style="text-align: center; padding: 3rem;">
        <div style="font-size: 4rem; color: #dc3545; margin-bottom: 1rem;">✗</div>
        <h1 style="color: #dc3545; margin-bottom: 1rem;">Payment Cancelled</h1>
        <p style="font-size: 1.2rem; margin-bottom: 2rem; color: #ccc;">Your payment was cancelled. No charges have been made to your account.</p>
        
        <div class="card" style="max-width: 500px; margin: 0 auto 2rem;">
            <div class="card-header">
                <h3>Order Details</h3>
            </div>
            <div class="card-body">
                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                <p><strong>Status:</strong> 
                    <span class="badge" style="background-color: #dc3545;">Cancelled</span>
                </p>
            </div>
        </div>
        
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('checkout') }}" class="btn">Try Again</a>
            <a href="{{ route('cart.index') }}" class="btn btn-secondary">Back to Cart</a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Continue Shopping</a>
        </div>
    </div>
</div>
@endsection
