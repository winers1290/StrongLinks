<?php

namespace App\Libraries\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class comment
{

  private $success = FALSE;

  private $user;
  private $post_id;
  private $object_type;
  private $comment_id;
  private $comment;

  private $returnView = FALSE;

  private $Comment;

    public function __construct($post_type, $post_id, $comment = NULL, $user, $comment_id = NULL, $method)
    {
      //Load user
      $this->user = $user;

      try
      {
        //First, let's grab the post_type ID;
        $type = \App\ObjectType::where('type', $post_type)->firstOrFail();
      }
      catch(ModelNotFoundException $e)
      {
        //Post type violation
        error_log("Comment API. Post type violation. Type was: " . $post_type);
        abort(404);
      }

      //Now, delegate depending on method
      if($method === "DELETE")
      {
        //Load variables
        $this->post_id = $post_id;
        $this->object_type = $type;
        $this->comment_id = $comment_id;

        return $this->delete($type, $post_id, $user);
      }
      elseif($method == "PUT")
      {
        //Load variables
        $this->comment = $comment;
        $this->post_id = $post_id;
        $this->object_type = $type;

        return $this->put();
      }
      else
      {
        abort(403);
      }
    }

    private function put()
    {
      $comment = new \App\ObjectComment;
      $comment->object_type = $this->object_type->id;
      $comment->object_id = $this->post_id;
      $comment->user_id = $this->user->id;
      $comment->comment = $this->comment;
      $comment->save();
      $this->Comment['Comment'] = $comment;

      $this->success = TRUE;
      $this->returnView = TRUE;
      return $this;
    }

    private function delete()
    {
      try
      {
        //Find the comment
        $comment = \App\ObjectComment::where([
          'id'  => $this->comment_id,
          'object_type' => $this->type->id,
          'object_id' => $this->post_id,
          'user_id' => $this->user->id
        ])->firstOrFail();
      }

      catch(ModelNotFoundException $e)
      {
        abort(404);
      }

      //If it exists, and user is authorised, delete it
      if($this->user->can('delete', $comment))
      {
        $comment->delete();
        $this->success = TRUE;
      }
      return $this;
    }

    public function response()
    {
      if($this->success === TRUE && $this->returnView === FALSE)
      {
        return TRUE;
      }
      elseif($this->success === TRUE && $this->returnView === TRUE)
      {
        return $this->Comment;
      }
      else
      {
        return FALSE;
      }
    }
}
