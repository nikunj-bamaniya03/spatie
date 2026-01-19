<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view-product');
    }

    public function view(User $user, Product $product): bool
    {
        return $user->can('view-product');
    }

    public function create(User $user): bool
    {
        return $user->can('add-product');
    }

    public function update(User $user, Product $product): bool
    {
        return $user->can('edit-product');
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->can('delete-product');
    }
}
