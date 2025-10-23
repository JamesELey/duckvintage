<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;

class AdminDashboardTest extends TestCase
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
    public function admin_can_view_dashboard()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        $response = $this->get('/admin');
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    /** @test */
    public function dashboard_shows_correct_statistics()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Create test data
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
        ]);

        $product1 = Product::create([
            'name' => 'Product 1',
            'slug' => 'product-1',
            'description' => 'Description 1',
            'price' => 29.99,
            'sku' => 'PROD-001',
            'stock_quantity' => 10,
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $product2 = Product::create([
            'name' => 'Product 2',
            'slug' => 'product-2',
            'description' => 'Description 2',
            'price' => 39.99,
            'sku' => 'PROD-002',
            'stock_quantity' => 5,
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $customer = User::factory()->create();
        $customer->assignRole('customer');

        $order1 = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'ORD-001',
            'status' => 'pending',
            'total_amount' => 69.98,
            'shipping_address' => '123 Test St',
            'billing_address' => '123 Test St',
        ]);

        $order2 = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'ORD-002',
            'status' => 'completed',
            'total_amount' => 29.99,
            'shipping_address' => '456 Test Ave',
            'billing_address' => '456 Test Ave',
        ]);

        $this->actingAs($admin);

        $response = $this->get('/admin');
        
        $response->assertStatus(200);
        $response->assertSee('2'); // Total products
        $response->assertSee('1'); // Total categories
        $response->assertSee('2'); // Total orders
        $response->assertSee('3'); // Total users (admin + customer + 1 from factory)
        $response->assertSee('1'); // Pending orders
    }

    /** @test */
    public function dashboard_shows_recent_orders()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $customer = User::factory()->create();
        $customer->assignRole('customer');

        $order = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'ORD-001',
            'status' => 'pending',
            'total_amount' => 29.99,
            'shipping_address' => '123 Test St',
            'billing_address' => '123 Test St',
        ]);

        $this->actingAs($admin);

        $response = $this->get('/admin');
        
        $response->assertStatus(200);
        $response->assertSee('ORD-001'); // Should show the specific order number
        $response->assertSee($customer->name);
        $response->assertSee('pending');
        $response->assertSee('$29.99');
    }

    /** @test */
    public function dashboard_has_quick_action_links()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        $response = $this->get('/admin');
        
        $response->assertStatus(200);
        $response->assertSee('Add New Product');
        $response->assertSee('Add New Category');
        $response->assertSee('Add New User');
        $response->assertSee('View All Orders');
    }

    /** @test */
    public function guest_cannot_access_admin_dashboard()
    {
        $response = $this->get('/admin');
        
        $response->assertRedirect('/login');
    }

    /** @test */
    public function customer_cannot_access_admin_dashboard()
    {
        $customer = User::factory()->create();
        $customer->assignRole('customer');

        $this->actingAs($customer);

        $response = $this->get('/admin');
        
        $response->assertStatus(403);
    }

    /** @test */
    public function dashboard_handles_empty_data()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        $response = $this->get('/admin');
        
        $response->assertStatus(200);
        $response->assertSee('0'); // All counts should be 0
        $response->assertDontSee('ORD-001'); // Should not show any order numbers
    }
}
