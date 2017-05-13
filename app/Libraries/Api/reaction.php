<?php

namespace App\Libraries\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class reaction
{
  //Does the function report a success?
  private $success;

  //The created object
  private $reaction;

    public function __construct($post_type, $post_id, $emotion_id, $user, $method)
    {
      try
      {
        //First, let's grab the post_type ID;
        $type = \App\ObjectType::where('type', $post_type)->firstOrFail();
      }
      catch(ModelNotFoundException $e)
      {
        //Post type violation
        error_log("Reaction API. Post type violation. Type was: " . $post_type);
        abort(404);
      }

      try
      {
        //We need to check to see if this user has already reacted
        $reaction = \App\ObjectReaction::where(
          [
            ['object_id', $post_id],
            ['emotion_id', $emotion_id],
            ['user_id', $user->id],
            ['object_type', $type->id]
          ])->firstOrFail();

          //If there is a record, does the user want to delete it?
          if($method === "DELETE" && count($reaction) == 1)
          {
            //Is the user authorised?
            if($user->can('delete', $reaction))
            {
              $reaction->delete();
              $this->success = TRUE;
            }
            else
            {
              abort(403);
            }
          }

          //Otherwise, even if there is already a record, we return true anyway.
          //Obsiouly the program has not recognised its existence, and returning TRUE
          //might make it remember.
          $this->success = TRUE;
      }

      //If there is no record, create one
      catch(ModelNotFoundException $e)
      {
        $reaction = new \App\ObjectReaction;
        $reaction->object_id = $post_id;
        $reaction->emotion_id = $emotion_id;
        $reaction->user_id = $user->id;
        $reaction->object_type = $type->id;

        $this->reaction = $reaction->save();
        $this->success = TRUE;
      }
    }

    public function response()
    {
      if($this->success === TRUE)
      {
        return TRUE;
      }
      else
      {
        return FALSE;
      }
    }
}
