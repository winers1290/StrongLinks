<?php

namespace App\Policies;

use App\User;
use App\ObjectReaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReactionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the objectReaction.
     *
     * @param  \App\User  $user
     * @param  \App\ObjectReaction  $objectReaction
     * @return mixed
     */
    public function view(User $user, ObjectReaction $objectReaction)
    {
        //
    }

    /**
     * Determine whether the user can create objectReactions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the objectReaction.
     *
     * @param  \App\User  $user
     * @param  \App\ObjectReaction  $objectReaction
     * @return mixed
     */
    public function update(User $user, ObjectReaction $objectReaction)
    {
        //
    }

    /**
     * Determine whether the user can delete the objectReaction.
     *
     * @param  \App\User  $user
     * @param  \App\ObjectReaction  $objectReaction
     * @return mixed
     */
    public function delete(User $user, ObjectReaction $objectReaction)
    {
        //Only the user who created the object can access it
        return $user->id === $objectReaction->user_id;
    }
}
