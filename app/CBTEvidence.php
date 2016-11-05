<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CBTEvidence extends Model
{
    protected $table = 'cbt_evidence';
    
    public function CBT()
    {
        return $this->belongsTo('App\CBT');
    }
}
