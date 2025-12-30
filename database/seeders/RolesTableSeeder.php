<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Default roles create
        $roles = ['admin', 'user'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // Existing users default 'user' role assign
        $userRole = Role::where('name', 'user')->first();

        foreach (User::whereDoesntHave('roles')->get() as $user) {
            $user->assignRole($userRole);
        }
    }
}
