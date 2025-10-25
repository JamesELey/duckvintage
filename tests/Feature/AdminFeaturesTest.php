<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\BlogPost;
use App\Models\Order;

class AdminFeaturesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
        
        $this->user = User::factory()->create();
        $this->user->assignRole('customer');
        
        $this->category = Category::factory()->create();
    }

    /** @test */
    public function admin_can_access_dashboard()
    {
        $response = $this->actingAs($this->admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Admin Dashboard');
    }

    /** @test */
    public function non_admin_cannot_access_dashboard()
    {
        $response = $this->actingAs($this->user)->get('/admin');

        $response->assertStatus(403);
    }

    /** @test */
    public function guest_cannot_access_dashboard()
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function admin_can_view_users()
    {
        User::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)->get('/admin/users');

        $response->assertStatus(200);
        $response->assertSee('Users');
    }

    /** @test */
    public function admin_can_edit_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->get("/admin/users/{$user->id}/edit");

        $response->assertStatus(200);
        $response->assertSee($user->name);
        $response->assertSee($user->email);
    }

    /** @test */
    public function admin_can_update_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->patch("/admin/users/{$user->id}", [
            'name' => 'Updated Name',
            'email' => 'updated@example.com'
        ]);

        $response->assertRedirect("/admin/users/{$user->id}/edit");
        $response->assertSessionHas('success', 'User updated successfully!');
        
        $user->refresh();
        $this->assertEquals('Updated Name', $user->name);
        $this->assertEquals('updated@example.com', $user->email);
    }

    /** @test */
    public function admin_can_reset_user_password()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->patch("/admin/users/{$user->id}/reset-password", [
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ]);

        $response->assertRedirect("/admin/users/{$user->id}/edit");
        $response->assertSessionHas('success', 'Password reset successfully!');
        
        $user->refresh();
        $this->assertTrue(\Hash::check('newpassword123', $user->password));
    }

    /** @test */
    public function admin_can_view_products()
    {
        Product::factory()->count(3)->create(['category_id' => $this->category->id]);

        $response = $this->actingAs($this->admin)->get('/admin/products');

        $response->assertStatus(200);
        $response->assertSee('Products');
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
    public function admin_can_view_categories()
    {
        Category::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)->get('/admin/categories');

        $response->assertStatus(200);
        $response->assertSee('Categories');
    }

    /** @test */
    public function admin_can_create_category()
    {
        $categoryData = [
            'name' => 'New Category',
            'slug' => 'new-category',
            'description' => 'Category description'
        ];

        $response = $this->actingAs($this->admin)->post('/admin/categories', $categoryData);

        $response->assertRedirect('/admin/categories');
        $response->assertSessionHas('success', 'Category created successfully!');
        
        $this->assertDatabaseHas('categories', [
            'name' => 'New Category',
            'slug' => 'new-category'
        ]);
    }

    /** @test */
    public function admin_can_view_orders()
    {
        Order::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)->get('/admin/orders');

        $response->assertStatus(200);
        $response->assertSee('Orders');
    }

    /** @test */
    public function admin_can_view_blog_posts()
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
    public function admin_can_delete_blog_post()
    {
        $post = BlogPost::factory()->create(['user_id' => $this->admin->id]);

        $response = $this->actingAs($this->admin)->delete("/admin/blog/{$post->id}");

        $response->assertRedirect('/admin/blog');
        $response->assertSessionHas('success', 'Blog post deleted successfully!');
        
        $this->assertDatabaseMissing('blog_posts', ['id' => $post->id]);
    }

    /** @test */
    public function admin_dashboard_shows_statistics()
    {
        Product::factory()->count(5)->create(['category_id' => $this->category->id]);
        User::factory()->count(3)->create();
        Order::factory()->count(2)->create();

        $response = $this->actingAs($this->admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('5'); // Product count
        $response->assertSee('3'); // User count
        $response->assertSee('2'); // Order count
    }

    /** @test */
    public function admin_can_assign_user_roles()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->patch("/admin/users/{$user->id}", [
            'name' => $user->name,
            'email' => $user->email,
            'roles' => ['customer']
        ]);

        $response->assertRedirect("/admin/users/{$user->id}/edit");
        
        $this->assertTrue($user->hasRole('customer'));
    }

    /** @test */
    public function admin_can_view_single_order()
    {
        $order = Order::factory()->create();

        $response = $this->actingAs($this->admin)->get("/admin/orders/{$order->id}");

        $response->assertStatus(200);
        $response->assertSee($order->order_number);
    }

    /** @test */
    public function admin_can_update_order_status()
    {
        $order = Order::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($this->admin)->patch("/admin/orders/{$order->id}", [
            'status' => 'processing'
        ]);

        $response->assertRedirect("/admin/orders/{$order->id}");
        
        $order->refresh();
        $this->assertEquals('processing', $order->status);
    }

    /** @test */
    public function admin_navigation_works()
    {
        $response = $this->actingAs($this->admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
        $response->assertSee('Products');
        $response->assertSee('Categories');
        $response->assertSee('Orders');
        $response->assertSee('Users');
        $response->assertSee('Blog');
    }

    /** @test */
    public function admin_can_export_data()
    {
        $response = $this->actingAs($this->admin)->get('/admin/export');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');
    }

    /** @test */
    public function admin_validation_works()
    {
        // Test product validation
        $response = $this->actingAs($this->admin)->post('/admin/products', [
            'name' => '',
            'price' => 'invalid'
        ]);

        $response->assertSessionHasErrors(['name', 'price']);

        // Test category validation
        $response = $this->actingAs($this->admin)->post('/admin/categories', [
            'name' => '',
            'slug' => ''
        ]);

        $response->assertSessionHasErrors(['name', 'slug']);
    }
}
