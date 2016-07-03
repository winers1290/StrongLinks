<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CBTRationalThought extends Model
{
    public function CBT()
    {
        return $this->belongsTo('App\CBT');
    }
}
