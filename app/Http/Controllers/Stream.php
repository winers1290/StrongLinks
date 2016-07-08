<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Stream extends Controller
{
    public function CreateStream($offset = 0)
    {
        $Stream = new \App\Post;
        $Data['Stream'] = $Stream->Stream(FALSE, $offset, NULL);
        
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
        $Stream = new \App\Post;
        if($username === NULL)
        {
            $Data['Stream'] = $Stream->Stream(TRUE, $offset, NULL);
        }
        else
        {
            $Data['Stream'] = $Stream->Stream(FALSE, $offset, $username);
        }
        
        //Page Variables
        $Emotions = \App\Emotion::all();
        foreach($Emotions as $Emotion)
        {
            $Data['Emotions'][] = $Emotion->emotion; 
        }
        
        return view('stream', $Data);
    }
}
