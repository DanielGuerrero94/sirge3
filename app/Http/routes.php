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
Event::listen('illuminate.query', function($query)
{
    echo($query);
});

Route::get('/', function () {
	return view('welcome');
});

Route::get('/usuarios', 'UsuarioController@test');

/*
Route::post('/usuarios' , function(){
print_r($request->nombre());
});
 */
