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
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ALL PERMISSIONS 
        $permissions = [
            'view-product',
            'add-product',
            'edit-product',
            'delete-product',

            'view-role',
            'add-role',
            'edit-role',
            'delete-role',

            'view-user',
            'add-user',
            'edit-user',
            'delete-user',
        ];

        // CREATE PERMISSIONS
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ROLES
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user  = Role::firstOrCreate(['name' => 'user']);

        // ADMIN → ALL PERMISSIONS
        $admin->syncPermissions($permissions);

        // USER → ONLY VIEW PRODUCT
        $user->syncPermissions(['view-product']);
    }
}
