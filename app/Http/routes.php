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
Route::get('login' , 'Auth\AuthController@getLogin');
Route::post('login' , 'Auth\AuthController@postLogin');
Route::get('logout' , 'Auth\AuthController@getLogout');

//Registration routes ...
//Route::get('/usuario' , '');
//Route::post('/usuario' , '');


//Inicio route ...
Route::get('inicio' , 'HomeController@inicio');

//Menu routes...
	// Dashboard
Route::get('dashboard' , 'HomeController@dashboard');