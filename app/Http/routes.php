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


    Route::get('/logout', 'Home@Logout');
    Route::get('/', 'Home@Landing');

    Route::get('/{stream}/{offset?}', 'Stream@CreateStream')->name('stream');

    //For dynamically loading new posts onto page
    Route::post('/{stream_type}/{offset}', 'Stream@DynamicStream');
    //Route::post('/profile/{offset}', 'Stream@ProfilePagination');
    //Route::post('/{username}/{offset?}', 'Stream@Profile');

    Route::post('/create', 'Create@Status');







Route::post('/', 'Home@Login');
