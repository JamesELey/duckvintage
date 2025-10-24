<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::published()
            ->with('author')
            ->latest('published_at')
            ->paginate(12);
            
        return view('blog.index', compact('posts'));
    }

    public function show(BlogPost $blog)
    {
        // Only show published posts to public
        if ($blog->status !== 'published' || ($blog->published_at && $blog->published_at->isFuture())) {
            abort(404);
        }

        // Increment view count
        $blog->incrementViews();

        // Get related posts
        $relatedPosts = BlogPost::published()
            ->where('id', '!=', $blog->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('blog.show', compact('blog', 'relatedPosts'));
    }
}

