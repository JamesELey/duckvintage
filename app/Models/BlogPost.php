<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'author_id',
        'status',
        'published_at',
        'views',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the author of the blog post.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Scope a query to only include published posts.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include draft posts.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Get the formatted published date.
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->published_at ? $this->published_at->format('F d, Y') : 'Draft';
    }

    /**
     * Get the reading time in minutes.
     */
    public function getReadingTimeAttribute(): int
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200); // Average reading speed
        return max(1, $minutes);
    }

    /**
     * Increment the view count.
     */
    public function incrementViews(): void
    {
        $this->increment('views');
    }

    /**
     * Generate SEO-friendly slug from title.
     */
    public static function generateSlug(string $title, ?int $id = null): string
    {
        $slug = Str::slug($title);
        $count = static::where('slug', 'LIKE', "$slug%")
            ->when($id, fn($query) => $query->where('id', '!=', $id))
            ->count();
        
        return $count ? "{$slug}-" . ($count + 1) : $slug;
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($post) {
            if (!$post->slug) {
                $post->slug = static::generateSlug($post->title);
            }
            if (!$post->meta_title) {
                $post->meta_title = $post->title;
            }
            if (!$post->excerpt && $post->content) {
                $post->excerpt = Str::limit(strip_tags($post->content), 160);
            }
        });
    }
}

