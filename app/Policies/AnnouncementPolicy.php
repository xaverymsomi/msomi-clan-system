<?php

namespace App\Policies;

use App\Models\Announcement;
use App\Models\User;

class AnnouncementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        // Anyone can view the announcements list
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Announcement $announcement): bool
    {
        // Anyone can view published and active announcements
        return $announcement->isActive();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create announcements') || $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Announcement $announcement): bool
    {
        return $user->hasPermissionTo('edit announcements') || 
               $user->id === $announcement->created_by || 
               $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Announcement $announcement): bool
    {
        return $user->hasPermissionTo('delete announcements') || 
               $user->id === $announcement->created_by || 
               $user->hasRole('Super Admin');
    }
}
