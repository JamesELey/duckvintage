<?php

namespace Database\Factories;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(6);
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;
        while (BlogPost::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }
        
        $isPublished = $this->faker->boolean(80);
        
        return [
            'title' => $title,
            'slug' => $slug,
            'content' => $this->faker->paragraphs(rand(5, 15), true),
            'image' => $this->faker->imageUrl(800, 400, 'fashion', true),
            'user_id' => User::factory(),
            'is_published' => $isPublished,
            'published_at' => $isPublished ? $this->faker->dateTimeBetween('-1 year', 'now') : null,
            'meta_title' => $this->faker->sentence(8),
            'meta_description' => $this->faker->paragraph(3),
            'meta_keywords' => implode(', ', $this->faker->words(5)),
        ];
    }

    public function published()
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
            'published_at' => now()->subDays(rand(1, 30)),
        ]);
    }

    public function draft()
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
            'published_at' => null,
        ]);
    }
}

