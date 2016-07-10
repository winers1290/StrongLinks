<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

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
                $list = [];
                foreach($input as $key => $value)
                {
                    $tmp = explode('_', $key);
                    
                    if(!in_array('emotion', $tmp) || in_array('severity', $tmp) || $input[$key] == "Blank" || $input[$key] == NULL)
                    {
                        continue;
                    }
                    
                    else
                    {
                        if(is_numeric($input[$key . '_severity']) && intval($input[$key . '_severity']) < 11 && is_string($input[$key]))
                        {
                            if(in_array($input[$key], $list))
                            {
                                continue;
                            }
                            else
                            {
                                $Emotions[] = ['emotion' => $input[$key], 'severity' => $input[$key . '_severity']];
                                $list[] = $input[$key];
                            }
                        }
                        
                        else
                        {
                            $errors[] = 'Incorrect input data. Please try again.';
                            
                            return redirect(URL::previous())
                                ->withErrors($errors);
                        }
                    }
                }

                            
                    $Post = new \App\Post;
                    $Post->type = 1;
                    $Post->user_id = Auth::user()->id;
                    $Post->content = $input['content'];
                            
                    $Post->save();

                            
                    //Now process emotions
                    foreach($Emotions as $Emotion)
                    {
                        try
                        {
                            $ReferenceEmotion = \App\Emotion::where('emotion', $Emotion['emotion'])->firstOrFail();
                        }
                        catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e)
                        {
                            $errors[] = 'Incorrect input data. Please try again.';
                            
                            return redirect(URL::previous())
                                ->withErrors($errors);
                        }
                                
                         $E = new \App\PostEmotion;
                         $E->post_id = $Post->id;
                         $E->user_id = Auth::user()->id;
                         $E->emotion_id = $ReferenceEmotion->id;
                         $E->severity = $Emotion['severity'];
                         
                                
                         $E->save();
                    } 
                    
                    return redirect()->intended();
            }
            


        }
        
        else
        {
            return redirect('/');
        }
        
    }
}
