<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class ProductSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
        
        $this->category = Category::factory()->create([
            'name' => 'Test Category',
            'slug' => 'test-category'
        ]);
    }

    /** @test */
    public function guest_can_view_products_index()
    {
        Product::factory()->count(3)->create([
            'category_id' => $this->category->id,
            'is_active' => true
        ]);

        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertSee('Products');
    }

    /** @test */
    public function guest_can_view_individual_product()
    {
        $product = Product::factory()->create([
            'category_id' => $this->category->id,
            'name' => 'Test Product',
            'slug' => 'test-product',
            'is_active' => true
        ]);

        $response = $this->get("/products/{$product->slug}");

        $response->assertStatus(200);
        $response->assertSee('Test Product');
    }

    /** @test */
    public function guest_can_view_category_products()
    {
        Product::factory()->count(3)->create([
            'category_id' => $this->category->id,
            'is_active' => true
        ]);

        $response = $this->get("/categories/{$this->category->slug}");

        $response->assertStatus(200);
        $response->assertSee('Test Category');
    }

    /** @test */
    public function admin_can_create_product()
    {
        $productData = [
            'name' => 'New Product',
            'slug' => 'new-product',
            'description' => 'Product description',
            'price' => 29.99,
            'category_id' => $this->category->id,
            'is_active' => true,
            'is_featured' => false
        ];

        $response = $this->actingAs($this->admin)->post('/admin/products', $productData);

        $response->assertRedirect('/admin/products');
        $response->assertSessionHas('success', 'Product created successfully!');
        
        $this->assertDatabaseHas('products', [
            'name' => 'New Product',
            'slug' => 'new-product'
        ]);
    }

    /** @test */
    public function admin_can_update_product()
    {
        $product = Product::factory()->create([
            'category_id' => $this->category->id,
            'name' => 'Original Name'
        ]);

        $response = $this->actingAs($this->admin)->patch("/admin/products/{$product->id}", [
            'name' => 'Updated Name',
            'slug' => 'updated-name',
            'description' => 'Updated description',
            'price' => 39.99,
            'category_id' => $this->category->id,
            'is_active' => true,
            'is_featured' => true
        ]);

        $response->assertRedirect('/admin/products');
        $response->assertSessionHas('success', 'Product updated successfully!');
        
        $product->refresh();
        $this->assertEquals('Updated Name', $product->name);
    }

    /** @test */
    public function admin_can_delete_product()
    {
        $product = Product::factory()->create([
            'category_id' => $this->category->id
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/products/{$product->id}");

        $response->assertRedirect('/admin/products');
        $response->assertSessionHas('success', 'Product deleted successfully!');
        
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /** @test */
    public function non_admin_cannot_manage_products()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $this->category->id
        ]);

        // Test create
        $response = $this->actingAs($user)->post('/admin/products', [
            'name' => 'Test Product',
            'slug' => 'test-product'
        ]);
        $response->assertStatus(403);

        // Test update
        $response = $this->actingAs($user)->patch("/admin/products/{$product->id}", [
            'name' => 'Updated Name'
        ]);
        $response->assertStatus(403);

        // Test delete
        $response = $this->actingAs($user)->delete("/admin/products/{$product->id}");
        $response->assertStatus(403);
    }

    /** @test */
    public function product_validation_works()
    {
        $response = $this->actingAs($this->admin)->post('/admin/products', [
            'name' => '',
            'slug' => '',
            'price' => 'invalid'
        ]);

        $response->assertSessionHasErrors(['name', 'slug', 'price']);
    }

    /** @test */
    public function product_slug_must_be_unique()
    {
        Product::factory()->create(['slug' => 'existing-slug']);

        $response = $this->actingAs($this->admin)->post('/admin/products', [
            'name' => 'New Product',
            'slug' => 'existing-slug',
            'price' => 29.99,
            'category_id' => $this->category->id
        ]);

        $response->assertSessionHasErrors(['slug']);
    }

    /** @test */
    public function inactive_products_not_shown_to_guests()
    {
        Product::factory()->create([
            'category_id' => $this->category->id,
            'name' => 'Inactive Product',
            'is_active' => false
        ]);

        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertDontSee('Inactive Product');
    }

    /** @test */
    public function featured_products_displayed_on_homepage()
    {
        Product::factory()->create([
            'category_id' => $this->category->id,
            'name' => 'Featured Product',
            'is_featured' => true,
            'is_active' => true
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Featured Product');
    }

    /** @test */
    public function product_shows_related_products()
    {
        $product = Product::factory()->create([
            'category_id' => $this->category->id,
            'is_active' => true
        ]);

        Product::factory()->count(3)->create([
            'category_id' => $this->category->id,
            'is_active' => true
        ]);

        $response = $this->get("/products/{$product->slug}");

        $response->assertStatus(200);
        $response->assertSee('Related Products');
    }

    /** @test */
    public function product_displays_bread_slice_ratings()
    {
        $product = Product::factory()->create([
            'category_id' => $this->category->id,
            'is_active' => true
        ]);

        $response = $this->get("/products/{$product->slug}");

        $response->assertStatus(200);
        $response->assertSee('Customer Reviews');
        $response->assertSee('🍞'); // Bread slice emoji
    }
}
