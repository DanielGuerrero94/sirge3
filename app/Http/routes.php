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

//Main route ...
Route::get('/' , 'HomeController@index');

//Authentication routes ...
Route::get('/login' , 'Auth\AuthController@getLogin');
Route::post('/login' , 'Auth\AuthController@postLogin');
Route::get('/logout' , 'Auth\AuthController@getLogout');

//Registration routes ...

//Dashboard route ...
Route::get('/dashboard' , function(){
    echo '<pre>' , print_r(Auth::user()) , '</pre>';
});
