<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;

class OrderTest extends TestCase
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
    public function admin_can_view_orders_list()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        $response = $this->get('/admin/orders');
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.orders.index');
    }

    /** @test */
    public function admin_can_view_single_order()
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

        $response = $this->get("/admin/orders/{$order->id}");
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.orders.show');
        $response->assertSee('ORD-001');
    }

    /** @test */
    public function admin_can_update_order_status()
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

        $response = $this->patch("/admin/orders/{$order->id}/status", [
            'status' => 'processing',
        ]);

        $response->assertRedirect("/admin/orders/{$order->id}");
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'processing',
        ]);
    }

    /** @test */
    public function order_status_update_requires_valid_status()
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

        $response = $this->patch("/admin/orders/{$order->id}/status", [
            'status' => 'invalid-status',
        ]);

        $response->assertSessionHasErrors(['status']);
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'pending', // Should remain unchanged
        ]);
    }

    /** @test */
    public function customer_can_view_their_orders()
    {
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

        $this->actingAs($customer);

        $response = $this->get('/orders');
        
        $response->assertStatus(200);
        $response->assertViewIs('orders.index');
        $response->assertSee('ORD-001');
    }

    /** @test */
    public function customer_can_view_single_order()
    {
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

        $this->actingAs($customer);

        $response = $this->get("/orders/{$order->id}");
        
        $response->assertStatus(200);
        $response->assertViewIs('orders.show');
        $response->assertSee('ORD-001');
    }

    /** @test */
    public function customer_cannot_view_other_customers_orders()
    {
        $customer1 = User::factory()->create();
        $customer1->assignRole('customer');

        $customer2 = User::factory()->create();
        $customer2->assignRole('customer');

        $order = Order::create([
            'user_id' => $customer2->id,
            'order_number' => 'ORD-001',
            'status' => 'pending',
            'total_amount' => 29.99,
            'shipping_address' => '123 Test St',
            'billing_address' => '123 Test St',
        ]);

        $this->actingAs($customer1);

        $response = $this->get("/orders/{$order->id}");
        
        $response->assertStatus(403);
    }

    /** @test */
    public function guest_cannot_access_orders()
    {
        $response = $this->get('/orders');
        
        $response->assertRedirect('/login');
    }

    /** @test */
    public function order_has_correct_relationships()
    {
        $customer = User::factory()->create();
        $customer->assignRole('customer');

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

        $order = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'ORD-001',
            'status' => 'pending',
            'total_amount' => 29.99,
            'shipping_address' => '123 Test St',
            'billing_address' => '123 Test St',
        ]);

        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 29.99,
        ]);

        $this->assertEquals($customer->id, $order->user_id);
        $this->assertEquals($order->id, $orderItem->order_id);
        $this->assertEquals($product->id, $orderItem->product_id);
    }
}
