@extends('layouts.app')

@section('title', 'Blog - Duck Vintage')
@section('meta_description', 'Read the latest articles about vintage fashion, styling tips, and sustainable clothing from Duck Vintage.')

@section('content')
<div class="container">
    <h1 style="margin-bottom: 2rem; text-align: center;">Duck Vintage Blog</h1>
    <p style="text-align: center; font-size: 1.1rem; margin-bottom: 3rem; color: #ccc;">
        Discover vintage fashion trends, styling tips, and stories behind our curated collection.
    </p>

    @if($posts->count() > 0)
        <div class="grid" style="gap: 2rem;">
            @foreach($posts as $post)
                <article class="card" style="height: 100%;">
                    @if($post->featured_image)
                        <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px 8px 0 0;">
                    @endif
                    <div class="card-body">
                        <h2 style="margin-bottom: 1rem;">
                            <a href="{{ route('blog.show', $post->slug) }}" style="color: #FFD700; text-decoration: none;">
                                {{ $post->title }}
                            </a>
                        </h2>
                        
                        <div style="display: flex; gap: 1rem; margin-bottom: 1rem; font-size: 0.9rem; color: #999;">
                            <span>{{ $post->formatted_date }}</span>
                            <span>•</span>
                            <span>By {{ $post->author->name }}</span>
                            <span>•</span>
                            <span>{{ $post->reading_time }} min read</span>
                        </div>

                        @if($post->excerpt)
                            <p style="margin-bottom: 1rem; line-height: 1.6;">{{ $post->excerpt }}</p>
                        @endif

                        <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-secondary">Read More</a>
                    </div>
                </article>
            @endforeach
        </div>

        <div style="margin-top: 3rem;">
            {{ $posts->links() }}
        </div>
    @else
        <div class="card">
            <div class="card-body" style="text-align: center; padding: 3rem;">
                <h2>No Posts Yet</h2>
                <p>Check back soon for exciting content about vintage fashion!</p>
            </div>
        </div>
    @endif
</div>
@endsection

