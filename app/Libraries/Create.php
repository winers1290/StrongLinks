<?php

namespace App\Libraries;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Auth;

class Create
{

  /*
   * Array of errors picked up as this class executes
  */
  private $errors = [];

    public function __construct($input, $type = 'post')
    {
      $this->createPost($input);
    }

    /*
     * @$input object, simply the request object to process
     * @returns bool
    */
    private function createPost($input)
    {
      /*
       * First, we need save the post to grab the ID
      */
      $Post = new \App\Post;
      $Post->type = 1;
      $Post->user_id = Auth::user()->id;
      $Post->content = $input['content'];
      $Post->save();

      /*
       * Now, we find out what emotions the post was tagged with
        * We have to +1 because we start at $ = 1
      */
      for($i = 1; $i < ((\App\Emotion::all()->count()) + 1); $i ++)
      {
        //If the severity is 0, we can just ignore
        if($input["emotion_" . $i . "_severity"] == 0)
        {
          continue;
        }
        else
        {
          //Get the emotion in question
          $emotion = $input["emotion_" . $i];
          //Pull its record
          try
          {
            $emotion = \App\Emotion::where('emotion', $emotion)->firstOrFail();
          }
          catch(ModelNotFoundException $e)
          {
            $this->errors[] = "Emotion not found... Weird";
            return FALSE;
          }

          //If everything is all good...
          $PostEmotion = new \App\PostEmotion;
          $PostEmotion->post_id = $Post->id;
          $PostEmotion->user_id = Auth::user()->id;
          $PostEmotion->emotion_id = $emotion->id;
          $PostEmotion->severity = $input["emotion_" . $i . "_severity"];
          $PostEmotion->save();
        }
      }

      /*
       * Our work here is done
      */
      return TRUE;

    }
}
