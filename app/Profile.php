<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function FirstName()
    {
        return $this->belongsTo('App\Name', 'first_name', 'id');
    }
    
    public function LastName()
    {
        return $this->belongsTo('App\Name', 'last_name', 'id');
    }
    
    public function User()
    {
        return $this->belongsTo('App\User');
    }
}
