<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CBT extends Model
{
    protected $table = 'cbt';

	public function User()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	public function Profile()
	{
		return $this->belongsTo('App\Profile', 'user_id');
	}

    public function Emotions()
    {
        return $this->hasMany('App\CBTEmotion', 'cbt_id');
    }

    public function Evidence()
    {
        return $this->hasMany('App\CBTEvidence', 'cbt_id');
    }

    public function RationalThoughts()
    {
        return $this->hasMany('App\CBTRationalThought', 'cbt_id');
    }

    public function AutomaticThoughts()
    {
        return $this->hasMany('App\CBTAutomaticThought', 'cbt_id');
    }
}
