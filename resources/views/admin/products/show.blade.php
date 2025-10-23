@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Product Details: {{ $product->name }}</h2>
    </div>
    <div class="card-body">
        <div class="grid grid-2">
            <div>
                <h3>Basic Information</h3>
                <p><strong>Name:</strong> {{ $product->name }}</p>
                <p><strong>SKU:</strong> {{ $product->sku }}</p>
                <p><strong>Description:</strong> {{ $product->description }}</p>
                <p><strong>Category:</strong> {{ $product->category->name }}</p>
            </div>
            
            <div>
                <h3>Pricing & Inventory</h3>
                <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                @if($product->sale_price)
                    <p><strong>Sale Price:</strong> ${{ number_format($product->sale_price, 2) }}</p>
                @endif
                <p><strong>Stock Quantity:</strong> {{ $product->stock_quantity }}</p>
            </div>
        </div>

        <div class="grid grid-2">
            <div>
                <h3>Product Options</h3>
                @if($product->sizes)
                    <p><strong>Sizes:</strong> {{ is_array($product->sizes) ? implode(', ', $product->sizes) : $product->sizes }}</p>
                @endif
                @if($product->colors)
                    <p><strong>Colors:</strong> {{ is_array($product->colors) ? implode(', ', $product->colors) : $product->colors }}</p>
                @endif
            </div>
            
            <div>
                <h3>Status</h3>
                <p><strong>Active:</strong> {{ $product->is_active ? 'Yes' : 'No' }}</p>
                <p><strong>Featured:</strong> {{ $product->is_featured ? 'Yes' : 'No' }}</p>
                <p><strong>Created:</strong> {{ $product->created_at->format('M d, Y') }}</p>
                <p><strong>Updated:</strong> {{ $product->updated_at->format('M d, Y') }}</p>
            </div>
        </div>

        @if($product->image)
            <div>
                <h3>Product Image</h3>
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 300px; height: auto;">
            </div>
        @endif

        <div class="form-group" style="margin-top: 2rem;">
            <a href="{{ route('admin.products.edit', $product) }}" class="btn">Edit Product</a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back to Products</a>
            
            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display: inline-block; margin-left: 1rem;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn" style="background-color: #dc3545; color: white;" onclick="return confirm('Are you sure you want to delete this product?')">
                    Delete Product
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
