<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function Profile()
    {
        return $this->hasOne('App\Profile');
    }
    
    public function Posts()
    {
        return $this->hasMany('App\Post');
    }
    
    public function Reactions()
    {
        return $this->hasMany('App\PostReaction');
    }
    
    public function PostEmotions()
    {
        return $this->hasMany('App\PostReaction');
    }
    
    public function Comments()
    {
        return $this->hasMany('App\PostComment');
    }
    
    public function CommentReplies()
    {
        return $this->hasMany('App\PostCommentReply');
    }
    
    public function CBTs()
    {
        return $this->hasMany('App\CBT');
    }
    
    

}
