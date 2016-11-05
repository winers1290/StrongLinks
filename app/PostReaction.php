<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostReaction extends Model
{
    public function User()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
	
	public function Profile()
	{
		return $this->belongsTo('App\Profile', 'user_id');
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
