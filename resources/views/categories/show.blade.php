@extends('layouts.app')

@section('title', $category->name . ' - Duck Vintage')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1>{{ $category->name }}</h1>
        @if($category->description)
            <p style="color: #ccc; font-size: 1.1rem;">{{ $category->description }}</p>
        @endif
    </div>

    @if($products->count() > 0)
        <div class="grid grid-3">
            @foreach($products as $product)
                <div class="product-card">
                    <div class="product-image">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 100%; background-color: #333; display: flex; align-items: center; justify-content: center; color: #666;">
                                No Image
                            </div>
                        @endif
                    </div>
                    <div class="product-info">
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <div class="product-price">
                            @if($product->sale_price)
                                <span class="product-sale-price">${{ number_format($product->price, 2) }}</span>
                                ${{ number_format($product->sale_price, 2) }}
                            @else
                                ${{ number_format($product->price, 2) }}
                            @endif
                        </div>
                        <p style="color: #ccc; font-size: 0.9rem; margin: 0.5rem 0;">{{ Str::limit($product->description, 100) }}</p>
                        <a href="{{ route('products.show', $product) }}" class="btn" style="margin-top: 1rem;">View Details</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 2rem;">
            {{ $products->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 3rem;">
            <h3>No products found in this category</h3>
            <p style="color: #ccc; margin: 1rem 0;">Check back later for new arrivals!</p>
            <a href="{{ route('products.index') }}" class="btn">Browse All Products</a>
        </div>
    @endif
</div>
@endsection
