<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use Illuminate\Support\Facades\Validator;

use Illuminate\Database\Eloquent\ModelNotFoundException;

/* API Classes */
use App\Libraries\Api\authenticated;
use App\Libraries\Api\reaction;

class Api extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function authenticated(Request $request)
  {
    $rules =
    [
            'username'  =>  'regex:[A-Za-z0-9!@#$%^&*()\-_=.+]',
            'password'  =>  'regex:[A-Za-z0-9_.]',
    ];

    $validator = Validator::make($request->all(), $rules);

    if($validator->fails())
    {
        return response()->json(['fields failed validation']);
    }
    else
    {
      $authenticated = new authenticated($validator->getData());
      return response()->json($authenticated->response());
    }
  }

  public function putReaction(Request $request, $post_type, $post_id, $emotion_id)
  {
    $reaction = new reaction($post_type, $post_id, $emotion_id, Auth::user(), $request->method());
    return response()->json($reaction->response());
  }

  public function deleteReaction(Request $request, $post_type, $post_id, $emotion_id)
  {
    $reaction = new reaction($post_type, $post_id, $emotion_id, Auth::user(), $request->method());
    return response()->json($reaction->response());
  }
}