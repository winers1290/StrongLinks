<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Auth;


class Post extends Model
{

  //The object_id used to attribute an object as a "post"
  static private $object_id = 1;

    public function Emotions()
    {
        return $this->hasMany('App\PostEmotion');
    }

    public function Comments()
    {
        return $this->hasMany('App\PostComment');
    }

    public function User()
    {
        return $this->belongsTo('App\User');
    }

    public static function getCommentsCount($post_id)
    {
      $comments = \App\ObjectComment::where([
        ['object_id', $post_id],
        ['object_type', self::$object_id]
      ])->count();

      return $comments;
    }

    /*
     * Simply pulls all reactions by post_id
    */
    public static function getReactions($post_id)
    {
      /*
       * We need to know on the display, whether the current user has
       * reacted to a post on the stream so we can indicate this.
       * Some non-logged in users can still see the stream, so we need
       * to check for this first
      */
      if(Auth::check())
      {
        $reactions = \App\ObjectReaction::where([
          ['object_id', $post_id],
          ['object_type', self::$object_id]
          ])->get();

        $Reactions['count'] = count($reactions);
        foreach($reactions as $r)
        {
          if($r->user_id == Auth::user()->id)
          {
            $Reactions[$r->Emotion->emotion] = TRUE;
          }
        }
        return $Reactions;
      }
      else
      {
        $Reactions = NULL;
      }
    }

    public static function getRecentComments($post_id)
    {
      $recentComments = \App\ObjectComment::where([
        ['object_id', $post_id],
        ['object_type', self::$object_id]
      ])
        ->limit(3)
        ->orderBy('created_at', 'DESC')
        ->get();

        return $recentComments;
      }
}
