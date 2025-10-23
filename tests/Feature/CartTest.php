<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\CartItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;

class CartTest extends TestCase
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
    public function authenticated_user_can_view_cart()
    {
        $user = User::factory()->create();
        $user->assignRole('customer');

        $this->actingAs($user);

        $response = $this->get('/cart');
        
        $response->assertStatus(200);
        $response->assertViewIs('cart.index');
    }

    /** @test */
    public function guest_cannot_view_cart()
    {
        $response = $this->get('/cart');
        
        $response->assertRedirect('/login');
    }

    /** @test */
    public function user_can_add_product_to_cart()
    {
        $user = User::factory()->create();
        $user->assignRole('customer');

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

        $this->actingAs($user);

        $cartData = [
            'product_id' => $product->id,
            'quantity' => 2,
        ];

        $response = $this->post('/cart/add', $cartData);

        $response->assertRedirect('/cart');
        $this->assertDatabaseHas('cart_items', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    /** @test */
    public function user_can_update_cart_item_quantity()
    {
        $user = User::factory()->create();
        $user->assignRole('customer');

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

        $cartItem = CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $this->actingAs($user);

        $updateData = [
            'cart_item_id' => $cartItem->id,
            'quantity' => 3,
        ];

        $response = $this->patch('/cart/update', $updateData);

        $response->assertRedirect('/cart');
        $this->assertDatabaseHas('cart_items', [
            'id' => $cartItem->id,
            'quantity' => 3,
        ]);
    }

    /** @test */
    public function user_can_remove_item_from_cart()
    {
        $user = User::factory()->create();
        $user->assignRole('customer');

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

        $cartItem = CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $this->actingAs($user);

        $response = $this->delete('/cart/remove', [
            'cart_item_id' => $cartItem->id,
        ]);

        $response->assertRedirect('/cart');
        $this->assertDatabaseMissing('cart_items', ['id' => $cartItem->id]);
    }

    /** @test */
    public function user_cannot_add_out_of_stock_product_to_cart()
    {
        $user = User::factory()->create();
        $user->assignRole('customer');

        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
        ]);

        $product = Product::create([
            'name' => 'Out of Stock Product',
            'slug' => 'out-of-stock-product',
            'description' => 'Test description',
            'price' => 29.99,
            'sku' => 'OOS-001',
            'stock_quantity' => 0,
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $this->actingAs($user);

        $cartData = [
            'product_id' => $product->id,
            'quantity' => 1,
        ];

        $response = $this->post('/cart/add', $cartData);

        $response->assertSessionHasErrors();
        $this->assertDatabaseMissing('cart_items', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    /** @test */
    public function user_cannot_add_inactive_product_to_cart()
    {
        $user = User::factory()->create();
        $user->assignRole('customer');

        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
        ]);

        $product = Product::create([
            'name' => 'Inactive Product',
            'slug' => 'inactive-product',
            'description' => 'Test description',
            'price' => 29.99,
            'sku' => 'INACT-001',
            'stock_quantity' => 10,
            'category_id' => $category->id,
            'is_active' => false,
        ]);

        $this->actingAs($user);

        $cartData = [
            'product_id' => $product->id,
            'quantity' => 1,
        ];

        $response = $this->post('/cart/add', $cartData);

        $response->assertSessionHasErrors();
        $this->assertDatabaseMissing('cart_items', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }
}
