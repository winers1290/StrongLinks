<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;

class CBT extends Model
{
  protected $table = 'cbt';

  //The object_id used to attribute an object as a "post"
  static private $object_id = 2;

	public function User()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	public function Profile()
	{
		return $this->belongsTo('App\Profile', 'user_id');
	}

  public function Emotions()
  {
      return $this->hasMany('App\CBTEmotion', 'cbt_id');
  }

  public function Evidence()
  {
      return $this->hasMany('App\CBTEvidence', 'cbt_id');
  }

  public function RationalThoughts()
  {
      return $this->hasMany('App\CBTRationalThought', 'cbt_id');
  }

  public function AutomaticThoughts()
  {
      return $this->hasMany('App\CBTAutomaticThought', 'cbt_id');
  }

  /*
   * Simply pulls all reactions by cbt_id
  */
  public static function getReactions($cbt_id)
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
        ['object_id', $cbt_id],
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
