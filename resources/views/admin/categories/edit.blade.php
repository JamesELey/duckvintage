@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Edit Category: {{ $category->name }}</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name" class="form-label">Category Name *</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <div class="alert alert-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" rows="4">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <div class="alert alert-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                    Active
                </label>
            </div>

            <div class="form-group">
                <button type="submit" class="btn">Update Category</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
