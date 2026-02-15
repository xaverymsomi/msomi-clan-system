<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        // Anyone can view the document list (filtering happens in controller)
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Document $document): bool
    {
        // Public documents - anyone can view
        if ($document->access_level === 'public') {
            return true;
        }

        // Require authentication for non-public documents
        if (!$user) {
            return false;
        }

        // Super Admin can view all
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        // Members level - any authenticated user
        if ($document->access_level === 'members') {
            return true;
        }

        // Elders level - check for elder role/permission
        if ($document->access_level === 'elders') {
            return $user->hasRole('Elder') || $user->hasPermissionTo('view elder documents');
        }

        // Admin level - check for admin role/permission
        if ($document->access_level === 'admin') {
            return $user->hasRole('Admin') || $user->hasPermissionTo('view admin documents');
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('upload documents') || $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Document $document): bool
    {
        return $user->hasPermissionTo('edit documents') || 
               $user->id === $document->uploaded_by || 
               $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Document $document): bool
    {
        return $user->hasPermissionTo('delete documents') || 
               $user->id === $document->uploaded_by || 
               $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can download the model.
     */
    public function download(?User $user, Document $document): bool
    {
        // Same logic as view
        return $this->view($user, $document);
    }
}
