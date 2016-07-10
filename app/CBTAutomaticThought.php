<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CBTAutomaticThought extends Model
{
    protected $table = 'cbt_automatic_thoughts';
    
    public function CBT()
    {
        return $this->belongsTo('App\CBT');
    }
}
