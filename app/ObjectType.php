<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjectType extends Model
{
    public function Reactions()
    {
        return $this->hasMany('App\ObjectReaction');
    }
}
