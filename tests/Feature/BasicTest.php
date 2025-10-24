<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;

class BasicTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed test data for this test class
        $this->artisan('db:seed', ['--class' => 'TestSeeder']);
    }
    /** @test */
    public function home_page_loads_successfully()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
    }

    /** @test */
    public function products_page_loads_successfully()
    {
        $response = $this->get('/products');
        
        $response->assertStatus(200);
    }

    /** @test */
    public function login_page_loads_successfully()
    {
        $response = $this->get('/login');
        
        $response->assertStatus(200);
    }

    /** @test */
    public function register_page_loads_successfully()
    {
        $response = $this->get('/register');
        
        $response->assertStatus(200);
    }

    /** @test */
    public function home_page_contains_duck_branding()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Duck Vintage');
        $response->assertSee('duck_fav.png');
        $response->assertSee('fm_duck_01.png');
        $response->assertSee('fm_duck_02.png');
    }

    /** @test */
    public function home_page_has_correct_structure()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Welcome to Duck Vintage');
        $response->assertSee('Shop by Category');
        $response->assertSee('Featured Products');
    }

    /** @test */
    public function home_page_shows_categories()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('T-Shirts');
        $response->assertSee('Jeans');
        $response->assertSee('Jackets');
        $response->assertSee('Dresses');
    }

    /** @test */
    public function home_page_shows_featured_products()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Vintage Band T-Shirt');
        $response->assertSee('Classic Blue Jeans');
        $response->assertSee('Leather Jacket');
    }
}
