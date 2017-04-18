<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Libraries\Stream as StreamMaker;

class Stream extends Controller
{
  public function CreateStream($stream_type, $offset = 0, $request = 'GET')
  {
    if($stream_type === 'stream')
    {
      /*
       * We are accessing the main stream
      */
      $Stream = new StreamMaker(NULL /*User IDs*/, $offset);
    }
    elseif($stream_type === 'profile')
    {
      /*
       * We are accessing the user's profile
      */
      $Stream = new StreamMaker('profile', $offset);
    }
    else
    {
      /*
       * We are accessing another user's stream.
      */
      $Stream = new StreamMaker($stream_type, $offset);
    }

    //Is the Stream valid?
    if($Stream->Validate() === TRUE)
    {
      $Stream = $Stream->format()->getFormattedPosts();

      $Data['Stream'] = $Stream;

      //Page Variables
      $Emotions = \App\Emotion::all();
      foreach($Emotions as $Emotion)
      {
        $Data['Emotions'][] = $Emotion->emotion;
      }

      /* If the request type is POST, user is dynamically requesting content */
      if($request === 'POST')
      {
        return view('templates.stream-pagination', $Data);
      }
      /* Otherwise, user is just accessing the page */
      else
      {
        return view('stream', $Data);
      }
    }

    else
    {
      /* POST requests need to return JSON */
      if($request === 'POST')
      {
        return response()->json(FALSE);
      }
      /* Everything else... */
      else
      {
        abort('404');
      }
    }
  }

  /*
   * We need to tell the CreateStream function that this is a POST request.
   * POST requests are from users who are dynamically loading stream content
  */
  public function DynamicStream($stream_type, $offset)
  {
    return $this->CreateStream($stream_type, $offset, 'POST');
  }

    public function ProfilePagination($offset = 0)
    {
        return $this->Profile(NULL, $offset);
    }
    public function Profile($username = NULL, $offset = 0)
    {
        if($username === NULL)
        {
          /*
           * We are accessing profile
          */
          $Stream = new StreamMaker('profile', $offset);
        }
        else
        {
          $Stream = new StreamMaker($username, $offset);
        }

        if($Stream->Validate() === TRUE)
        {
          $Data['Stream'] = $Stream->format()->getFormattedPosts();

          //Page Variables
          $Emotions = \App\Emotion::all();
          foreach($Emotions as $Emotion)
          {
              $Data['Emotions'][] = $Emotion->emotion;
          }

          return view('stream', $Data);
        }
        else
        {
          abort('404');
        }

    }
}
