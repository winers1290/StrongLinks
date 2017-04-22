<?php

namespace App\Libraries\Api;

use Auth;

class authenticated
{
  //Is the user authenticated or not
  private $authenticated = FALSE;

  public function __construct($request)
  {
    /*
     * If this is an AJAX request, the user is probably already
     * authenticated
    */
    if(Auth::check())
    {
      $this->authenticated = TRUE;
      return $this;
    }
    /*
     * If not, let's look at any posted information
      * @POST username
      * @POST password
    */
    else
    {
        try
        {
            $User = \App\User::where('username', $request['username'])->firstOrFail();
        }
        catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e)
        {
            abort('404');
        }

        $UserData =
        [
            'username'  =>  $request['username'],
            'password'  => $User['salt'] . $request['password'],
        ];

        if(Auth::attempt($UserData))
        {
            $this->authenticated = TRUE;
            return $this;
        }

        else
        {
            abort('401');
        }
      }
    }

    public function response()
    {
      if($this->authenticated === TRUE)
      {
        return TRUE;
      }
      else
      {
        return FALSE;
      }
    }

}
