<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */

    public function before(User $user): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }
    
        return null;
    }

    public function viewAny(User $user): bool
    {
         return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->writer === 1;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Article $article): bool
    {
        return $user?->id === $article->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Article $article): bool
    {
        return $user->id === $article->user_id  ;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Article $article): bool
    {
        return $user->role === 'admin';
    }

    public function edit(User $user, Article $article)
    {
        return $user->id === $article->user_id;
    }
    public function approvedArticles(User $user)
    {
        return $user->isAdmin();
    }
    public function unapprovedArticles(User $user,)
    {
        return $user->isAdmin();
    }
    public function approveArticle(User $user,)
    {
        return $user->isAdmin();
    }


    
}
