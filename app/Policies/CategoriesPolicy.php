<?php

namespace App\Policies;

use App\Models\Categories;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoriesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->rol == 'admin'
            ? Response::allow()
            : Response::deny('You are not authorized to view categories.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Categories $categories): Response
    {
        return $user->rol == 'admin'
            ? Response::allow()
            : Response::deny('You are not authorized to view this category.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->rol == 'admin'
            ? Response::allow()
            : Response::deny('You are not authorized to create categories.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response
    {
        return $user->rol == 'admin'
            ? Response::allow()
            : Response::deny('You are not authorized to update this category.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response
    {
        return $user->rol == 'admin'
            ? Response::allow()
            : Response::deny('You are not authorized to delete this category.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Categories $categories): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Categories $categories): bool
    {
        //
    }
}
