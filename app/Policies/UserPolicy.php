<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\AccessLevel;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    private function hasFullAccess(User $user): bool
    {
        return $user->hasPermission('profile', AccessLevel::FULL);
    }

    public function viewAny(User $user): bool
    {
        return $user->hasPermission('profile', AccessLevel::VIEW);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->hasFullAccess($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Empêcher un admin de modifier son propre rôle/accès via cette policy
        // ou simplement vérifier les droits FULL
        return $this->hasFullAccess($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // On ne peut pas se supprimer soi-même
        if ($user->id === $model->id) {
            return false;
        }

        return $this->hasFullAccess($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
