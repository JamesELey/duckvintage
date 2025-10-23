@extends('layouts.app')

@section('title', 'Category Details')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Category Details: {{ $category->name }}</h2>
    </div>
    <div class="card-body">
        <div class="grid grid-2">
            <div>
                <h3>Basic Information</h3>
                <p><strong>Name:</strong> {{ $category->name }}</p>
                <p><strong>Slug:</strong> {{ $category->slug }}</p>
                <p><strong>Description:</strong> {{ $category->description ?: 'No description provided' }}</p>
                <p><strong>Status:</strong> {{ $category->is_active ? 'Active' : 'Inactive' }}</p>
            </div>
            
            <div>
                <h3>Statistics</h3>
                <p><strong>Total Products:</strong> {{ $category->products->count() }}</p>
                <p><strong>Active Products:</strong> {{ $category->products->where('is_active', true)->count() }}</p>
                <p><strong>Featured Products:</strong> {{ $category->products->where('is_featured', true)->count() }}</p>
                <p><strong>Created:</strong> {{ $category->created_at->format('M d, Y') }}</p>
                <p><strong>Updated:</strong> {{ $category->updated_at->format('M d, Y') }}</p>
            </div>
        </div>

        @if($category->products->count() > 0)
            <div style="margin-top: 2rem;">
                <h3>Products in this Category</h3>
                <div class="grid grid-3">
                    @foreach($category->products->take(6) as $product)
                        <div class="card">
                            <div class="card-body">
                                <h4>{{ $product->name }}</h4>
                                <p><strong>SKU:</strong> {{ $product->sku }}</p>
                                <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                                <p><strong>Stock:</strong> {{ $product->stock_quantity }}</p>
                                <p><strong>Status:</strong> {{ $product->is_active ? 'Active' : 'Inactive' }}</p>
                                <a href="{{ route('admin.products.show', $product) }}" class="btn">View Product</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                @if($category->products->count() > 6)
                    <p style="text-align: center; margin-top: 1rem;">
                        <a href="{{ route('admin.products.index', ['category' => $category->id]) }}" class="btn btn-secondary">
                            View All {{ $category->products->count() }} Products
                        </a>
                    </p>
                @endif
            </div>
        @endif

        <div class="form-group" style="margin-top: 2rem;">
            <a href="{{ route('admin.categories.edit', $category) }}" class="btn">Edit Category</a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back to Categories</a>
            
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: inline-block; margin-left: 1rem;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn" style="background-color: #dc3545; color: white;" onclick="return confirm('Are you sure you want to delete this category? This will also delete all products in this category.')">
                    Delete Category
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
