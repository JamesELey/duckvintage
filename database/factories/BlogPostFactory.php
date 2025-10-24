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
        $content = $this->faker->paragraphs(5, true);
        
        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1, 10000),
            'excerpt' => $this->faker->paragraph(),
            'content' => $content,
            'meta_title' => $title,
            'meta_description' => $this->faker->sentence(15),
            'meta_keywords' => implode(', ', $this->faker->words(5)),
            'author_id' => User::factory(),
            'status' => $this->faker->randomElement(['draft', 'published']),
            'published_at' => $this->faker->optional(0.7)->dateTimeBetween('-1 year', 'now'),
            'views' => $this->faker->numberBetween(0, 1000),
        ];
    }

    public function published()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => now()->subDays(rand(1, 30)),
        ]);
    }

    public function draft()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }
}

