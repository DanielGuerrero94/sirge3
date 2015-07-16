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
/*
Route::get('/', function () {
	if (! Auth::check())
		return view('login');
	else 
		return redirect()->intended('/dashboard');
});
*/
//Authentication routes ...
Route::get('/' , 'HomeController@index');
	
Route::post('/login' , 'Auth\AuthController@postLogin');

Route::get('/dashboard' , function(){
	echo '<pre>' , print_r(Auth::user()) , '</pre>';
});

Route::get('/out' , 'Auth\AuthController@getLogout');

//Registration routes ...