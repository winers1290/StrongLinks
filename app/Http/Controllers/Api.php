<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use Illuminate\Support\Facades\Validator;

use Illuminate\Database\Eloquent\ModelNotFoundException;

/* API Classes */
use App\Libraries\Api\authenticated;
use App\Libraries\Api\reaction;
use App\Libraries\Api\comment;

class Api extends Controller
{

  private $user;

  public function __construct()
  {
      $this->middleware('auth');

      if(Auth::check())
      {
        $this->user = Auth::user();
      }

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

  public function putComment(Request $request, $post_type, $post_id)
  {
    $rules =
    [
            'comment'  =>  'required|string',
    ];

    $validator = Validator::make($request->all(), $rules);

    if($validator->fails())
    {
        return response()->json($validator->messages());
    }
    else
    {
      $comment = new comment(
        $post_type,
        $post_id,
        $request->comment,
        Auth::user(),
        NULL /*comment_id*/,
        $request->method()
      );

      //We want to return the HTML template for the new comment
      return view('templates.comment', $comment->response());
    }
  }

  public function deleteComment(Request $request, $post_type, $post_id, $comment_id)
  {
    $comment = new comment(
      $post_type,
      $post_id,
      NULL /* comment text */,
      Auth::user(),
      $comment_id,
      $request->method()
    );
    return response()->json($comment->response());
  }
}
