<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Libraries\Stream as StreamMaker;

class Stream extends Controller
{
    public function CreateStream($offset = 0)
    {
        $Stream = new StreamMaker(NULL /*User ID*/, $offset);
        $Data['Stream'] = $Stream->format()->getFormattedPosts();

        //Page Variables
        $Emotions = \App\Emotion::all();
        foreach($Emotions as $Emotion)
        {
            $Data['Emotions'][] = $Emotion->emotion;
        }

        return view('stream', $Data);
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
