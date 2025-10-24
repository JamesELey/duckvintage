@extends('layouts.app')

@section('title', 'Create Blog Post')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Create New Blog Post</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.blog.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="title" class="form-label">Title *</label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="excerpt" class="form-label">Excerpt</label>
                    <textarea id="excerpt" name="excerpt" class="form-control" rows="2" placeholder="Short summary (optional - auto-generated if left blank)">{{ old('excerpt') }}</textarea>
                    @error('excerpt')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content" class="form-label">Content *</label>
                    <textarea id="content" name="content" class="form-control" rows="15" required>{{ old('content') }}</textarea>
                    @error('content')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="featured_image" class="form-label">Featured Image URL</label>
                    <input type="text" id="featured_image" name="featured_image" class="form-control" value="{{ old('featured_image') }}" placeholder="https://example.com/image.jpg">
                    @error('featured_image')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>

                <hr style="margin: 2rem 0; border-color: #333;">

                <h3 style="margin-bottom: 1rem; color: #FFD700;">SEO Settings</h3>

                <div class="form-group">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" id="meta_title" name="meta_title" class="form-control" value="{{ old('meta_title') }}" placeholder="Leave blank to use post title" maxlength="60">
                    <small style="color: #999;">Recommended: 50-60 characters</small>
                    @error('meta_title')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" class="form-control" rows="2" placeholder="Description for search engines" maxlength="160">{{ old('meta_description') }}</textarea>
                    <small style="color: #999;">Recommended: 150-160 characters</small>
                    @error('meta_description')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                    <input type="text" id="meta_keywords" name="meta_keywords" class="form-control" value="{{ old('meta_keywords') }}" placeholder="vintage, fashion, blog">
                    <small style="color: #999;">Comma-separated keywords</small>
                    @error('meta_keywords')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Status *</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn">Create Post</button>
                    <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

