@extends('layouts.app')

@section('title', 'Create Product')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Create New Product</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="name" class="form-label">Product Name *</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <div class="alert alert-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description *</label>
                <textarea id="description" name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="alert alert-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid grid-2">
                <div class="form-group">
                    <label for="price" class="form-label">Price *</label>
                    <input type="number" id="price" name="price" class="form-control" step="0.01" min="0" value="{{ old('price') }}" required>
                    @error('price')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sale_price" class="form-label">Sale Price</label>
                    <input type="number" id="sale_price" name="sale_price" class="form-control" step="0.01" min="0" value="{{ old('sale_price') }}">
                    @error('sale_price')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="grid grid-2">
                <div class="form-group">
                    <label for="sku" class="form-label">SKU *</label>
                    <input type="text" id="sku" name="sku" class="form-control" value="{{ old('sku') }}" required>
                    @error('sku')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="stock_quantity" class="form-label">Stock Quantity *</label>
                    <input type="number" id="stock_quantity" name="stock_quantity" class="form-control" min="0" value="{{ old('stock_quantity') }}" required>
                    @error('stock_quantity')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="category_id" class="form-label">Category *</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="alert alert-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid grid-2">
                <div class="form-group">
                    <label for="sizes" class="form-label">Sizes (comma-separated)</label>
                    <input type="text" id="sizes" name="sizes" class="form-control" placeholder="S, M, L, XL" value="{{ old('sizes') }}">
                    @error('sizes')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="colors" class="form-label">Colors (comma-separated)</label>
                    <input type="text" id="colors" name="colors" class="form-control" placeholder="Red, Blue, Green" value="{{ old('colors') }}">
                    @error('colors')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                @error('image')
                    <div class="alert alert-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid grid-2">
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        Active
                    </label>
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                        Featured
                    </label>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn">Create Product</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
