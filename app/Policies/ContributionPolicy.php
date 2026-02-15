<?php

namespace App\Policies;

use App\Models\Contribution;
use App\Models\User;

class ContributionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view contributions') || $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Contribution $contribution): bool
    {
        return $user->hasPermissionTo('view contributions') || $user->id === $contribution->member->user_id || $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create contributions') || $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Contribution $contribution): bool
    {
        return $user->hasPermissionTo('edit contributions') || $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Contribution $contribution): bool
    {
        return $user->hasPermissionTo('delete contributions') || $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can view financial reports.
     */
    public function viewReports(User $user): bool
    {
        return $user->hasPermissionTo('view financial reports') || $user->hasRole('Super Admin');
    }
}
