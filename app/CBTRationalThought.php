<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CBTRationalThought extends Model
{
    protected $table = 'cbt_rational_thoughts';
    
    public function CBT()
    {
        return $this->belongsTo('App\CBT');
    }
}
