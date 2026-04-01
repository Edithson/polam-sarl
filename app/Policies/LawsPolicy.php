<?php

namespace App\Policies;

use App\Models\Laws;
use App\Models\User;
use App\Enums\AccessLevel;
use Illuminate\Auth\Access\Response;

class LawsPolicy
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
    public function view(User $user, Laws $laws): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('laws', AccessLevel::FULL);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Laws $laws): bool
    {
        $perm = $user->permissions['laws'] ?? 'none';

        if ($perm === 'full') return true;

        if ($perm === 'author') {
            return $user->id === $laws->user_id;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Laws $laws): bool
    {
        $perm = $user->permissions['laws'] ?? 'none';

        if ($perm === 'full') return true;

        if ($perm === 'author') {
            return $user->id === $laws->user_id;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Laws $laws): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Laws $laws): bool
    {
        return false;
    }
}
