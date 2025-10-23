@extends('layouts.app')

@section('title', 'Order Details - Duck Vintage')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Order Details: #{{ $order->id }}</h2>
        </div>
        <div class="card-body">
            <div class="grid grid-2">
                <div>
                    <h3>Order Information</h3>
                    <p><strong>Order ID:</strong> {{ $order->order_number }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge" style="background-color: {{ $order->status === 'completed' ? '#28a745' : ($order->status === 'pending' ? '#ffc107' : '#dc3545') }};">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                    <p><strong>Total:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                    <p><strong>Created:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                    <p><strong>Updated:</strong> {{ $order->updated_at->format('M d, Y H:i') }}</p>
                </div>
                
                <div>
                    <h3>Shipping Information</h3>
                    @if($order->shipping_address)
                        <p><strong>Shipping Address:</strong></p>
                        <div style="background-color: #333; padding: 1rem; border-radius: 4px; margin-top: 0.5rem;">
                            {{ $order->shipping_address }}
                        </div>
                    @endif
                </div>
            </div>

            <div style="margin-top: 2rem;">
                <h3>Order Items</h3>
                @if($order->items->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>SKU</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->product->sku }}</td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="border-top: 2px solid #333;">
                                    <td colspan="4" style="text-align: right;"><strong>Order Total:</strong></td>
                                    <td><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <p>No items found in this order.</p>
                @endif
            </div>

            <div class="form-group" style="margin-top: 2rem;">
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Orders</a>
            </div>
        </div>
    </div>
</div>
@endsection
