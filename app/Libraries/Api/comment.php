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

    public function __construct($user, $post_type, $post_id)
    {
      //Load user
      $this->user = $user;
      $this->post_id = $post_id;

      try
      {
        //First, let's grab the post_type ID;
        $this->object_type = \App\ObjectType::where('type', $post_type)->firstOrFail();
      }
      catch(ModelNotFoundException $e)
      {
        //Post type violation
        error_log("Comment API. Post type violation. Type was: " . $post_type);
        abort(404);
      }

      return $this;
    }

    public function put($comment_text)
    {
      $comment = new \App\ObjectComment;
      $comment->object_type = $this->object_type->id;
      $comment->object_id = $this->post_id;
      $comment->user_id = $this->user->id;
      $comment->comment = $comment_text;
      $comment->save();

      /* Due to the annoying fact that we need this as a collection, we need
       * to re-find this in the database and load it... Very inefficient :/

       * We also need to put the variable to be 'template friendly', hence
       * the ['Post']['Comments'].
      */
      $this->Comment['Post']['Comments'][] = \App\ObjectComment::find($comment->id);

      $this->success = TRUE;
      $this->returnView = TRUE;
      return $this;
    }

    public function delete($comment_id)
    {
      try
      {
        //Find the comment
        $comment = \App\ObjectComment::where([
          'id'  => $comment_id,
          'object_type' => $this->object_type->id,
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

    public function get($commentsVisible = 3, $limit = 10)
    {
      /*
       * We do not use "pages" because the amount of comments visible on the
       * page is in flux as users add more comments. We simply offset by the number
        * visible
      */
      $this->Comment['Post']['Comments'] =
        \App\ObjectComment::where([
          'object_type' => $this->object_type->id,
          'object_id' => $this->post_id,
        ])
          ->orderBy('created_at', 'DESC')
          ->limit($limit)
          ->offset($commentsVisible) // = starting number of comments
          ->get();

      $this->success = TRUE;
      $this->returnView = TRUE;
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
