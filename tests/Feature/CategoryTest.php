<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create roles
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'customer', 'guard_name' => 'web']);
    }

    /** @test */
    public function user_can_view_category_page()
    {
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'description' => 'Test category description',
            'is_active' => true,
        ]);

        $response = $this->get("/categories/{$category->slug}");
        
        $response->assertStatus(200);
        $response->assertViewIs('categories.show');
        $response->assertSee($category->name);
    }

    /** @test */
    public function admin_can_view_categories_management()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        $response = $this->get('/admin/categories');
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.categories.index');
    }

    /** @test */
    public function admin_can_create_category()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        $categoryData = [
            'name' => 'New Category',
            'description' => 'New category description',
            'is_active' => true,
        ];

        $response = $this->post('/admin/categories', $categoryData);

        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('categories', [
            'name' => 'New Category',
            'slug' => 'new-category',
        ]);
    }

    /** @test */
    public function admin_can_update_category()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $category = Category::create([
            'name' => 'Original Category',
            'slug' => 'original-category',
            'description' => 'Original description',
            'is_active' => true,
        ]);

        $this->actingAs($admin);

        $updateData = [
            'name' => 'Updated Category',
            'description' => 'Updated description',
            'is_active' => false,
        ];

        $response = $this->put("/admin/categories/{$category->slug}", $updateData);

        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Updated Category',
            'slug' => 'updated-category',
        ]);
    }

    /** @test */
    public function admin_can_delete_category()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $category = Category::create([
            'name' => 'Category to Delete',
            'slug' => 'category-to-delete',
            'description' => 'Description',
            'is_active' => true,
        ]);

        $this->actingAs($admin);

        $response = $this->delete("/admin/categories/{$category->slug}");

        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    /** @test */
    public function category_requires_name()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        $categoryData = [
            'description' => 'Category without name',
            'is_active' => true,
        ];

        $response = $this->post('/admin/categories', $categoryData);

        $response->assertSessionHasErrors(['name']);
        $this->assertDatabaseMissing('categories', ['description' => 'Category without name']);
    }

    /** @test */
    public function guest_cannot_access_admin_categories()
    {
        $response = $this->get('/admin/categories');
        
        $response->assertRedirect('/login');
    }
}
