<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PWAFeaturesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function manifest_json_exists()
    {
        $response = $this->get('/manifest.json');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
        
        $manifest = json_decode($response->getContent(), true);
        
        $this->assertArrayHasKey('name', $manifest);
        $this->assertArrayHasKey('short_name', $manifest);
        $this->assertArrayHasKey('start_url', $manifest);
        $this->assertArrayHasKey('display', $manifest);
        $this->assertArrayHasKey('theme_color', $manifest);
        $this->assertArrayHasKey('background_color', $manifest);
        $this->assertArrayHasKey('icons', $manifest);
    }

    /** @test */
    public function manifest_json_has_correct_values()
    {
        $response = $this->get('/manifest.json');

        $response->assertStatus(200);
        
        $manifest = json_decode($response->getContent(), true);
        
        $this->assertEquals('Duck Vintage', $manifest['name']);
        $this->assertEquals('Duck Vintage', $manifest['short_name']);
        $this->assertEquals('/', $manifest['start_url']);
        $this->assertEquals('standalone', $manifest['display']);
        $this->assertEquals('#FFD700', $manifest['theme_color']);
        $this->assertEquals('#1a1a1a', $manifest['background_color']);
    }

    /** @test */
    public function manifest_json_has_icons()
    {
        $response = $this->get('/manifest.json');

        $response->assertStatus(200);
        
        $manifest = json_decode($response->getContent(), true);
        
        $this->assertIsArray($manifest['icons']);
        $this->assertGreaterThan(0, count($manifest['icons']));
        
        foreach ($manifest['icons'] as $icon) {
            $this->assertArrayHasKey('src', $icon);
            $this->assertArrayHasKey('sizes', $icon);
            $this->assertArrayHasKey('type', $icon);
        }
    }

    /** @test */
    public function service_worker_exists()
    {
        $response = $this->get('/sw.js');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/javascript; charset=UTF-8');
        
        $content = $response->getContent();
        $this->assertStringContainsString('serviceWorker', $content);
        $this->assertStringContainsString('cache', $content);
    }

    /** @test */
    public function manifest_link_in_html_head()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<link rel="manifest" href="/manifest.json">');
    }

    /** @test */
    public function theme_color_meta_tag_exists()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<meta name="theme-color" content="#FFD700">');
    }

    /** @test */
    public function apple_mobile_web_app_meta_tags_exist()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<meta name="apple-mobile-web-app-capable" content="yes">');
        $response->assertSee('<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">');
        $response->assertSee('<meta name="apple-mobile-web-app-title" content="Duck Vintage">');
    }

    /** @test */
    public function apple_touch_icon_exists()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<link rel="apple-touch-icon" href="/duck_fav.png">');
    }

    /** @test */
    public function service_worker_registration_script_exists()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('navigator.serviceWorker.register');
        $response->assertSee('/sw.js');
    }

    /** @test */
    public function favicon_exists()
    {
        $response = $this->get('/duck_fav.png');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/png');
    }

    /** @test */
    public function favicon_links_in_html_head()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<link rel="icon" type="image/png" href="/duck_fav.png">');
        $response->assertSee('<link rel="shortcut icon" type="image/png" href="/duck_fav.png">');
    }

    /** @test */
    public function pwa_meta_tags_for_all_pages()
    {
        $pages = ['/', '/products', '/blog'];
        
        foreach ($pages as $page) {
            $response = $this->get($page);
            
            $response->assertStatus(200);
            $response->assertSee('<meta name="theme-color" content="#FFD700">');
            $response->assertSee('<link rel="manifest" href="/manifest.json">');
        }
    }

    /** @test */
    public function service_worker_caches_static_assets()
    {
        $response = $this->get('/sw.js');

        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Check for cache strategies
        $this->assertStringContainsString('cacheFirst', $content);
        $this->assertStringContainsString('networkFirst', $content);
    }

    /** @test */
    public function manifest_json_icons_are_accessible()
    {
        $response = $this->get('/manifest.json');
        $manifest = json_decode($response->getContent(), true);
        
        foreach ($manifest['icons'] as $icon) {
            $iconResponse = $this->get($icon['src']);
            $iconResponse->assertStatus(200);
        }
    }

    /** @test */
    public function pwa_works_offline_simulation()
    {
        // Test that service worker is registered
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('ServiceWorker registered');
    }
}
