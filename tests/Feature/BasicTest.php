<?php

namespace Tests\Feature;

use Tests\TestCase;

class BasicTest extends TestCase
{
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
        $response->assertSee('duck_hero_01.png');
        $response->assertSee('duck_hero_02.png');
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
}
