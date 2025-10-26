<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            // Product permissions
            'view products',
            'create products',
            'edit products',
            'delete products',

            // Category permissions
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',

            // Tag permissions
            'view tags',
            'create tags',
            'edit tags',
            'delete tags',

            // User permissions
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Role & Permission management
            'manage roles',
            'manage permissions',

            // Order permissions
            'view orders',
            'create orders',
            'edit orders',
            'delete orders',
            'manage all orders',

            // Location permissions
            'view location',
            'create location',
            'edit addresses',
            'delete addresses',
            'create cities',
            'edit cities',
            'delete cities',

            // Setting permissions
            'view settings',
            'create settings',
            'edit settings',
            'delete settings',

            // Driver permissions
            'view drivers',
            'create drivers',
            'edit drivers',
            'delete drivers',
            'view dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles and Assign Permissions

        // Admin - Has all permissions
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());


        // Manager - Can manage products and orders
        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo([
            'view products',
            'create products',
            'edit products',
            'view categories',
            'view tags',
            'view orders',
            'edit orders',
            'manage all orders',
            'view location',
            'create location',
            'edit addresses',
            'create cities',
            'edit cities',
            'view settings',
            'view drivers',
            'create drivers',
            'edit drivers',
            'view dashboard',

        ]);

        // Customer - Basic user permissions
        $customer = Role::create(['name' => 'customer']);
        $customer->givePermissionTo([
            'view products',
            'view categories',
            'view tags',
            'view orders',
            'create orders',
            'view location',
            'create location',
            'view settings',
            'view drivers',
        ]);

        // Create test users

        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'phone' => fake()->phoneNumber,
            'is_admin' => true,
            'password' => Hash::make('123456789'),
        ]);
        $adminUser->assignRole('admin');

        $managerUser = User::factory()->create([
            'name' => 'Manager User',
            'email' => 'manager@gmail.com',
            'phone' => fake()->phoneNumber,
            'is_admin' => true,
            'password' => Hash::make('123456789'),
        ]);
        $managerUser->assignRole('manager');

        $customerUser = User::factory()->create([
            'name' => 'Customer User',
            'email' => 'customer@gmail.com',
            'phone' => fake()->phoneNumber,
            'is_admin' => false,
            'password' => Hash::make('123456789'),
        ]);
        $customerUser->assignRole('customer');
    }
}
