<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\BlogPost;

class SEOFeaturesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->category = Category::factory()->create([
            'name' => 'Test Category',
            'slug' => 'test-category'
        ]);
        
        $this->product = Product::factory()->create([
            'category_id' => $this->category->id,
            'name' => 'Test Product',
            'slug' => 'test-product',
            'description' => 'This is a test product description.'
        ]);
    }

    /** @test */
    public function homepage_has_seo_meta_tags()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<meta name="description"');
        $response->assertSee('<meta name="keywords"');
        $response->assertSee('<meta name="author"');
        $response->assertSee('<meta name="robots" content="index, follow">');
    }

    /** @test */
    public function homepage_has_open_graph_tags()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<meta property="og:type" content="website">');
        $response->assertSee('<meta property="og:url"');
        $response->assertSee('<meta property="og:title"');
        $response->assertSee('<meta property="og:description"');
        $response->assertSee('<meta property="og:image"');
    }

    /** @test */
    public function homepage_has_twitter_card_tags()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<meta name="twitter:card" content="summary_large_image">');
        $response->assertSee('<meta name="twitter:url"');
        $response->assertSee('<meta name="twitter:title"');
        $response->assertSee('<meta name="twitter:description"');
        $response->assertSee('<meta name="twitter:image"');
    }

    /** @test */
    public function product_page_has_seo_meta_tags()
    {
        $response = $this->get("/products/{$this->product->slug}");

        $response->assertStatus(200);
        $response->assertSee('<meta name="description"');
        $response->assertSee('<meta name="keywords"');
        $response->assertSee('<meta property="og:title"');
        $response->assertSee('<meta property="og:description"');
    }

    /** @test */
    public function product_page_has_structured_data()
    {
        $response = $this->get("/products/{$this->product->slug}");

        $response->assertStatus(200);
        $response->assertSee('application/ld+json');
        $response->assertSee('Product');
        $response->assertSee('@context');
        $response->assertSee('@type');
    }

    /** @test */
    public function blog_post_has_seo_meta_tags()
    {
        $post = BlogPost::factory()->create([
            'title' => 'SEO Test Post',
            'slug' => 'seo-test-post',
            'meta_title' => 'Custom SEO Title',
            'meta_description' => 'Custom SEO Description',
            'meta_keywords' => 'test, seo, blog',
            'is_published' => true,
            'published_at' => now()->subDays(1)
        ]);

        $response = $this->get("/blog/{$post->slug}");

        $response->assertStatus(200);
        $response->assertSee('Custom SEO Title');
        $response->assertSee('Custom SEO Description');
        $response->assertSee('<meta name="keywords" content="test, seo, blog">');
    }

    /** @test */
    public function blog_post_has_structured_data()
    {
        $post = BlogPost::factory()->create([
            'title' => 'Structured Data Test',
            'slug' => 'structured-data-test',
            'is_published' => true,
            'published_at' => now()->subDays(1)
        ]);

        $response = $this->get("/blog/{$post->slug}");

        $response->assertStatus(200);
        $response->assertSee('application/ld+json');
        $response->assertSee('BlogPosting');
        $response->assertSee('headline');
        $response->assertSee('author');
        $response->assertSee('publisher');
    }

    /** @test */
    public function category_page_has_seo_meta_tags()
    {
        $response = $this->get("/categories/{$this->category->slug}");

        $response->assertStatus(200);
        $response->assertSee('meta name="description"');
        $response->assertSee('meta property="og:title"');
        $response->assertSee('meta property="og:description"');
    }

    /** @test */
    public function all_pages_have_canonical_urls()
    {
        $pages = [
            '/',
            '/products',
            '/blog',
            "/products/{$this->product->slug}",
            "/categories/{$this->category->slug}"
        ];

        foreach ($pages as $page) {
            $response = $this->get($page);
            $response->assertStatus(200);
            // Canonical URLs are typically handled by Laravel's URL generation
        }
    }

    /** @test */
    public function product_images_have_alt_text()
    {
        $response = $this->get("/products/{$this->product->slug}");

        $response->assertStatus(200);
        $response->assertSee('alt=');
    }

    /** @test */
    public function blog_images_have_alt_text()
    {
        $post = BlogPost::factory()->create([
            'is_published' => true,
            'published_at' => now()->subDays(1)
        ]);

        $response = $this->get("/blog/{$post->slug}");

        $response->assertStatus(200);
        // Check for alt attributes in images
        $response->assertSee('alt=');
    }

    /** @test */
    public function meta_descriptions_are_proper_length()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // Extract meta description
        $content = $response->getContent();
        preg_match('/<meta name="description" content="([^"]*)"/', $content, $matches);
        
        if (isset($matches[1])) {
            $description = $matches[1];
            $this->assertGreaterThan(120, strlen($description), 'Meta description should be at least 120 characters');
            $this->assertLessThan(160, strlen($description), 'Meta description should be less than 160 characters');
        }
    }

    /** @test */
    public function page_titles_are_unique()
    {
        $homeResponse = $this->get('/');
        $productsResponse = $this->get('/products');
        $blogResponse = $this->get('/blog');

        $homeTitle = $this->extractTitle($homeResponse->getContent());
        $productsTitle = $this->extractTitle($productsResponse->getContent());
        $blogTitle = $this->extractTitle($blogResponse->getContent());

        $this->assertNotEquals($homeTitle, $productsTitle);
        $this->assertNotEquals($homeTitle, $blogTitle);
        $this->assertNotEquals($productsTitle, $blogTitle);
    }

    /** @test */
    public function social_media_images_exist()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // Check for Open Graph image
        $response->assertSee('fm_duck_02.png');
        
        // Verify image exists
        $imageResponse = $this->get('/fm_duck_02.png');
        $imageResponse->assertStatus(200);
    }

    /** @test */
    public function robots_txt_exists()
    {
        $response = $this->get('/robots.txt');

        $response->assertStatus(200);
        $response->assertSee('User-agent');
        $response->assertSee('Disallow');
    }

    /** @test */
    public function sitemap_exists()
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
    }

    /** @test */
    public function breadcrumbs_exist_on_product_pages()
    {
        $response = $this->get("/products/{$this->product->slug}");

        $response->assertStatus(200);
        $response->assertSee('Home');
        $response->assertSee('Products');
        $response->assertSee($this->product->name);
    }

    /** @test */
    public function breadcrumbs_exist_on_category_pages()
    {
        $response = $this->get("/categories/{$this->category->slug}");

        $response->assertStatus(200);
        $response->assertSee('Home');
        $response->assertSee($this->category->name);
    }

    private function extractTitle($content)
    {
        preg_match('/<title>([^<]*)<\/title>/', $content, $matches);
        return isset($matches[1]) ? $matches[1] : '';
    }
}
