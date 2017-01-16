<?php

namespace App\Libraries;


class Pretty
{
    public static function prettyUser($User)
    {
      //Is $User an int?
      if(is_numeric($User))
      {
        try
        {
          $User = \App\User::findOrFail($User);
        }
        catch (ModelNotFoundException $e)
        {
          return FALSE;
        }
      }

      return $prettyUser =
        [
          'id'            => $User->id,
          'first_name'    => $User->Profile->first_name,
          'last_name'     => $User->Profile->last_name,
          'picture'       => $User->Profile->picture,
          'username'      => $User->username,
        ];
    }
}
