@extends('layouts.app')

@section('title', 'Shopping Cart - Duck Vintage')

@section('content')
<div class="container">
    <h1 style="margin-bottom: 2rem;">Shopping Cart</h1>

    @if($cartItems->count() > 0)
        <div class="grid grid-2" style="gap: 3rem;">
            <!-- Cart Items -->
            <div>
                @foreach($cartItems as $item)
                <div class="card" style="margin-bottom: 1rem;">
                    <div style="display: flex; gap: 1rem;">
                        @if($item->product->images && count($item->product->images) > 0)
                            <img src="{{ asset('storage/' . $item->product->images[0]) }}" alt="{{ $item->product->name }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 4px;">
                        @else
                            <div style="width: 100px; height: 100px; background-color: #333; display: flex; align-items: center; justify-content: center; color: #FFD700; border-radius: 4px;">
                                No Image
                            </div>
                        @endif
                        
                        <div style="flex: 1;">
                            <h3 style="margin-bottom: 0.5rem;">{{ $item->product->name }}</h3>
                            <p style="color: #CCC; margin-bottom: 0.5rem;">{{ $item->product->category->name }}</p>
                            
                            @if($item->size)
                                <p style="color: #CCC; margin-bottom: 0.5rem;"><strong>Size:</strong> {{ $item->size }}</p>
                            @endif
                            
                            @if($item->color)
                                <p style="color: #CCC; margin-bottom: 0.5rem;"><strong>Color:</strong> {{ $item->color }}</p>
                            @endif
                            
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <span style="font-size: 1.2rem; font-weight: bold; color: #FFD700;">${{ number_format($item->product->current_price, 2) }}</span>
                                    <span style="color: #CCC;">x {{ $item->quantity }}</span>
                                </div>
                                
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <form method="POST" action="{{ route('cart.update') }}" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="cart_item_id" value="{{ $item->id }}">
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock_quantity }}" style="width: 60px; padding: 0.25rem; background-color: #111; border: 1px solid #333; border-radius: 4px; color: #FFD700;">
                                        <button type="submit" class="btn" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Update</button>
                                    </form>
                                    
                                    <form method="POST" action="{{ route('cart.remove') }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="cart_item_id" value="{{ $item->id }}">
                                        <button type="submit" class="btn btn-secondary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Remove</button>
                                    </form>
                                </div>
                            </div>
                            
                            <div style="margin-top: 0.5rem;">
                                <strong style="color: #FFD700;">Total: ${{ number_format($item->total_price, 2) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div>
                <div class="card">
                    <div class="card-header">
                        <h3>Order Summary</h3>
                    </div>
                    
                    <div style="margin-bottom: 1rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span>Subtotal:</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span>Tax (8%):</span>
                            <span>${{ number_format($total * 0.08, 2) }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span>Shipping:</span>
                            <span>$10.00</span>
                        </div>
                        <hr style="border-color: #333; margin: 1rem 0;">
                        <div style="display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: bold;">
                            <span>Total:</span>
                            <span style="color: #FFD700;">${{ number_format($total + ($total * 0.08) + 10, 2) }}</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('checkout') }}" class="btn" style="width: 100%; text-align: center; font-size: 1.1rem; padding: 1rem;">Proceed to Checkout</a>
                </div>
                
                <div style="margin-top: 2rem;">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary" style="width: 100%; text-align: center;">Continue Shopping</a>
                </div>
            </div>
        </div>
    @else
        <div style="text-align: center; padding: 4rem 0;">
            <h2>Your cart is empty</h2>
            <p style="margin-bottom: 2rem;">Add some products to get started!</p>
            <a href="{{ route('products.index') }}" class="btn">Shop Now</a>
        </div>
    @endif
</div>
@endsection


