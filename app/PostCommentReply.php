<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCommentReply extends Model
{
    public function Comment()
    {
        return $this->belongsTo('App\PostComment');
    }
    
    public function User()
    {
        return $this->belongsTo('App\User');
    }
}
