<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create roles and permissions for tests
        $this->createRolesAndPermissions();
    }

    protected function createRolesAndPermissions()
    {
        // Create roles
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);

        // Create permissions
        Permission::firstOrCreate(['name' => 'manage products', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'manage categories', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'manage orders', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'manage users', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'manage blog', 'guard_name' => 'web']);

        // Assign permissions to admin role
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo([
            'manage products',
            'manage categories', 
            'manage orders',
            'manage users',
            'manage blog'
        ]);
    }
}