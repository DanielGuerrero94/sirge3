<?php

Route::get('usuarios', 'UserController@index');
Route::get('usuarios-table', 'UserController@tabla');
Route::get('edit-usuario/{id}', 'UserController@getEdit');
Route::post('edit-usuario/{id}', 'UserController@postEdit');
Route::post('baja-usuario/{id}', 'UserController@postBaja');
Route::post('unblock-usuario/{id}', 'UserController@postUnblock');

Route::get('areas', 'AreasController@index');
Route::get('areas-table', 'AreasController@tabla');
Route::get('new-area', 'AreasController@getNew');
Route::post('new-area', 'AreasController@postNew');
Route::get('edit-area/{id}', 'AreasController@getEdit');
Route::post('edit-area/{id}', 'AreasController@postEdit');

Route::get('menues', 'MenuesController@index');
Route::get('menues-table', 'MenuesController@tabla');
Route::get('new-menu', 'MenuesController@getNew');
Route::post('new-menu', 'MenuesController@postNew');
Route::get('edit-menu/{id}', 'MenuesController@getEdit');
Route::post('edit-menu/{id}', 'MenuesController@postEdit');
Route::get('tree/{id}', 'MenuesController@getTree');
Route::post('check-tree/{modulo}/{menu}', 'MenuesController@check');
Route::post('uncheck-tree/{modulo}/{menu}', 'MenuesController@uncheck');

Route::get('modulos', 'ModulosController@index');
Route::get('modulos-table', 'ModulosController@tabla');
Route::get('new-modulo', 'ModulosController@getNew');
Route::post('new-modulo', 'ModulosController@postNew');
Route::get('edit-modulo/{id}', 'ModulosController@getEdit');
Route::post('edit-modulo/{id}', 'ModulosController@postEdit');

Route::get('operadores', 'OperadoresController@index');
Route::get('operadores-table', 'OperadoresController@tabla');
Route::post('habilitar-operador', 'OperadoresController@enable');
Route::post('deshabilitar-operador', 'OperadoresController@disable');
Route::get('new-operador', 'OperadoresController@getNew');
Route::post('new-operador', 'OperadoresController@postNew');

Route::get('ranking-solicitudes', 'SolicitudController@getRanking');
Route::get('listado-ranking-solicitantes', 'SolicitudController@getRankingSolicitantes');
Route::get('listado-ranking-operadores', 'SolicitudController@getRankingOperadores');

