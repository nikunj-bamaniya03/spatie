<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Step 1: Default roles create karo
        $roles = ['admin', 'user'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // Step 2: Existing users ko default 'user' role assign karo
        $userRole = Role::where('name', 'user')->first();

        foreach (User::whereDoesntHave('roles')->get() as $user) {
            $user->assignRole($userRole);
        }
    }
}
