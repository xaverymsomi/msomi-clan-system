<?php

namespace App\Policies;

use App\Models\Tradition;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TraditionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Tradition $tradition): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create traditions') || $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tradition $tradition): bool
    {
        return $user->hasPermissionTo('edit traditions') || $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tradition $tradition): bool
    {
        return $user->hasPermissionTo('delete traditions') || $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Tradition $tradition): bool
    {
        return $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Tradition $tradition): bool
    {
        return $user->hasRole('Super Admin');
    }
}
