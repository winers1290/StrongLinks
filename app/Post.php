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

    public static function getComments($post_id)
    {

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
            ['user_id', Auth::user()->id],
            ['object_id', $post_id],
            ['object_type', self::$object_id]
            ])->get();

          $Reactions['count'] = count($reactions);
          foreach($reactions as $r)
          {
            $Reactions[$r->Emotion->emotion] = TRUE;
          }
          return $Reactions;
        }
        else
        {
          $Reactions = NULL;
        }
      }
}
