<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Review;
use App\Models\Category;

class ReviewSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test data
        $this->user = User::factory()->create();
        $this->category = Category::factory()->create(['name' => 'Test Category', 'slug' => 'test-category']);
        $this->product = Product::factory()->create([
            'category_id' => $this->category->id,
            'name' => 'Test Product',
            'slug' => 'test-product'
        ]);
    }

    /** @test */
    public function guest_can_view_product_reviews()
    {
        // Create some reviews with unique emails
        Review::factory()->create([
            'product_id' => $this->product->id,
            'user_id' => null,
            'name' => 'Guest User 1',
            'email' => 'guest1@example.com'
        ]);
        
        Review::factory()->create([
            'product_id' => $this->product->id,
            'user_id' => null,
            'name' => 'Guest User 2',
            'email' => 'guest2@example.com'
        ]);

        $response = $this->get("/products/{$this->product->slug}");

        $response->assertStatus(200);
        $response->assertSee('Customer Reviews');
        $response->assertSee('Guest User 1');
    }

    /** @test */
    public function guest_can_submit_review()
    {
        $reviewData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'rating' => 8,
            'title' => 'Great product!',
            'comment' => 'Really love this item.'
        ];

        $response = $this->post("/products/{$this->product->slug}/reviews", $reviewData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Thank you for your review!');
        
        $this->assertDatabaseHas('reviews', [
            'product_id' => $this->product->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'rating' => 8,
            'user_id' => null
        ]);
    }

    /** @test */
    public function logged_in_user_can_submit_review()
    {
        $response = $this->actingAs($this->user)->post("/products/{$this->product->slug}/reviews", [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'rating' => 9,
            'title' => 'Excellent!',
            'comment' => 'Perfect quality.'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Thank you for your review!');
        
        $this->assertDatabaseHas('reviews', [
            'product_id' => $this->product->id,
            'user_id' => $this->user->id,
            'rating' => 9
        ]);
    }

    /** @test */
    public function guest_cannot_submit_duplicate_review()
    {
        // Create existing review
        Review::factory()->create([
            'product_id' => $this->product->id,
            'email' => 'john@example.com',
            'name' => 'John Doe'
        ]);

        $response = $this->post("/products/{$this->product->slug}/reviews", [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'rating' => 5,
            'title' => 'Another review',
            'comment' => 'Trying to review again'
        ]);

        $response->assertSessionHasErrors(['review']);
    }

    /** @test */
    public function review_validation_works()
    {
        $response = $this->post("/products/{$this->product->slug}/reviews", [
            'name' => '',
            'email' => 'invalid-email',
            'rating' => 15, // Invalid rating
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'rating']);
    }

    /** @test */
    public function bread_slice_display_works()
    {
        $review = Review::factory()->create([
            'product_id' => $this->product->id,
            'rating' => 7
        ]);

        $response = $this->get("/products/{$this->product->slug}");
        
        $response->assertStatus(200);
        $response->assertSee('7/10 slices');
        $response->assertSee('🍞'); // Bread slice emoji
    }

    /** @test */
    public function average_rating_calculation_works()
    {
        // Create reviews with different ratings
        Review::factory()->create([
            'product_id' => $this->product->id,
            'rating' => 8
        ]);
        Review::factory()->create([
            'product_id' => $this->product->id,
            'rating' => 6
        ]);
        Review::factory()->create([
            'product_id' => $this->product->id,
            'rating' => 10
        ]);

        $response = $this->get("/products/{$this->product->slug}");
        
        $response->assertStatus(200);
        $response->assertSee('8.0'); // Average of 8, 6, 10 = 8.0
    }

    /** @test */
    public function loaf_size_scaling_works()
    {
        $review = Review::factory()->create([
            'product_id' => $this->product->id,
            'rating' => 5
        ]);

        $response = $this->get("/products/{$this->product->slug}");
        
        $response->assertStatus(200);
        $response->assertSee('Half a Loaf');
    }

    /** @test */
    public function verified_purchase_display_works()
    {
        $review = Review::factory()->create([
            'product_id' => $this->product->id,
            'is_verified_purchase' => true
        ]);

        $response = $this->get("/products/{$this->product->slug}");
        
        $response->assertStatus(200);
        $response->assertSee('✓ Verified Purchase');
    }

    /** @test */
    public function review_form_shows_for_guests()
    {
        $response = $this->get("/products/{$this->product->slug}");
        
        $response->assertStatus(200);
        $response->assertSee('Your Name *');
        $response->assertSee('Your Email *');
        $response->assertSee('Rating (Bread Slices out of 10)');
    }

    /** @test */
    public function review_form_shows_user_info_for_logged_in_users()
    {
        $response = $this->actingAs($this->user)->get("/products/{$this->product->slug}");
        
        $response->assertStatus(200);
        $response->assertSee($this->user->name);
        $response->assertSee($this->user->email);
        $response->assertSee('Using your account name');
    }

    /** @test */
    public function user_cannot_review_same_product_twice()
    {
        // Create existing review
        Review::factory()->create([
            'product_id' => $this->product->id,
            'user_id' => $this->user->id,
            'email' => $this->user->email
        ]);

        $response = $this->actingAs($this->user)->get("/products/{$this->product->slug}");
        
        $response->assertStatus(200);
        $response->assertSee('already reviewed this product');
    }
}
