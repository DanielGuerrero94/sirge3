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
Route::post('login' , 'AuthController@authenticate');
Route::get('logout' , 'Auth\AuthController@getLogout');

//Registration routes ...
Route::get('registrar' , 'RegistrationController@index');
Route::post('registrar' , 'RegistrationController@register');
Route::get('checkemail' , 'RegistrationController@email');

Route::get('test' , function(){
	return view('registration.test');
});


//Inicio route ...
Route::get('inicio' , 'HomeController@inicio');

/*************
 * MENU ROUTES
 ************/

/**
 * DASHBOARD
 */
Route::get('dashboard' , 'HomeController@dashboard');
	
/**
 * PADRONES
 */
Route::get('prestaciones' , 'PadronController@prestacion');
Route::get('comprobantes' , 'PadronController@comprobante');
Route::get('fondos' , 'PadronController@fondo');
Route::get('osp' , 'PadronController@osp');
Route::get('profe' , 'PadronController@profe');
Route::get('sss' , 'PadronController@sss');

/**
 * USUARIO
 */
Route::get('perfil' , 'UsuarioController@perfil');
Route::get('ajustes' , 'UsuarioController@ajustes');

/**
 * CONTACTOS
 */
Route::get('contactos' , 'ContactosController@index');
Route::get('listado/{nombre?}' , 'ContactosController@listado');
Route::get('tarjeta/{id}' , 'ContactosController@tarjeta');
Route::get('mensajes/{id_from}/{id_to}' , 'ContactosController@chat');
Route::post('mensajes' , 'ContactosController@nuevoMensaje');

/**
 * INBOX
 */
Route::get('inbox' , 'InboxController@index');

/**
 * ADMIN
 */
Route::get('usuarios' , 'UsuariosController@index');
Route::get('areas' , 'AreasController@areas');
Route::get('menues' , 'MenuesController@menues');
Route::get('modulos' , 'ModulosController@modulos');