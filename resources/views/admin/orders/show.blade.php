@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Order Details: {{ $order->order_number }}</h2>
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
                <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method ?? 'N/A')) }}</p>
                <p><strong>Payment Status:</strong> 
                    <span class="badge" style="background-color: {{ $order->payment_status === 'completed' ? '#28a745' : ($order->payment_status === 'pending' ? '#ffc107' : '#dc3545') }};">
                        {{ ucfirst($order->payment_status ?? 'N/A') }}
                    </span>
                </p>
                <p><strong>Created:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                <p><strong>Updated:</strong> {{ $order->updated_at->format('M d, Y H:i') }}</p>
            </div>
            
            <div>
                <h3>Customer Information</h3>
                <p><strong>Name:</strong> {{ $order->user->name }}</p>
                <p><strong>Email:</strong> {{ $order->user->email }}</p>
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
                            <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <h3>Update Order Status</h3>
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="form-group">
                    <label for="status" class="form-label">Order Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn">Update Status</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back to Orders</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
