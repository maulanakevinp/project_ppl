<?php

namespace App\Policies;

use App\User;
use App\Forest;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the forest.
     *
     * @param  \App\User  $user
     * @param  \App\Forest  $forest
     * @return mixed
     */
    public function view(User $user, Forest $forest)
    {
        // Update $user authorization to view $forest here.
        return true;
    }

    /**
     * Determine whether the user can create forest.
     *
     * @param  \App\User  $user
     * @param  \App\Forest  $forest
     * @return mixed
     */
    public function create(User $user, Forest $forest)
    {
        // Update $user authorization to create $forest here.
        return true;
    }

    /**
     * Determine whether the user can update the forest.
     *
     * @param  \App\User  $user
     * @param  \App\Forest  $forest
     * @return mixed
     */
    public function update(User $user, Forest $forest)
    {
        // Update $user authorization to update $forest here.
        return true;
    }

    /**
     * Determine whether the user can delete the forest.
     *
     * @param  \App\User  $user
     * @param  \App\Forest  $forest
     * @return mixed
     */
    public function delete(User $user, Forest $forest)
    {
        // Update $user authorization to delete $forest here.
        return true;
    }
}
