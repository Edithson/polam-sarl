<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Article;
use App\Enums\AccessLevel;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Article $article): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('articles', AccessLevel::AUTHOR);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Article $article): bool
    {
        $perm = $user->permissions['articles'] ?? 'none';

        if ($perm === 'full') return true;

        if ($perm === 'author') {
            return $user->id === $article->user_id;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Article $article): bool
    {
        $perm = $user->permissions['articles'] ?? 'none';

        if ($perm === 'full') return true;

        if ($perm === 'author') {
            return $user->id === $article->user_id;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Article $article): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Article $article): bool
    {
        return false;
    }
}
