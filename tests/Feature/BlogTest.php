<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\BlogPost;
use Spatie\Permission\Models\Role;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'customer', 'guard_name' => 'web']);
    }

    /** @test */
    public function guest_can_view_blog_list()
    {
        BlogPost::factory()->published()->count(3)->create();
        
        $response = $this->get('/blog');
        
        $response->assertStatus(200);
        $response->assertSee('Blog');
    }

    /** @test */
    public function guest_can_view_published_blog_post()
    {
        $post = BlogPost::factory()->published()->create([
            'title' => 'Test Blog Post',
            'content' => 'This is test content',
        ]);
        
        $response = $this->get("/blog/{$post->slug}");
        
        $response->assertStatus(200);
        $response->assertSee('Test Blog Post');
        $response->assertSee('This is test content');
    }

    /** @test */
    public function guest_cannot_view_draft_posts()
    {
        $post = BlogPost::factory()->draft()->create();
        
        $response = $this->get("/blog/{$post->slug}");
        
        $response->assertStatus(404);
    }

    /** @test */
    public function blog_post_view_count_increments()
    {
        $post = BlogPost::factory()->published()->create(['views' => 0]);
        
        $this->get("/blog/{$post->slug}");
        
        $post->refresh();
        $this->assertEquals(1, $post->views);
    }

    /** @test */
    public function blog_post_has_seo_meta_tags()
    {
        $post = BlogPost::factory()->published()->create([
            'title' => 'SEO Test Post',
            'meta_title' => 'Custom SEO Title',
            'meta_description' => 'This is a custom SEO description',
            'meta_keywords' => 'seo, test, blog',
        ]);
        
        $response = $this->get("/blog/{$post->slug}");
        
        $response->assertSee('Custom SEO Title', false);
        $response->assertSee('This is a custom SEO description', false);
        $response->assertSee('seo, test, blog', false);
    }

    /** @test */
    public function blog_post_has_structured_data()
    {
        $post = BlogPost::factory()->published()->create();
        
        $response = $this->get("/blog/{$post->slug}");
        
        $response->assertSee('application/ld+json', false);
        $response->assertSee('BlogPosting', false);
    }

    /** @test */
    public function admin_can_view_blog_management()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        
        $response = $this->actingAs($admin)->get('/admin/blog');
        
        $response->assertStatus(200);
        $response->assertSee('Blog Posts');
    }

    /** @test */
    public function admin_can_create_blog_post()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        
        $response = $this->actingAs($admin)->post('/admin/blog', [
            'title' => 'New Blog Post',
            'content' => 'This is the content of the new post.',
            'excerpt' => 'Short excerpt',
            'meta_description' => 'Meta description for SEO',
            'status' => 'published',
        ]);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Blog Post',
            'author_id' => $admin->id,
        ]);
    }

    /** @test */
    public function blog_post_slug_is_auto_generated()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        
        $this->actingAs($admin)->post('/admin/blog', [
            'title' => 'My Awesome Blog Post',
            'content' => 'Content here',
            'status' => 'draft',
        ]);
        
        $this->assertDatabaseHas('blog_posts', [
            'slug' => 'my-awesome-blog-post',
        ]);
    }

    /** @test */
    public function duplicate_slugs_are_handled()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        
        BlogPost::factory()->create(['title' => 'Same Title', 'slug' => 'same-title']);
        
        $this->actingAs($admin)->post('/admin/blog', [
            'title' => 'Same Title',
            'content' => 'Different content',
            'status' => 'draft',
        ]);
        
        $this->assertDatabaseHas('blog_posts', [
            'slug' => 'same-title-2',
        ]);
    }

    /** @test */
    public function admin_can_edit_blog_post()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        
        $post = BlogPost::factory()->create(['author_id' => $admin->id]);
        
        $response = $this->actingAs($admin)->patch("/admin/blog/{$post->id}", [
            'title' => 'Updated Title',
            'content' => 'Updated content',
            'status' => 'published',
        ]);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('blog_posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
        ]);
    }

    /** @test */
    public function admin_can_delete_blog_post()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        
        $post = BlogPost::factory()->create(['author_id' => $admin->id]);
        
        $response = $this->actingAs($admin)->delete("/admin/blog/{$post->id}");
        
        $response->assertRedirect();
        $this->assertDatabaseMissing('blog_posts', ['id' => $post->id]);
    }

    /** @test */
    public function customer_cannot_access_blog_management()
    {
        $customer = User::factory()->create();
        $customer->assignRole('customer');
        
        $response = $this->actingAs($customer)->get('/admin/blog');
        
        $response->assertStatus(403);
    }

    /** @test */
    public function guest_cannot_access_blog_management()
    {
        $response = $this->get('/admin/blog');
        
        $response->assertRedirect('/login');
    }

    /** @test */
    public function blog_list_only_shows_published_posts()
    {
        BlogPost::factory()->published()->create(['title' => 'Published Post']);
        BlogPost::factory()->draft()->create(['title' => 'Draft Post']);
        
        $response = $this->get('/blog');
        
        $response->assertSee('Published Post');
        $response->assertDontSee('Draft Post');
    }

    /** @test */
    public function blog_post_shows_reading_time()
    {
        $longContent = str_repeat('word ', 1000); // ~1000 words = ~5 min read
        $post = BlogPost::factory()->published()->create(['content' => $longContent]);
        
        $response = $this->get("/blog/{$post->slug}");
        
        $response->assertSee('min read');
    }

    /** @test */
    public function blog_post_shows_author_name()
    {
        $author = User::factory()->create(['name' => 'John Doe']);
        $post = BlogPost::factory()->published()->create(['author_id' => $author->id]);
        
        $response = $this->get("/blog/{$post->slug}");
        
        $response->assertSee('John Doe');
    }

    /** @test */
    public function blog_post_has_canonical_url()
    {
        $post = BlogPost::factory()->published()->create();
        
        $response = $this->get("/blog/{$post->slug}");
        
        $response->assertSee('rel="canonical"', false);
    }
}

