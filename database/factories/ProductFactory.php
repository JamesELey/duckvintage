<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->words(3, true);
        
        return [
            'name' => ucwords($name),
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1, 10000),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 10, 200),
            'sale_price' => null,
            'sku' => 'DV-' . strtoupper($this->faker->unique()->bothify('??###')),
            'stock_quantity' => $this->faker->numberBetween(0, 100),
            'category_id' => Category::factory(),
            'sizes' => ['S', 'M', 'L', 'XL'],
            'colors' => ['Black', 'White', 'Blue'],
            'is_active' => true,
            'is_featured' => $this->faker->boolean(30),
        ];
    }
}

