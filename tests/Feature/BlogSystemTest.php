<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\BlogPost;

class BlogSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
        
        $this->user = User::factory()->create();
    }

    /** @test */
    public function guest_can_view_blog_index()
    {
        BlogPost::factory()->count(3)->create([
            'is_published' => true,
            'published_at' => now()->subDays(1)
        ]);

        $response = $this->get('/blog');

        $response->assertStatus(200);
        $response->assertSee('Blog');
    }

    /** @test */
    public function guest_can_view_published_blog_post()
    {
        $post = BlogPost::factory()->create([
            'title' => 'Test Blog Post',
            'slug' => 'test-blog-post',
            'is_published' => true,
            'published_at' => now()->subDays(1)
        ]);

        $response = $this->get("/blog/{$post->slug}");

        $response->assertStatus(200);
        $response->assertSee('Test Blog Post');
    }

    /** @test */
    public function guest_cannot_view_unpublished_blog_post()
    {
        $post = BlogPost::factory()->create([
            'is_published' => false,
            'published_at' => null
        ]);

        $response = $this->get("/blog/{$post->slug}");

        $response->assertStatus(404);
    }

    /** @test */
    public function guest_cannot_view_future_blog_post()
    {
        $post = BlogPost::factory()->create([
            'is_published' => true,
            'published_at' => now()->addDays(1)
        ]);

        $response = $this->get("/blog/{$post->slug}");

        $response->assertStatus(404);
    }

    /** @test */
    public function admin_can_view_blog_index()
    {
        BlogPost::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)->get('/admin/blog');

        $response->assertStatus(200);
        $response->assertSee('Blog Management');
    }

    /** @test */
    public function admin_can_create_blog_post()
    {
        $postData = [
            'title' => 'New Blog Post',
            'content' => 'This is the content of the blog post.',
            'is_published' => true,
            'meta_title' => 'SEO Title',
            'meta_description' => 'SEO Description',
            'meta_keywords' => 'keyword1, keyword2'
        ];

        $response = $this->actingAs($this->admin)->post('/admin/blog', $postData);

        $response->assertRedirect('/admin/blog');
        $response->assertSessionHas('success', 'Blog post created successfully!');
        
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Blog Post',
            'user_id' => $this->admin->id
        ]);
    }

    /** @test */
    public function admin_can_update_blog_post()
    {
        $post = BlogPost::factory()->create([
            'user_id' => $this->admin->id,
            'title' => 'Original Title'
        ]);

        $response = $this->actingAs($this->admin)->patch("/admin/blog/{$post->id}", [
            'title' => 'Updated Title',
            'content' => 'Updated content',
            'status' => 'published'
        ]);

        $response->assertRedirect('/admin/blog');
        $response->assertSessionHas('success', 'Blog post updated successfully!');
        
        $post->refresh();
        $this->assertEquals('Updated Title', $post->title);
    }

    /** @test */
    public function admin_can_delete_blog_post()
    {
        $post = BlogPost::factory()->create([
            'user_id' => $this->admin->id
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/blog/{$post->id}");

        $response->assertRedirect('/admin/blog');
        $response->assertSessionHas('success', 'Blog post deleted successfully!');
        
        $this->assertDatabaseMissing('blog_posts', ['id' => $post->id]);
    }

    /** @test */
    public function non_admin_cannot_manage_blog()
    {
        $post = BlogPost::factory()->create();

        // Test create
        $response = $this->actingAs($this->user)->post('/admin/blog', [
            'title' => 'Test Post',
            'content' => 'Test content'
        ]);
        $response->assertStatus(403);

        // Test update
        $response = $this->actingAs($this->user)->patch("/admin/blog/{$post->id}", [
            'title' => 'Updated Title'
        ]);
        $response->assertStatus(403);

        // Test delete
        $response = $this->actingAs($this->user)->delete("/admin/blog/{$post->id}");
        $response->assertStatus(403);
    }

    /** @test */
    public function blog_post_validation_works()
    {
        $response = $this->actingAs($this->admin)->post('/admin/blog', [
            'title' => '',
            'content' => ''
        ]);

        $response->assertSessionHasErrors(['title', 'content']);
    }

    /** @test */
    public function blog_post_slug_is_generated_from_title()
    {
        $response = $this->actingAs($this->admin)->post('/admin/blog', [
            'title' => 'My Amazing Blog Post',
            'content' => 'This is the content.'
        ]);

        $response->assertRedirect('/admin/blog');
        
        $this->assertDatabaseHas('blog_posts', [
            'slug' => 'my-amazing-blog-post'
        ]);
    }

    /** @test */
    public function blog_post_slug_is_unique()
    {
        BlogPost::factory()->create(['slug' => 'existing-slug']);

        $response = $this->actingAs($this->admin)->post('/admin/blog', [
            'title' => 'Existing Slug',
            'content' => 'This is the content.'
        ]);

        $response->assertRedirect('/admin/blog');
        
        $this->assertDatabaseHas('blog_posts', [
            'slug' => 'existing-slug-1'
        ]);
    }

    /** @test */
    public function blog_post_shows_author()
    {
        $post = BlogPost::factory()->create([
            'user_id' => $this->admin->id,
            'is_published' => true,
            'published_at' => now()->subDays(1)
        ]);

        $response = $this->get("/blog/{$post->slug}");

        $response->assertStatus(200);
        $response->assertSee($this->admin->name);
    }

    /** @test */
    public function blog_post_has_seo_meta_tags()
    {
        $post = BlogPost::factory()->create([
            'title' => 'SEO Test Post',
            'meta_title' => 'Custom SEO Title',
            'meta_description' => 'Custom SEO Description',
            'is_published' => true,
            'published_at' => now()->subDays(1)
        ]);

        $response = $this->get("/blog/{$post->slug}");

        $response->assertStatus(200);
        $response->assertSee('Custom SEO Title');
        $response->assertSee('Custom SEO Description');
    }

    /** @test */
    public function blog_posts_are_paginated()
    {
        BlogPost::factory()->count(15)->create([
            'is_published' => true,
            'published_at' => now()->subDays(1)
        ]);

        $response = $this->get('/blog');

        $response->assertStatus(200);
        // Should show pagination links
        $response->assertSee('Next');
    }

    /** @test */
    public function blog_posts_ordered_by_published_date()
    {
        $olderPost = BlogPost::factory()->create([
            'title' => 'Older Post',
            'is_published' => true,
            'published_at' => now()->subDays(2)
        ]);

        $newerPost = BlogPost::factory()->create([
            'title' => 'Newer Post',
            'is_published' => true,
            'published_at' => now()->subDays(1)
        ]);

        $response = $this->get('/blog');

        $response->assertStatus(200);
        $newerPosition = strpos($response->getContent(), 'Newer Post');
        $olderPosition = strpos($response->getContent(), 'Older Post');
        
        $this->assertLessThan($olderPosition, $newerPosition);
    }
}
