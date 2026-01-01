<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cached permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /*
        * PRODUCT MANAGEMENT PERMISSIONS
        */
        $permissions = [
            'product-view',
            'product-create',
            'product-edit',
            'product-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        /*
        * ROLES
        */
        $adminRole = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web'
        ]);

        $userRole = Role::firstOrCreate([
            'name' => 'User',
            'guard_name' => 'web'
        ]);

        /*
        * ASSIGN PERMISSIONS TO ROLES
        */

        // Admin -> All permissions
        $adminRole->syncPermissions($permissions);

        // User -> Only view product
        $userRole->syncPermissions([
            'product-view'
        ]);
    }
}
