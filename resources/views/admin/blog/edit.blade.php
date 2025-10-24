@extends('layouts.app')

@section('title', 'Edit Blog Post')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Edit Blog Post</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.blog.update', $blog->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="title" class="form-label">Title *</label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $blog->title) }}" required>
                    @error('title')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Current URL</label>
                    <p style="background-color: #333; padding: 0.75rem; border-radius: 4px; margin: 0;">
                        <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" style="color: #FFD700;">
                            {{ url('/blog/' . $blog->slug) }}
                        </a>
                    </p>
                </div>

                <div class="form-group">
                    <label for="excerpt" class="form-label">Excerpt</label>
                    <textarea id="excerpt" name="excerpt" class="form-control" rows="2">{{ old('excerpt', $blog->excerpt) }}</textarea>
                    @error('excerpt')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content" class="form-label">Content *</label>
                    <textarea id="content" name="content" class="form-control" rows="15" required>{{ old('content', $blog->content) }}</textarea>
                    @error('content')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="featured_image" class="form-label">Featured Image URL</label>
                    <input type="text" id="featured_image" name="featured_image" class="form-control" value="{{ old('featured_image', $blog->featured_image) }}">
                    @error('featured_image')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>

                <hr style="margin: 2rem 0; border-color: #333;">

                <h3 style="margin-bottom: 1rem; color: #FFD700;">SEO Settings</h3>

                <div class="form-group">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" id="meta_title" name="meta_title" class="form-control" value="{{ old('meta_title', $blog->meta_title) }}" maxlength="60">
                    <small style="color: #999;">Recommended: 50-60 characters</small>
                    @error('meta_title')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" class="form-control" rows="2" maxlength="160">{{ old('meta_description', $blog->meta_description) }}</textarea>
                    <small style="color: #999;">Recommended: 150-160 characters</small>
                    @error('meta_description')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                    <input type="text" id="meta_keywords" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $blog->meta_keywords) }}">
                    @error('meta_keywords')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Status *</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="draft" {{ old('status', $blog->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $blog->status) === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group" style="background-color: #1a1a1a; padding: 1rem; border-radius: 4px; border-left: 4px solid #FFD700;">
                    <h4 style="margin: 0 0 0.5rem 0; color: #FFD700;">Stats</h4>
                    <p style="margin: 0.25rem 0;">Views: <strong>{{ number_format($blog->views) }}</strong></p>
                    <p style="margin: 0.25rem 0;">Created: <strong>{{ $blog->created_at->format('F d, Y') }}</strong></p>
                    @if($blog->published_at)
                        <p style="margin: 0.25rem 0;">Published: <strong>{{ $blog->published_at->format('F d, Y') }}</strong></p>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn">Update Post</button>
                    <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

