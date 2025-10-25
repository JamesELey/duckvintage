<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing products
        $products = Product::all();
        
        if ($products->isEmpty()) {
            $this->command->warn('No products found. Please run the product seeder first.');
            return;
        }

        $this->command->info('Creating bread slice reviews... 🍞');

        // Create reviews for each product
        foreach ($products as $product) {
            // Create 3-8 reviews per product
            $reviewCount = rand(3, 8);
            
            for ($i = 0; $i < $reviewCount; $i++) {
                $isGuest = rand(1, 100) <= 30; // 30% guest reviews
                
                Review::factory()
                    ->when($isGuest, fn($factory) => $factory->guest())
                    ->when(rand(1, 100) <= 40, fn($factory) => $factory->verified())
                    ->create([
                        'product_id' => $product->id,
                        'email' => $isGuest ? fake()->unique()->safeEmail() : null,
                    ]);
            }
        }

        // Create some high-rated reviews for featured products
        $featuredProducts = Product::where('is_featured', true)->get();
        foreach ($featuredProducts as $product) {
            Review::factory()
                ->highRating()
                ->verified()
                ->create([
                    'product_id' => $product->id,
                    'title' => fake()->randomElement([
                        'Amazing quality!',
                        'Perfect fit!',
                        'Love this piece!',
                        'Exactly as described!',
                        'Will definitely buy again!',
                        'Great vintage find!',
                        'Excellent condition!',
                        'Beautiful design!',
                    ]),
                    'comment' => fake()->randomElement([
                        'This is exactly what I was looking for. The quality is outstanding and it fits perfectly!',
                        'Amazing vintage piece! The condition is excellent and the style is timeless.',
                        'Love this item! Great quality and fast shipping. Highly recommend!',
                        'Perfect addition to my wardrobe. The vintage style is exactly what I wanted.',
                        'Excellent product! The quality exceeded my expectations. Will definitely shop here again.',
                        'Beautiful piece! The vintage charm is perfect and the fit is amazing.',
                        'Great find! The quality is top-notch and the style is exactly what I was looking for.',
                        'Outstanding product! Fast shipping and excellent customer service. Highly recommend!',
                    ]),
                ]);
        }

        // Create some mixed reviews to show variety
        $allProducts = Product::all();
        foreach ($allProducts->random(3) as $product) {
            // Add a low rating review
            Review::factory()
                ->lowRating()
                ->create([
                    'product_id' => $product->id,
                    'title' => fake()->randomElement([
                        'Not what I expected',
                        'Size issue',
                        'Quality concerns',
                        'Different than described',
                    ]),
                    'comment' => fake()->randomElement([
                        'The item was different than described. Not quite what I was looking for.',
                        'Had some quality issues that weren\'t mentioned in the description.',
                        'The sizing was off from what I expected. Otherwise okay.',
                        'Not quite the vintage style I was hoping for, but decent quality.',
                    ]),
                ]);
        }

        $totalReviews = Review::count();
        $this->command->info("Created {$totalReviews} bread slice reviews! 🍞");
        
        // Show some statistics
        $avgRating = Review::avg('rating');
        $verifiedCount = Review::where('is_verified_purchase', true)->count();
        $guestCount = Review::whereNull('user_id')->count();
        
        $this->command->info("Average rating: " . number_format($avgRating, 1) . "/10 bread slices");
        $this->command->info("Verified purchases: {$verifiedCount}");
        $this->command->info("Guest reviews: {$guestCount}");
    }
}