<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CBT extends Model
{
    protected $table = 'cbt';
    
    public function Emotions()
    {
        return $this->hasMany('App\CBTEmotion');
    }
    
    public function Evidence()
    {
        return $this->hasMany('App\CBTEvidence');
    }
    
    public function RationalThoughts()
    {
        return $this->hasMany('App\CBTRationalThought');
    }
    
    public function AutomaticThoughts()
    {
        return $this->hasMany('App\CBTAutomaticThought');
    }
}
