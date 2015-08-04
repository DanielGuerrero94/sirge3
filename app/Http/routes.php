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

// Main route ...
Route::get('/' , 'HomeController@index');

// Authentication routes ...
Route::get('login' , 'Auth\AuthController@getLogin');
Route::post('login' , 'AuthController@authenticate');
Route::get('logout' , 'Auth\AuthController@getLogout');

// Registration routes ...
Route::get('registrar' , 'RegistrationController@index');
Route::post('registrar' , 'RegistrationController@register');
Route::get('checkemail' , 'RegistrationController@email');

// Password recovery routes ...
Route::get('password' , 'PasswordController@index');
Route::post('password' , 'PasswordController@recover');
Route::get('checkemail-exists' , 'PasswordController@email');


//Inicio route ...
Route::get('inicio' , 'HomeController@inicio');

/*************
 * MENU ROUTES
 ************/

/**
 * DASHBOARD
 */
Route::get('dashboard' , 'HomeController@dashboard');
Route::get('nuevos-mensajes' , 'InboxController@mensajesNoLeidos');
	
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
Route::get('mensajes-inbox/{id_from}/{id_to}' , 'InboxController@chat');
/**
 * ADMIN
 */
Route::get('usuarios' , 'UserController@index');
Route::get('areas' , 'AreasController@index');
Route::get('menues' , 'MenuesController@index');
Route::get('modulos' , 'ModulosController@index');