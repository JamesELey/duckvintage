@extends('layouts.app')

@section('title', $blog->meta_title ?? $blog->title)
@section('meta_description', $blog->meta_description ?? $blog->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($blog->content), 160))

@section('content')
<div class="container">
    <article itemscope itemtype="http://schema.org/BlogPosting">
        <!-- Breadcrumb Navigation -->
        <nav style="margin-bottom: 2rem; font-size: 0.9rem; color: #999;">
            <a href="{{ route('home') }}" style="color: #FFD700;">Home</a> / 
            <a href="{{ route('blog.index') }}" style="color: #FFD700;">Blog</a> / 
            <span>{{ $blog->title }}</span>
        </nav>

        <!-- Featured Image -->
        @if($blog->featured_image)
            <div style="margin-bottom: 2rem;">
                <img src="{{ $blog->featured_image }}" alt="{{ $blog->title }}" itemprop="image" style="width: 100%; max-height: 500px; object-fit: cover; border-radius: 8px;">
            </div>
        @endif

        <!-- Post Header -->
        <header style="margin-bottom: 2rem;">
            <h1 itemprop="headline" style="margin-bottom: 1rem; font-size: 2.5rem;">{{ $blog->title }}</h1>
            
            <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; margin-bottom: 1rem; font-size: 0.95rem; color: #ccc;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span>📅</span>
                    <time itemprop="datePublished" datetime="{{ $blog->published_at->toIso8601String() }}">
                        {{ $blog->formatted_date }}
                    </time>
                </div>
                
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span>✍️</span>
                    <span itemprop="author" itemscope itemtype="http://schema.org/Person">
                        <span itemprop="name">{{ $blog->author->name }}</span>
                    </span>
                </div>
                
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span>📖</span>
                    <span>{{ $blog->reading_time }} min read</span>
                </div>
                
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span>👁️</span>
                    <span>{{ number_format($blog->views) }} views</span>
                </div>
            </div>

            @if($blog->excerpt)
                <p itemprop="description" style="font-size: 1.2rem; line-height: 1.6; color: #ccc; font-style: italic; padding: 1rem; background-color: #1a1a1a; border-left: 4px solid #FFD700; border-radius: 4px;">
                    {{ $blog->excerpt }}
                </p>
            @endif
        </header>

        <!-- Post Content -->
        <div itemprop="articleBody" style="line-height: 1.8; font-size: 1.1rem; margin-bottom: 3rem;">
            {!! nl2br(e($blog->content)) !!}
        </div>

        <!-- Meta Information -->
        <meta itemprop="dateModified" content="{{ $blog->updated_at->toIso8601String() }}">
        <meta itemprop="wordCount" content="{{ str_word_count(strip_tags($blog->content)) }}">
        <div itemprop="publisher" itemscope itemtype="http://schema.org/Organization" style="display: none;">
            <meta itemprop="name" content="Duck Vintage">
            <meta itemprop="url" content="{{ url('/') }}">
        </div>

        <!-- Social Sharing -->
        <div style="margin: 3rem 0; padding: 2rem; background-color: #1a1a1a; border-radius: 8px;">
            <h3 style="margin-bottom: 1rem; color: #FFD700;">Share this article</h3>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $blog->slug)) }}&text={{ urlencode($blog->title) }}" target="_blank" class="btn btn-secondary">
                    🐦 Twitter
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $blog->slug)) }}" target="_blank" class="btn btn-secondary">
                    👍 Facebook
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('blog.show', $blog->slug)) }}" target="_blank" class="btn btn-secondary">
                    💼 LinkedIn
                </a>
            </div>
        </div>
    </article>

    <!-- Related Posts -->
    @if($relatedPosts->count() > 0)
        <section style="margin-top: 4rem;">
            <h2 style="margin-bottom: 2rem; text-align: center;">Related Articles</h2>
            <div class="grid" style="gap: 2rem;">
                @foreach($relatedPosts as $related)
                    <article class="card">
                        <div class="card-body">
                            <h3 style="margin-bottom: 0.5rem;">
                                <a href="{{ route('blog.show', $related->slug) }}" style="color: #FFD700; text-decoration: none;">
                                    {{ $related->title }}
                                </a>
                            </h3>
                            <p style="font-size: 0.9rem; color: #999; margin-bottom: 1rem;">
                                {{ $related->formatted_date }} • {{ $related->reading_time }} min read
                            </p>
                            @if($related->excerpt)
                                <p style="margin-bottom: 1rem; line-height: 1.6;">{{ \Illuminate\Support\Str::limit($related->excerpt, 100) }}</p>
                            @endif
                            <a href="{{ route('blog.show', $related->slug) }}" class="btn btn-secondary">Read More</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
</div>

<!-- Structured Data (JSON-LD) for SEO -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "headline": "{{ addslashes($blog->title) }}",
  "description": "{{ addslashes($blog->meta_description ?? $blog->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($blog->content), 160)) }}",
  "image": "{{ $blog->featured_image ?? asset('fm_duck_02.png') }}",
  "author": {
    "@type": "Person",
    "name": "{{ $blog->author->name }}"
  },
  "publisher": {
    "@type": "Organization",
    "name": "Duck Vintage",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ asset('duck_logo_nav.png') }}"
    }
  },
  "datePublished": "{{ $blog->published_at->toIso8601String() }}",
  "dateModified": "{{ $blog->updated_at->toIso8601String() }}",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "{{ route('blog.show', $blog->slug) }}"
  },
  "wordCount": {{ str_word_count(strip_tags($blog->content)) }},
  "articleBody": "{{ addslashes(strip_tags($blog->content)) }}"
}
</script>

<!-- Additional SEO Tags -->
<link rel="canonical" href="{{ route('blog.show', $blog->slug) }}">
<meta property="og:type" content="article">
<meta property="article:published_time" content="{{ $blog->published_at->toIso8601String() }}">
<meta property="article:modified_time" content="{{ $blog->updated_at->toIso8601String() }}">
<meta property="article:author" content="{{ $blog->author->name }}">
@if($blog->meta_keywords)
    <meta name="keywords" content="{{ $blog->meta_keywords }}">
@endif
@endsection

