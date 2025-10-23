@extends('layouts.app')

@section('title', 'Admin - Products - Duck Vintage')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Product Management</h1>
        <a href="{{ route('admin.products.create') }}" class="btn">Add New Product</a>
    </div>

    @if($products->count() > 0)
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid #333;">
                        <th style="padding: 1rem; text-align: left;">Image</th>
                        <th style="padding: 1rem; text-align: left;">Name</th>
                        <th style="padding: 1rem; text-align: left;">Category</th>
                        <th style="padding: 1rem; text-align: left;">Price</th>
                        <th style="padding: 1rem; text-align: left;">Stock</th>
                        <th style="padding: 1rem; text-align: left;">Status</th>
                        <th style="padding: 1rem; text-align: left;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr style="border-bottom: 1px solid #333;">
                        <td style="padding: 1rem;">
                            @if($product->images && count($product->images) > 0)
                                <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                            @else
                                <div style="width: 50px; height: 50px; background-color: #333; display: flex; align-items: center; justify-content: center; color: #FFD700; border-radius: 4px; font-size: 0.8rem;">
                                    No Image
                                </div>
                            @endif
                        </td>
                        <td style="padding: 1rem;">
                            <strong>{{ $product->name }}</strong>
                            <br>
                            <small style="color: #CCC;">SKU: {{ $product->sku }}</small>
                        </td>
                        <td style="padding: 1rem;">{{ $product->category->name }}</td>
                        <td style="padding: 1rem;">
                            @if($product->sale_price)
                                <span style="color: #FF6B6B; text-decoration: line-through;">${{ number_format($product->price, 2) }}</span>
                                <br>
                                <span style="color: #FFD700; font-weight: bold;">${{ number_format($product->sale_price, 2) }}</span>
                            @else
                                <span style="color: #FFD700; font-weight: bold;">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </td>
                        <td style="padding: 1rem;">
                            <span style="color: {{ $product->stock_quantity > 10 ? '#90EE90' : ($product->stock_quantity > 0 ? '#FFD700' : '#FF6B6B') }}">
                                {{ $product->stock_quantity }}
                            </span>
                        </td>
                        <td style="padding: 1rem;">
                            <span style="padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; text-transform: uppercase;
                                @if($product->is_active) background-color: #1a4d1a; color: #90EE90;
                                @else background-color: #4d1a1a; color: #FFB6C1;
                                @endif">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            @if($product->is_featured)
                                <br>
                                <span style="padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; background-color: #4d3d1a; color: #FFD700; margin-top: 0.25rem; display: inline-block;">
                                    Featured
                                </span>
                            @endif
                        </td>
                        <td style="padding: 1rem;">
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('admin.products.show', $product) }}" class="btn" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">View</a>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">Edit</a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-secondary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem; background-color: #4d1a1a; color: #FFB6C1;">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 2rem;">
            {{ $products->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 4rem 0;">
            <h2>No products found</h2>
            <p style="margin-bottom: 2rem;">Get started by adding your first product.</p>
            <a href="{{ route('admin.products.create') }}" class="btn">Add New Product</a>
        </div>
    @endif
</div>
@endsection


