<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed test data
        $this->artisan('db:seed', ['--class' => 'TestSeeder']);
    }

    /** @test */
    public function authenticated_user_can_view_profile()
    {
        $user = User::factory()->create();
        $user->assignRole('customer');
        $this->actingAs($user);

        $response = $this->get('/profile');

        $response->assertStatus(200);
        $response->assertViewIs('profile.show');
        $response->assertSee($user->name);
        $response->assertSee($user->email);
    }

    /** @test */
    public function guest_cannot_view_profile()
    {
        $response = $this->get('/profile');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function profile_shows_user_statistics()
    {
        $user = User::factory()->create();
        $user->assignRole('customer');
        $this->actingAs($user);

        $response = $this->get('/profile');

        $response->assertStatus(200);
        $response->assertSee('Total Orders');
        $response->assertSee('Items in Cart');
        $response->assertSee('Total Spent');
    }

    /** @test */
    public function profile_shows_quick_actions()
    {
        $user = User::factory()->create();
        $user->assignRole('customer');
        $this->actingAs($user);

        $response = $this->get('/profile');

        $response->assertStatus(200);
        $response->assertSee('View My Orders');
        $response->assertSee('View Cart');
        $response->assertSee('Continue Shopping');
    }

    /** @test */
    public function admin_profile_shows_admin_dashboard_link()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $this->actingAs($admin);

        $response = $this->get('/profile');

        $response->assertStatus(200);
        $response->assertSee('Admin Dashboard');
    }
}
