<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

    /* Api:
     * Not really... just used for AJAX atm, but to be expanded!
    */
    Route::get('/api/authenticated', 'Api@authenticated');

    Route::put('api/{post_type}/{post_id}/reaction/{emotion_id}', 'Api@putReaction');
    Route::delete('api/{post_type}/{post_id}/reaction/{emotion_id}', 'Api@deleteReaction');

    Route::put('api/{post_type}/{post_id}/comment', 'Api@putComment');
    Route::delete('api/{post_type}/{post_id}/comment/{comment_id}', 'Api@deleteComment');

    Route::get('/logout', 'Home@Logout');
    Route::get('/', 'Home@Landing');
    Route::post('/', 'Home@Login');
    Route::post('/create', 'Create@Status');

    Route::get('/{stream}/{offset?}', 'Stream@CreateStream')->name('stream');

    //For dynamically loading new posts onto page
    Route::post('/{stream_type}/{offset}', 'Stream@DynamicStream');
