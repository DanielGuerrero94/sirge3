<?php

//LISTADO
Route::get('pss-listado', 'PssController@getListado');
Route::get('pss-descargar-tabla', 'PssController@descargarTabla');
Route::get('pss-listado-table', 'PssController@getListadoTabla');
Route::get('pss-detalle/{id}', 'PssController@getDetalle');

//GRUPOS ETARIOS
Route::get('pss-grupos', 'PssController@getGrupos');
Route::get('pss-grupos-table', 'PssController@getGruposTabla');
Route::get('pss-grupos-detalle/{id}', 'PssController@getDetalleGrupos');
Route::get('pss-grupos-codigos-table/{id}', 'PssController@getGruposCodigosTabla');
Route::get('pss-generar-tabla', 'PssController@generarTabla');
Route::get('pss-generar-matriz', 'PssController@generarMatriz');
Route::get('pss-descargar-matriz', 'PssController@descargarMatriz');

//LINEAS DE CUIDADO
Route::get('pss-lineas', 'PssController@getLineas');
//pss-descargar-tabla
Route::get('pss-lineas-detalle/{id}', 'PssController@getDetalleLinea');
Route::get('pss-lineas-table', 'PssController@getLineasTabla');
Route::get('pss-lineas-codigos-table/{id}', 'PssController@getLineasCodigosTabla');

