<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;

class ProductTest extends TestCase
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
    public function user_can_view_products_page()
    {
        $response = $this->get('/products');
        
        $response->assertStatus(200);
        $response->assertViewIs('products.index');
    }

    /** @test */
    public function user_can_view_single_product()
    {
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
        ]);

        $product = Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'description' => 'Test description',
            'price' => 29.99,
            'sku' => 'TEST-001',
            'stock_quantity' => 10,
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $response = $this->get("/products/{$product->slug}");
        
        $response->assertStatus(200);
        $response->assertViewIs('products.show');
        $response->assertSee($product->name);
    }

    /** @test */
    public function admin_can_view_products_management()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        $response = $this->get('/admin/products');
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.products.index');
    }

    /** @test */
    public function admin_can_create_product()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
        ]);

        $this->actingAs($admin);

        $productData = [
            'name' => 'New Product',
            'description' => 'Product description',
            'price' => 39.99,
            'sale_price' => 29.99,
            'sku' => 'NEW-001',
            'stock_quantity' => 15,
            'category_id' => $category->id,
            'sizes' => ['S', 'M', 'L'],
            'colors' => ['Red', 'Blue'],
            'is_active' => true,
            'is_featured' => true,
        ];

        $response = $this->post('/admin/products', $productData);

        $response->assertRedirect('/admin/products');
        $this->assertDatabaseHas('products', [
            'name' => 'New Product',
            'sku' => 'NEW-001',
        ]);
    }

    /** @test */
    public function admin_can_update_product()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
        ]);

        $product = Product::create([
            'name' => 'Original Product',
            'slug' => 'original-product',
            'description' => 'Original description',
            'price' => 29.99,
            'sku' => 'ORIG-001',
            'stock_quantity' => 10,
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $this->actingAs($admin);

        $updateData = [
            'name' => 'Updated Product',
            'description' => 'Updated description',
            'price' => 49.99,
            'sale_price' => 39.99,
            'sku' => 'UPD-001',
            'stock_quantity' => 20,
            'category_id' => $category->id,
            'sizes' => ['S', 'M', 'L', 'XL'],
            'colors' => ['Red', 'Blue', 'Green'],
            'is_active' => true,
            'is_featured' => false,
        ];

        $response = $this->put("/admin/products/{$product->id}", $updateData);

        $response->assertRedirect('/admin/products');
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'sku' => 'UPD-001',
        ]);
    }

    /** @test */
    public function admin_can_delete_product()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
        ]);

        $product = Product::create([
            'name' => 'Product to Delete',
            'slug' => 'product-to-delete',
            'description' => 'Description',
            'price' => 29.99,
            'sku' => 'DEL-001',
            'stock_quantity' => 10,
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $this->actingAs($admin);

        $response = $this->delete("/admin/products/{$product->id}");

        $response->assertRedirect('/admin/products');
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /** @test */
    public function guest_cannot_access_admin_products()
    {
        $response = $this->get('/admin/products');
        
        $response->assertRedirect('/login');
    }

    /** @test */
    public function customer_cannot_access_admin_products()
    {
        $customer = User::factory()->create();
        $customer->assignRole('customer');

        $this->actingAs($customer);

        $response = $this->get('/admin/products');
        
        $response->assertStatus(403);
    }
}
