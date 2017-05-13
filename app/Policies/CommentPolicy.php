<?php

namespace App\Policies;

use App\User;
use App\ObjectComment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the objectComment.
     *
     * @param  \App\User  $user
     * @param  \App\ObjectComment  $objectComment
     * @return mixed
     */
    public function view(User $user, ObjectComment $objectComment)
    {
        //
    }

    /**
     * Determine whether the user can create objectComments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the objectComment.
     *
     * @param  \App\User  $user
     * @param  \App\ObjectComment  $objectComment
     * @return mixed
     */
    public function update(User $user, ObjectComment $objectComment)
    {
        return $user->id === $objectComment->user_id;
    }

    /**
     * Determine whether the user can delete the objectComment.
     *
     * @param  \App\User  $user
     * @param  \App\ObjectComment  $objectComment
     * @return mixed
     */
    public function delete(User $user, ObjectComment $objectComment)
    {
        return $user->id === $objectComment->user_id;
    }
}
