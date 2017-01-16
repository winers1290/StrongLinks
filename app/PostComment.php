<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    public function Replies()
    {
        return $this->hasMany('App\PostCommentReply', 'comment_id');
    }
    
    public function User()
    {
        return $this->belongsTo('App\User');
    }
    
    public function Post()
    {
        return $this->belongsTo('App\Post');
    }
}
