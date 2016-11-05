<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Name extends Model
{
    public function FirstName()
    {
        return $this->hasMany('App\Profile', 'first_name', 'id');
    }
    
    public function LastName()
    {
        return $this->hasMany('App\Profile', 'last_name', 'id');
    }
}
