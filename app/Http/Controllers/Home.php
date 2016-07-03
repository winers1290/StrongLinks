<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Redirect;

class Home extends Controller
{
    public function Landing()
    {
        if(Auth::check())
        {
            return view('stream');
        }
        
        else
        {
            return view('login');
        }
    }
    
    public function Logout()
    {
        Auth::logout();
        
        return Redirect('/');
    }
    
    public function Login()
    {
        $rules = 
        [
                'username'  =>  'required',
                'password'  =>  'required',
        ];
        
        $validator = Validator::make(Input::all(), $rules);
        
        if($validator->fails())
        {
            return Redirect::to('/')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        }
        
        else
        {
            try
            {
                $User = \App\User::where('username', Input::get('username'))->firstOrFail()->getAttributes();
            }
            catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e)
            {
                $errors[] = 'No user by that name';
                return Redirect::to('/')
                    ->withErrors($errors);
            }
            
            $UserData = 
            [
                'username'  =>  Input::get('username'),
                'password'  => $User['salt'] . Input::get('password'),
            ];
            
            if(Auth::attempt($UserData))
            {
                return view('stream');
            }
            
            else
            {
                $errors[] = 'Wrong password';
                
                return Redirect::to('/')
                    ->withErrors($errors);
            }
        }
    }
}
