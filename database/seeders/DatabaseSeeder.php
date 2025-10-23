<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles and permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $customerRole = Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);

        // Create permissions
        Permission::firstOrCreate(['name' => 'manage products', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'manage categories', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'manage orders', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'manage users', 'guard_name' => 'web']);

        // Assign permissions to admin role
        $adminRole->givePermissionTo([
            'manage products',
            'manage categories',
            'manage orders',
            'manage users'
        ]);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@duckvintage.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Create sample customer
        $customer = User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        if (!$customer->hasRole('customer')) {
            $customer->assignRole('customer');
        }

        // Create categories
        $categories = [
            [
                'name' => 'T-Shirts',
                'slug' => 't-shirts',
                'description' => 'Vintage and retro t-shirts for every style',
                'is_active' => true,
            ],
            [
                'name' => 'Jeans',
                'slug' => 'jeans',
                'description' => 'Classic denim jeans from different eras',
                'is_active' => true,
            ],
            [
                'name' => 'Jackets',
                'slug' => 'jackets',
                'description' => 'Vintage jackets and outerwear',
                'is_active' => true,
            ],
            [
                'name' => 'Dresses',
                'slug' => 'dresses',
                'description' => 'Elegant vintage dresses for special occasions',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }

        // Create sample products
        $products = [
            [
                'name' => 'Vintage Band T-Shirt',
                'slug' => 'vintage-band-t-shirt',
                'description' => 'Classic vintage band t-shirt from the 80s. Made from 100% cotton with authentic vintage styling.',
                'price' => 29.99,
                'sale_price' => 24.99,
                'sku' => 'DV-TS-001',
                'stock_quantity' => 15,
                'category_id' => 1,
                'sizes' => ['S', 'M', 'L', 'XL'],
                'colors' => ['Black', 'White', 'Navy'],
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Classic Blue Jeans',
                'slug' => 'classic-blue-jeans',
                'description' => 'Authentic vintage blue jeans with classic fit and timeless style.',
                'price' => 59.99,
                'sku' => 'DV-JN-001',
                'stock_quantity' => 8,
                'category_id' => 2,
                'sizes' => ['28', '30', '32', '34', '36'],
                'colors' => ['Blue'],
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Leather Jacket',
                'slug' => 'leather-jacket',
                'description' => 'Genuine leather jacket with vintage styling. Perfect for adding edge to any outfit.',
                'price' => 149.99,
                'sale_price' => 129.99,
                'sku' => 'DV-JK-001',
                'stock_quantity' => 5,
                'category_id' => 3,
                'sizes' => ['S', 'M', 'L', 'XL'],
                'colors' => ['Black', 'Brown'],
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Vintage Floral Dress',
                'slug' => 'vintage-floral-dress',
                'description' => 'Beautiful vintage floral dress perfect for special occasions or everyday wear.',
                'price' => 79.99,
                'sku' => 'DV-DR-001',
                'stock_quantity' => 12,
                'category_id' => 4,
                'sizes' => ['XS', 'S', 'M', 'L'],
                'colors' => ['Floral Blue', 'Floral Pink'],
                'is_active' => true,
                'is_featured' => false,
            ],
        ];

        foreach ($products as $productData) {
            Product::firstOrCreate(
                ['slug' => $productData['slug']],
                $productData
            );
        }
    }
}

