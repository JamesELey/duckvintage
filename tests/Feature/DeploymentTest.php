<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Spatie\Permission\Models\Role;

class DeploymentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function htaccess_files_exist()
    {
        // Check root .htaccess for Plesk
        $this->assertFileExists(base_path('.htaccess'), 'Root .htaccess file missing');
        
        // Check public .htaccess for Laravel
        $this->assertFileExists(public_path('.htaccess'), 'Public .htaccess file missing');
        
        // Check security .htaccess files
        $this->assertFileExists(storage_path('.htaccess'), 'Storage .htaccess file missing');
        $this->assertFileExists(base_path('bootstrap/cache/.htaccess'), 'Bootstrap cache .htaccess file missing');
    }

    /** @test */
    public function admin_seeder_creates_admin_user()
    {
        $this->artisan('db:seed', ['--class' => 'AdminUserSeeder']);
        
        $admin = User::where('email', 'admin@duckvintage.com')->first();
        
        $this->assertNotNull($admin, 'Admin user not created');
        $this->assertTrue($admin->hasRole('admin'), 'Admin does not have admin role');
    }

    /** @test */
    public function admin_seeder_is_idempotent()
    {
        // Run seeder twice
        $this->artisan('db:seed', ['--class' => 'AdminUserSeeder']);
        $this->artisan('db:seed', ['--class' => 'AdminUserSeeder']);
        
        // Should only have one admin user
        $adminCount = User::where('email', 'admin@duckvintage.com')->count();
        $this->assertEquals(1, $adminCount, 'Seeder is not idempotent');
    }

    /** @test */
    public function database_seeder_creates_all_required_data()
    {
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
        
        // Check roles exist
        $this->assertTrue(Role::where('name', 'admin')->exists(), 'Admin role not created');
        $this->assertTrue(Role::where('name', 'customer')->exists(), 'Customer role not created');
        
        // Check admin user exists
        $admin = User::where('email', 'admin@duckvintage.com')->first();
        $this->assertNotNull($admin, 'Admin user not created');
        $this->assertTrue($admin->hasRole('admin'), 'Admin does not have admin role');
        
        // Check categories exist
        $this->assertTrue(Category::where('slug', 'jeans')->exists(), 'Jeans category not created');
        $this->assertTrue(Category::where('slug', 'jackets')->exists(), 'Jackets category not created');
        $this->assertTrue(Category::where('slug', 't-shirts')->exists(), 'T-shirts category not created');
        $this->assertTrue(Category::where('slug', 'dresses')->exists(), 'Dresses category not created');
        
        // Check products exist
        $this->assertGreaterThan(0, Product::count(), 'No products created');
    }

    /** @test */
    public function database_seeder_is_idempotent()
    {
        // Run seeder twice
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
        
        // Check counts haven't doubled
        $this->assertEquals(1, User::where('email', 'admin@duckvintage.com')->count());
        $this->assertEquals(1, Category::where('slug', 'jeans')->count());
        $this->assertEquals(1, Product::where('slug', 'vintage-band-t-shirt')->count());
    }

    /** @test */
    public function critical_routes_are_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $response = $this->get('/products');
        $response->assertStatus(200);
        
        $response = $this->get('/login');
        $response->assertStatus(200);
        
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    /** @test */
    public function category_routes_work_with_slug()
    {
        $category = Category::factory()->create([
            'slug' => 'test-jeans',
            'name' => 'Test Jeans',
            'is_active' => true,
        ]);
        
        $response = $this->get("/categories/{$category->slug}");
        $response->assertStatus(200);
        $response->assertSee($category->name);
    }

    /** @test */
    public function admin_can_login_with_seeded_credentials()
    {
        $this->artisan('db:seed', ['--class' => 'AdminUserSeeder']);
        
        $response = $this->post('/login', [
            'email' => 'admin@duckvintage.com',
            'password' => 'admin123',
        ]);
        
        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs(User::where('email', 'admin@duckvintage.com')->first());
    }

    /** @test */
    public function environment_configuration_is_valid()
    {
        // Check app key is set
        $this->assertNotEmpty(config('app.key'), 'APP_KEY not set');
        
        // Check database connection works by checking migrations table exists
        $this->assertTrue(
            \Schema::hasTable('migrations'),
            'Database not properly configured - migrations table missing'
        );
    }

    /** @test */
    public function storage_is_linked()
    {
        // In production, storage should be linked
        // This test just checks the directory exists
        $this->assertTrue(
            is_dir(public_path('storage')) || config('app.env') !== 'production',
            'Storage not linked in production'
        );
    }
}

