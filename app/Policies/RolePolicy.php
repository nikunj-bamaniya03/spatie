<?php

namespace App\Policies;

use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePolicy
{
    /**
     * View role list
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-role');
    }

    /**
     * View single role
     */
    public function view(User $user, Role $role): bool
    {
        return $user->can('view-role');
    }

    /**
     * Create role
     */
    public function create(User $user): bool
    {
        return $user->can('add-role');
    }

    /**
     * Update role
     */
    public function update(User $user, Role $role): bool
    {
        return $user->can('edit-role');
    }

    /**
     * Delete role
     */
    public function delete(User $user, Role $role): bool
    {
        return $user->can('delete-role');
    }
}