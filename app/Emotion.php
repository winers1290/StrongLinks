<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emotion extends Model
{
    public function CBTEmotions()
    {
        return $this->hasMany('App\CBTEmotion');
    }
    
    public function PostReactions()
    {
        return $this->hasMany('App\PostReaction');
    }
    
    public function PostEmotions()
    {
        return $this->hasMany('App\PostEmotion');
    }
}
