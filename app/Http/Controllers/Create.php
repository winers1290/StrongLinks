<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use App\Libraries\Create as CreateObject;

use Validator;

use URL;

class Create extends Controller
{
    public function Status(Request $request)
    {
        $input = $request->all();

        if(Auth::check())
        {
            /*
             * Set the rules for create form
            */
            $rules =
            [
              'content'   => 'required|max:500',
              'emotion_1' => 'required|alpha',
              'emotion_1_severity' => 'required|integer|digits_between:0,5',
              'emotion_2' => 'required|alpha',
              'emotion_2_severity' => 'required|integer|digits_between:0,5',
              'emotion_3' => 'required|alpha',
              'emotion_3_severity' => 'required|integer|digits_between:0,5',
              'emotion_4' => 'required|alpha',
              'emotion_4_severity' => 'required|integer|digits_between:0,5',
              'emotion_5' => 'required|alpha',
              'emotion_5_severity' => 'required|integer|digits_between:0,5',
            ];

            $validator = Validator::make($input, $rules);

            if($validator->fails())
            {
                return redirect(URL::previous())
                    ->withErrors($validator);
            }

            //Continue is everything is okay
            else
            {
                $New = new CreateObject($validator->getData());
                return redirect('/stream');
            }



        }

        else
        {
            return redirect('/');
        }

    }
}
