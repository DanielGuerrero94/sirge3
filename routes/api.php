<?php

Route::get('api/analisis/{id}', 'ApiController@getAnalisis');
Route::get('api/diccionario/export', 'ApiController@getDiccionarioExport');
Route::get('api/{url}', 'ApiController@curlCall');
Route::post('api/postCsv', 'ApiController@postCsv');
