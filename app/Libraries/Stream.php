<?php

namespace App\Libraries;

use Auth;

use Carbon\Carbon;

use App\Libraries\Pretty;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Charts;

class Stream
{

  //Simply, the Objects in numeric array format
  private $unformattedPosts;

  //Array of posts ready to pass to view resource
  private $formattedPosts;

  //Array of errors occured throughout execution
  private $errors = [];

  //Do we need to redirect to /profile?
  private $redirectNeeded;

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
    //See if it is a username or the word 'profile'
    if(is_string($ID) && $ID != NULL)
    {
      if($ID == 'profile')
      {
        /*
         * Indicates they are on their own page. Authentication happens on
         * controller logic, so we can jump right in.
        */
        $User = Auth::user();
      }
      else //it is a username
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
          return $this;
        }

        /*
         * If they're accessing their own profile, we want to redirect
         * them to a nice link /profile
        */
        if($User->id == Auth::user()->id)
        {
          $this->errors[] = "Please redirect to profile";
          $this->redirectNeeded = TRUE;
          return $this;
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
        return redirect()->route('stream', ['profile', $offset]);
      }
      else
      {
        return redirect()->route('stream', [$User->username, $offset]);
      }
    }

    /*
     * At this stage, we either have a list of users, or one user. If
     * the latter, let's check if they're viewing their own profile.
    */
    if(isset($User) && $ID != NULL)
    {
      $query = $this->streamQuery($User, $offset, $limit);
      if($query !== FALSE)
      {
        $this->unformattedPosts = $query;
      }
      else
      {
        return FALSE;
      }
    }
    elseif($ID == NULL)
    {
      $query = $this->streamQuery(NULL /* User Object */, $offset, $limit);
      if($query !== FALSE)
      {
        $this->unformattedPosts = $query;
      }
      else
      {
        return FALSE;
      }
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
            $Reactions = NULL;
            $Reactions = \App\Post::getReactions($Post->id);

            $commentsCount = \App\Post::getCommentsCount($Post->id);

            $recentComments = \App\Post::getRecentComments($Post->id);

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
                    'total_comments'    => $commentsCount,
                    'total_reactions'   => $Reactions['count'],
                    'Comments'    => $recentComments,
                  ],
              ];



            break;

            case 'App\CBT':

            $i = 0;
            //Let's construct the chart
            $chart = Charts::multi('bar', 'material')
              //chart settings
              ->title('my chart' . ++$i)
              // A dimension of 0 means it will take 100% of the space
              ->dimensions(0, 400) // Width x Height
              // This defines a preset of colors already done:)
              ->template("material")
              ->dataset('Element 1', [5,20,100])
              ->dataset('Element 2', [15,30,80])
              ->dataset('Element 3', [25,10,40])
              // Setup what the values mean
              ->labels(['One', 'Two', 'Three']);

              /*
               * We need to know on the display, whether the current user has
               * reacted to a post on the stream so we can indicate this.
               * Some non-logged in users can still see the stream, so we need
               * to check for this first
              */
              $Reactions = NULL;
              $Reactions = \App\CBT::getReactions($Post->id);

              $commentsCount = \App\CBT::getCommentsCount($Post->id);

              $recentComments = \App\CBT::getRecentComments($Post->id);

              $this->formattedPosts[] =
                [
                  get_class($Post) =>
                    [
                      'Type'                => explode('\\', get_class($Post))[1],
                      'Reactions'           => $Reactions,
                      'Attributes'          => $Post->getAttributes(),
                      'User'                => Pretty::prettyUser($Post->User),
                      'Automatic Thoughts'  => $Post->AutomaticThoughts->toArray(),
                      'Emotions'            => $Post->Emotions->toArray(),
                      'Evidence'            => $Post->Evidence->toArray(),
                      'Rational Thoughts'   => $Post->RationalThoughts->toArray(),
                      'friendly_time'       => $Created->diffForHumans(),
                      'total_reactions'     => $Reactions['count'],
                      'total_comments'     => $commentsCount,
                      'chart'             => $chart,
                      'Comments'    => $recentComments,
                    ],
                ];
            break;
        }

      }

      return $this;
    }
    else
    {
      $this->errors[] = ['error...'];
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

    /*
     * For page 0 offset, offset = 0;
     * But, for page 2 offset, offset = 1 * $limit, because there are 10 to skip.
     * therefore, offset = (offset - 1) * limit
    */
    $union = $cbt
            ->union($posts)
            ->orderBy('created_at', 'desc')
            ->skip(($offset - 1) * $limit)
            ->limit($limit)
            ->get();

            error_log($offset * $limit);
    if(count($union) > 0)
    {
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
      if(isset($objects) && count($objects) > 0)
      {
        return $objects;
      }
      else
      {
        $this->errors[] = ['No stream objects found'];
        return $this;
      }
    }

    else
    {
      $this->errors[] = ['No stream objects found'];
      return $this;
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

  public function isRedirect()
  {
    if($this->redirectNeeded === TRUE)
    {
      return TRUE;
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
