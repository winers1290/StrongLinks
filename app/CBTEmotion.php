<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CBTEmotion extends Model
{
    protected $table = 'cbt_emotions';
    
    public function Emotion()
    {
        return $this->belongsTo('App\Emotion');
    }
    
    public function CBT()
    {
        return $this->belongsTo('App\CBT');
    }
}
