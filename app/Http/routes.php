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

Route::get('/', 'HomeController@show');

Route::post('/create/{id}', function(){
    return 'earl is real';
});

Route::auth();

Route::get('/home/', 'HomeController@show');

Route::get('/create/', 'SurveyController@index');

Route::post('/create/', 'SurveyController@create');

Route::post('/create/{id}', 'SurveyController@manipulateSurvey');

Route::put('/create/{id}', 'SurveyController@store');

Route::delete('/create/{id}' , 'SurveyController@destroy');

Route::get('/create/{id}', 'SurveyController@show');

