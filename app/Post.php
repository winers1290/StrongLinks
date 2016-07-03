<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function Reactions()
    {
        return $this->hasMany('App\PostReaction');
    }
    
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
}
