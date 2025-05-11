<?php

namespace App\Policies;

use App\Models\Products;
use App\Models\User;
use Illuminate\Auth\Access\Response;
class ProductsPolicy
{

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->rol == 'admin'
            ? Response::allow()
            : Response::deny('You do not have permission to create products.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response
    {
        return $user->rol == 'admin'
            ? Response::allow()
            : Response::deny('You do not have permission to update products.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response
    {
        return $user->rol == 'admin'
            ? Response::allow()
            : Response::deny('You do not have permission to delete products.');
    }

}
