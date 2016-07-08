<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use \NumberFormatter as NumberFormatter;

class Create extends Controller
{
    public function Status(Request $request)
    {
        if(Auth::check())
        {
            $i = 0;
            $Word = new NumberFormatter("en", NumberFormatter::SPELLOUT);
            foreach($request->all() as $key => $input)
            {
                print_r($key);
            }
        }
        
        else
        {
            return redirect('/');
        }
        
    }
}
