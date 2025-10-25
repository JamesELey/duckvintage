<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isGuest = $this->faker->boolean(30); // 30% chance of being a guest review
        
        return [
            'product_id' => Product::factory(),
            'user_id' => $isGuest ? null : User::factory(),
            'name' => $this->faker->name(),
            'email' => $isGuest ? $this->faker->unique()->safeEmail() : null,
            'rating' => $this->faker->numberBetween(1, 10), // Bread slices out of 10
            'title' => $this->faker->optional(0.7)->sentence(4),
            'comment' => $this->faker->optional(0.8)->paragraphs(rand(1, 3), true),
            'is_verified_purchase' => $this->faker->boolean(40), // 40% chance of verified purchase
        ];
    }

    /**
     * Indicate that the review is from a guest.
     */
    public function guest(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => null,
        ]);
    }

    /**
     * Indicate that the review is from a verified purchase.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_verified_purchase' => true,
        ]);
    }

    /**
     * Indicate that the review has a high rating (8-10 bread slices).
     */
    public function highRating(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => $this->faker->numberBetween(8, 10),
        ]);
    }

    /**
     * Indicate that the review has a low rating (1-3 bread slices).
     */
    public function lowRating(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => $this->faker->numberBetween(1, 3),
        ]);
    }
}