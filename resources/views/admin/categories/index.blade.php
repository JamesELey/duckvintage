@extends('layouts.app')

@section('title', 'Categories Management')

@section('content')
<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Categories Management</h2>
            <a href="{{ route('admin.categories.create') }}" class="btn">Add New Category</a>
        </div>
    </div>
    <div class="card-body">
        @if($categories->count() > 0)
            <div class="grid grid-3">
                @foreach($categories as $category)
                    <div class="card">
                        <div class="card-header">
                            <h3>{{ $category->name }}</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Slug:</strong> {{ $category->slug }}</p>
                            <p><strong>Description:</strong> {{ $category->description }}</p>
                            <p><strong>Status:</strong> {{ $category->is_active ? 'Active' : 'Inactive' }}</p>
                            <p><strong>Products:</strong> {{ $category->products->count() }}</p>
                            <p><strong>Created:</strong> {{ $category->created_at->format('M d, Y') }}</p>
                        </div>
                        <div style="padding: 1rem; border-top: 1px solid #333;">
                            <a href="{{ route('admin.categories.show', $category) }}" class="btn" style="margin-right: 0.5rem;">View</a>
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-secondary" style="margin-right: 0.5rem;">Edit</a>
                            
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn" style="background-color: #dc3545; color: white;" onclick="return confirm('Are you sure you want to delete this category?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 2rem;">
                <h3>No categories found</h3>
                <p>Get started by creating your first category.</p>
                <a href="{{ route('admin.categories.create') }}" class="btn">Create Category</a>
            </div>
        @endif
    </div>
</div>
@endsection
