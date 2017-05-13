<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjectComment extends Model
{
  public function Profile()
  {
    return $this->belongsTo('App\Profile', 'user_id');
  }

  public function Type()
  {
    return $this->belongsTo('App\ObjectType', 'object_type');
  }

  public function Post()
  {
      return $this->belongsTo('App\Post', 'object_id');
  }

  public function CBT()
  {
      return $this->belongsTo('App\CBT', 'object_id');
  }
}
