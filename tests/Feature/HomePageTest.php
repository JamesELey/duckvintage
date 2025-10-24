<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_home_page()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertViewIs('home');
    }

    /** @test */
    public function home_page_shows_categories()
    {
        $category1 = Category::create([
            'name' => 'T-Shirts',
            'slug' => 't-shirts',
            'description' => 'Vintage t-shirts',
            'is_active' => true,
        ]);

        $category2 = Category::create([
            'name' => 'Jeans',
            'slug' => 'jeans',
            'description' => 'Classic jeans',
            'is_active' => true,
        ]);

        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('T-Shirts');
        $response->assertSee('Jeans');
        $response->assertSee('Vintage t-shirts');
        $response->assertSee('Classic jeans');
    }

    /** @test */
    public function home_page_shows_featured_products()
    {
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
        ]);

        $featuredProduct = Product::create([
            'name' => 'Featured Product',
            'slug' => 'featured-product',
            'description' => 'This is a featured product',
            'price' => 29.99,
            'sale_price' => 24.99,
            'sku' => 'FEAT-001',
            'stock_quantity' => 10,
            'category_id' => $category->id,
            'is_active' => true,
            'is_featured' => true,
        ]);

        $regularProduct = Product::create([
            'name' => 'Regular Product',
            'slug' => 'regular-product',
            'description' => 'This is a regular product',
            'price' => 39.99,
            'sku' => 'REG-001',
            'stock_quantity' => 5,
            'category_id' => $category->id,
            'is_active' => true,
            'is_featured' => false,
        ]);

        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Featured Product');
        $response->assertSee('$29.99');
        $response->assertSee('$24.99');
        $response->assertDontSee('Regular Product');
    }

    /** @test */
    public function home_page_shows_hero_banner()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('fm_duck_02.png');
        $response->assertSee('fm_duck_05.png');
        $response->assertSee('fm_duck_04.png');
        $response->assertSee('Welcome to Duck Vintage');
        $response->assertSee('Quality Vintage Finds');
    }

    /** @test */
    public function home_page_shows_navigation_logo()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('duck_fav.png');
        $response->assertSee('Duck Vintage');
    }

    /** @test */
    public function home_page_handles_empty_data()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Shop by Category');
        $response->assertSee('Featured Products');
        $response->assertDontSee('No products found'); // Should not show this message
    }

    /** @test */
    public function home_page_shows_discount_percentage()
    {
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
        ]);

        $product = Product::create([
            'name' => 'Discounted Product',
            'slug' => 'discounted-product',
            'description' => 'This product is on sale',
            'price' => 100.00,
            'sale_price' => 80.00,
            'sku' => 'DISC-001',
            'stock_quantity' => 10,
            'category_id' => $category->id,
            'is_active' => true,
            'is_featured' => true,
        ]);

        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('20% OFF'); // 20% discount
    }
}
