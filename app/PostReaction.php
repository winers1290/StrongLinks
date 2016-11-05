<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostReaction extends Model
{
    public function User()
    {
        return $this->belongsTo('App\User');
    }
    
    public function Emotion()
    {
        return $this->belongsTo('App\Emotion');
    }
    
    public function Post()
    {
        return $this->belongsTo('App\Post');
    }
}
