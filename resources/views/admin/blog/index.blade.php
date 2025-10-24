@extends('layouts.app')

@section('title', 'Blog Posts Management')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Blog Posts</h2>
            <a href="{{ route('admin.blog.create') }}" class="btn">Create New Post</a>
        </div>
        <div class="card-body">
            @if($posts->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Published</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td>
                                        <strong>{{ $post->title }}</strong>
                                        <br>
                                        <small style="color: #999;">/blog/{{ $post->slug }}</small>
                                    </td>
                                    <td>{{ $post->author->name }}</td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $post->status === 'published' ? '#28a745' : '#ffc107' }}; color: #000; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">
                                            {{ ucfirst($post->status) }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($post->views) }}</td>
                                    <td>{{ $post->formatted_date }}</td>
                                    <td>
                                        <div style="display: flex; gap: 0.5rem;">
                                            @if($post->status === 'published')
                                                <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.9rem;">View</a>
                                            @endif
                                            <a href="{{ route('admin.blog.edit', $post->id) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Edit</a>
                                            <form action="{{ route('admin.blog.destroy', $post->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn" style="background-color: #dc3545; padding: 0.5rem 1rem; font-size: 0.9rem;">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 2rem;">
                    {{ $posts->links() }}
                </div>
            @else
                <p style="text-align: center; padding: 2rem;">No blog posts yet. <a href="{{ route('admin.blog.create') }}">Create your first post!</a></p>
            @endif
        </div>
    </div>
</div>
@endsection

