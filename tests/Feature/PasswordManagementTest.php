<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class PasswordManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create roles
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'customer', 'guard_name' => 'web']);
    }

    /** @test */
    public function admin_can_view_user_edit_page_with_password_reset_option()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        
        $customer = User::factory()->create();
        $customer->assignRole('customer');
        
        $response = $this->actingAs($admin)->get("/admin/users/{$customer->id}/edit");
        
        $response->assertStatus(200);
        $response->assertSee('Reset Password');
    }

    /** @test */
    public function admin_can_reset_customer_password()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        
        $customer = User::factory()->create(['password' => Hash::make('oldpassword')]);
        $customer->assignRole('customer');
        
        $newPassword = 'newpassword123';
        
        $response = $this->actingAs($admin)->patch("/admin/users/{$customer->id}/reset-password", [
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);
        
        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        // Verify password was changed
        $customer->refresh();
        $this->assertTrue(Hash::check($newPassword, $customer->password));
    }

    /** @test */
    public function admin_password_reset_requires_confirmation()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        
        $customer = User::factory()->create();
        $customer->assignRole('customer');
        
        $response = $this->actingAs($admin)->patch("/admin/users/{$customer->id}/reset-password", [
            'password' => 'newpassword123',
            'password_confirmation' => 'differentpassword',
        ]);
        
        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function admin_password_reset_requires_minimum_length()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        
        $customer = User::factory()->create();
        $customer->assignRole('customer');
        
        $response = $this->actingAs($admin)->patch("/admin/users/{$customer->id}/reset-password", [
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);
        
        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function customer_cannot_reset_other_users_passwords()
    {
        $customer1 = User::factory()->create();
        $customer1->assignRole('customer');
        
        $customer2 = User::factory()->create();
        $customer2->assignRole('customer');
        
        $response = $this->actingAs($customer1)->patch("/admin/users/{$customer2->id}/reset-password", [
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);
        
        $response->assertStatus(403);
    }

    /** @test */
    public function customer_can_view_change_password_form()
    {
        $customer = User::factory()->create();
        $customer->assignRole('customer');
        
        $response = $this->actingAs($customer)->get('/profile');
        
        $response->assertStatus(200);
        $response->assertSee('Change Password');
    }

    /** @test */
    public function customer_can_change_own_password()
    {
        $customer = User::factory()->create(['password' => Hash::make('oldpassword')]);
        $customer->assignRole('customer');
        
        $response = $this->actingAs($customer)->patch('/profile/password', [
            'current_password' => 'oldpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);
        
        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        // Verify password was changed
        $customer->refresh();
        $this->assertTrue(Hash::check('newpassword123', $customer->password));
    }

    /** @test */
    public function customer_must_provide_correct_current_password()
    {
        $customer = User::factory()->create(['password' => Hash::make('oldpassword')]);
        $customer->assignRole('customer');
        
        $response = $this->actingAs($customer)->patch('/profile/password', [
            'current_password' => 'wrongpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);
        
        $response->assertSessionHasErrors('current_password');
    }

    /** @test */
    public function customer_password_change_requires_confirmation()
    {
        $customer = User::factory()->create(['password' => Hash::make('oldpassword')]);
        $customer->assignRole('customer');
        
        $response = $this->actingAs($customer)->patch('/profile/password', [
            'current_password' => 'oldpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'differentpassword',
        ]);
        
        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function guest_cannot_change_password()
    {
        $response = $this->patch('/profile/password', [
            'current_password' => 'oldpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);
        
        $response->assertRedirect('/login');
    }
}

