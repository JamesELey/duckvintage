@extends('layouts.app')

@section('title', 'Products - Duck Vintage')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Products</h1>
        <div style="display: flex; gap: 1rem; align-items: center;">
            <form method="GET" action="{{ route('products.index') }}" style="display: flex; gap: 1rem;">
                <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}" class="form-control" style="width: 200px;">
                <select name="category" class="form-control" style="width: 150px;">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn">Search</button>
            </form>
        </div>
    </div>

    @if($products->count() > 0)
        <div class="grid grid-3">
            @foreach($products as $product)
            <div class="product-card">
                <a href="{{ route('products.show', $product) }}" style="text-decoration: none; color: inherit;">
                    @if($product->images && count($product->images) > 0)
                        <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="product-image">
                    @else
                        <div class="product-image" style="background-color: #333; display: flex; align-items: center; justify-content: center; color: #FFD700;">
                            No Image
                        </div>
                    @endif
                    <div class="product-info">
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <p style="font-size: 0.9rem; color: #CCC; margin-bottom: 0.5rem;">{{ $product->category->name }}</p>
                        <div class="product-price">
                            @if($product->sale_price)
                                <span class="product-sale-price">${{ number_format($product->price, 2) }}</span>
                                ${{ number_format($product->sale_price, 2) }}
                            @else
                                ${{ number_format($product->price, 2) }}
                            @endif
                        </div>
                        @if($product->sale_price)
                            <span style="color: #FF6B6B; font-size: 0.8rem;">{{ $product->discount_percentage }}% OFF</span>
                        @endif
                        @if($product->stock_quantity <= 5 && $product->stock_quantity > 0)
                            <p style="color: #FF6B6B; font-size: 0.8rem; margin-top: 0.5rem;">Only {{ $product->stock_quantity }} left!</p>
                        @elseif($product->stock_quantity == 0)
                            <p style="color: #FF6B6B; font-size: 0.8rem; margin-top: 0.5rem;">Out of Stock</p>
                        @endif
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <div style="margin-top: 2rem;">
            {{ $products->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 4rem 0;">
            <h2>No products found</h2>
            <p>Try adjusting your search criteria or browse our categories.</p>
            <a href="{{ route('products.index') }}" class="btn">View All Products</a>
        </div>
    @endif
</div>
@endsection


