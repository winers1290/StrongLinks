<?php

namespace App\Libraries;

use Auth;

use Carbon\Carbon;

use App\Libraries\Pretty;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class Stream
{

  //Simply, the Objects in numeric array format
  private $unformattedPosts;

  //Array of posts ready to pass to view resource
  private $formattedPosts;

  //Array of errors occured throughout execution
  private $errors = [];

  /*
   * The Create() function will return all the data you need to display
   * information in Stream format for the user.
   *
   ^ @[String, Integer] - username, or ID.
   * defaults to null for newsfeed. user IDs. A string is often a user,
   * but could also be the word "profile" which indicated that the user is at
   * {{url('/profile')}} and we don't want to redirect to a url with their
   * name in it (nicer)
   *
   * @Integer the offset for the Steam (default = 0)
   * @Integer the limit of posts returned (currently defaults to 10)
   * @returns array
  */
  public function __construct($ID = NULL, $offset = 0, $limit = 10)
  {
    //See if it is a username
    if(is_string($ID) && $ID != NULL)
    {
      if($ID == "profile")
      {
        /*
         * Indicates they are on their own page. Authentication happens on
         * controller logic, so we can jump right in.
        */
        $User = Auth::user();
      }
      else
      {
        //Let's see if we can find the user
        try
        {
          $User = \App\User::where('username', $ID)->firstOrFail();
        }
        catch (ModelNotFoundException $e)
        {
          //This page doesn't exist
          $this->errors[] = "Username does not exist";
          return FALSE;
        }
      }
    }
    //Now see if it is an integer
    elseif(is_numeric($ID) && $ID != NULL)
    {
      //Let's see if we can find the user
      try
      {
        $User = \App\User::findOrFail($ID);
      }
      catch (ModelNotFoundException $e)
      {
        //This page doesn't exist
        $this->errors[] = "Username does not exist";
        return FALSE;
      }

      /*
       * If valid, we always want to redirect users to a link
       * containing their username. It's just nicer.
      */
      //We check that we don't need to redirect the user to their own profile
      if($User->id == Auth::user()->id)
      {
        return redirect()->route('my_profile', ["profile", $offset]);
      }
      else
      {
        return redirect()->route('profile', [$User->username, $offset]);
      }
    }

    /*
     * At this stage, we either have a list of users, or one user. If
     * the latter, let's check if they're viewing their own profile.
    */
    if(isset($User) && $ID != NULL)
    {
      $this->unformattedPosts = $this->streamQuery($User, $offset, $limit);
    }
    elseif($ID == NULL)
    {
      $this->unformattedPosts = $this->streamQuery(NULL /* User Object */, $offset, $limit);
    }

    return $this;
  }

  public function format()
  {
    //Check we have posts to work with
    if(count($this->unformattedPosts) > 0)
    {
      foreach($this->unformattedPosts as $Post)
      {

        $Created = new Carbon($Post->created_at);

        switch(get_class($Post))
        {
          case 'App\Post':

            //Get the emotions this post is tagged with
            $linkedEmotions = $Post->Emotions;
            $Emotions = [];
            foreach($linkedEmotions as $emotion)
            {
              try
              {
                $Emotions[] =
                [
                  'emotion'     => $emotion->Emotion->emotion,
                  'severity'    => $emotion->severity,
                ];
              }
              catch (\Exception $e)
              {
                //Most likely, post calls a deleted emotion. Skip it.
                continue;
              }
            }

            /*
             * We need to know on the display, whether the current user has
             * reacted to a post on the stream so we can indicate this.
             * Some non-logged in users can still see the stream, so we need
             * to check for this first
            */
            $Reactions = [];
            if(Auth::user())
            {
              $reactions = \App\PostReaction::where([['user_id', Auth::user()->id], ['post_id', $Post->id]]);
              foreach($reactions as $r)
              {
                $Reactions[] = [$r->Emotion->emotion => TRUE];
              }
            }


            $this->formattedPosts[] =
              [
                get_class($Post) =>
                  [
                    'Type'              => explode('\\', get_class($Post))[1],
                    'Attributes'        => $Post->getAttributes(),
                    'User'              => Pretty::prettyUser($Post->User),
                    'Emotions'          => $Emotions,
                    'Reactions'         => $Reactions,
                    'friendly_time'     => $Created->diffForHumans(),
                    'total_comments'    => count($Post->Comments),
                    'total_reactions'   => count($Post->Reactions),
                  ],
              ];
            break;

            case 'App\CBT':

              $this->formattedPosts[] =
                [
                  get_class($Post) =>
                    [
                      'Type'                => explode('\\', get_class($Post))[1],
                      'Reactions'           => [],
                      'Attributes'          => $Post->getAttributes(),
                      'User'                => Pretty::prettyUser($Post->User),
                      'Automatic Thoughts'  => $Post->AutomaticThoughts->toArray(),
                      'Emotions'            => $Post->Emotions->toArray(),
                      'Evidence'            => $Post->Evidence->toArray(),
                      'Rational Thoughts'   => $Post->RationalThoughts->toArray(),
                      'friendly_time'       => $Created->diffForHumans(),
                      'total_reactions'     => 0,
                      'total_comments'     => 0,
                    ],
                ];
            break;
        }

      }

      return $this;
    }
    else
    {
      return FALSE;
    }
  }

  private function streamQuery($User = NULL, $offset = 0, $limit = 10)
  {
    $posts = \DB::table('posts')
          ->select("id", "created_at", \DB::raw("'Post' as source"));

    $cbt = \DB::table('cbt')
          ->select("id", "created_at", \DB::raw("'CBT' as source"));

    if($User != NULL)
    {
      $posts->where('user_id', $User->id);
      $cbt->where('user_id', $User->id);
    }

    $union = $cbt
            ->union($posts)
            ->orderBy('created_at', 'desc')
            ->skip($offset * $limit)
            ->limit($limit)
            ->get();

    foreach($union as $item)
    {
      $model = "\App\\" . $item->source;
      try
      {
        $objects[] = $model::findOrFail($item->id);
      }
      catch (ModelNotFoundException $e)
      {
        /*
         * Soemthing wrong with database record. We don't really want to go near
         * it so let's just continue and error log
        */
        //Note: In future, will want to expand this to add tailored posts
        error_log("Something wrong with " . $item->source . " ID = " . $item->id . ": " . $e->getMessage());
        continue;
      }
    }

    return $objects;

  }

  public function getUnformattedPosts()
  {
    if(count($this->unformattedPosts) > 0)
    {
      return $this->unformattedPosts;
    }
    else
    {
     return FALSE;
    }
  }

  public function getFormattedPosts()
  {
    if(count($this->formattedPosts) > 0)
    {
      return $this->formattedPosts;
    }
    else
    {
      return FALSE;
    }

  }

  public function Validate()
  {
    if(count($this->errors) > 0)
    {
      return FALSE;
    }
    else
    {
      return TRUE;
    }
  }

}
