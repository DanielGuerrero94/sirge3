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

//	Main route ...
Route::get('/' , 'HomeController@index');

//	Authentication routes ...
Route::get('login' , 'Auth\AuthController@getLogin');
Route::post('login' , 'AuthController@authenticate');
Route::get('logout' , 'Auth\AuthController@getLogout');

//	Registration routes ...
Route::get('registrar' , 'RegistrationController@index');
Route::post('registrar' , 'RegistrationController@register');
Route::get('checkemail' , 'RegistrationController@email');

//	Password recovery routes ...
Route::get('password' , 'PasswordController@index');
Route::post('password' , 'PasswordController@recover');
Route::get('checkemail-exists' , 'PasswordController@email');

//	Inicio route ...
Route::get('inicio' , 'HomeController@inicio');

/********************************************************************************
 *								 MENU ROUTES 									*
 ********************************************************************************/

/**
 * DASHBOARD
 */
Route::get('dashboard' , 'HomeController@dashboard');
Route::get('nuevos-mensajes' , 'InboxController@mensajesNoLeidos');

/**
 * SOLICITUDES
 */
#	INGRESO
Route::get('nueva-solicitud' , 'SolicitudController@getNuevaSolicitud');
Route::post('nueva-solicitud' , 'SolicitudController@postNuevaSolicitud');
#	MIS SOLICITUDES
Route::get('mis-solicitudes' , 'SolicitudController@getMisSolicitudes');
Route::get('mis-solicitudes-table' , 'SolicitudController@myRequestsTable');
#	ASIGNACION
Route::get('asignacion-solicitud' , 'SolicitudController@getSolicitudesNoAsignadas');
Route::get('asignacion-solicitud-table' , 'SolicitudController@asignacionSolicitudesTable');
#	PENDIENTES
Route::get('solicitudes-pendientes' , 'SolicitudController@getPendientes');
Route::get('solicitudes-pendientes-table' , 'SolicitudController@solicitudesPendientesTable');
#	CERRAR
Route::get('cerrar-solicitud/{id}' , 'SolicitudController@getCerrar');
Route::post('cerrar-solicitud/{id}' , 'SolicitudController@postCerrar');
#	LISTADO COMPLETO
Route::get('listado-solicitudes' , 'SolicitudController@listado');
Route::get('listado-solicitudes-table' , 'SolicitudController@listadoTable');
#	MISC
Route::post('asignar-operador' , 'SolicitudController@postOperador');
Route::get('ver-solicitud/{id}/{back}' , 'SolicitudController@getSolicitud');
Route::get('tipo-solicitud/{id}' , 'SolicitudController@getTipos');
Route::get('operadores/{id}' , 'SolicitudController@getOperadores');
Route::get('notificar-cierre/{id}' , 'SolicitudController@notificarCierre');
Route::get('solicitud-final/{id}/{hash}' , 'SolicitudController@finalizarSolicitud');

/** 
 * PADRONES
 */
#	VISTA PRINCIPAL
Route::get('padron/{id}' , 'PadronesController@getMain');
#	SUBIDA DE ARCHIVOS
Route::get('subir-padron/{id}' , 'PadronesController@getUpload');
Route::post('subir-padron' , 'PadronesController@postUpload');
#	ACCIONES
Route::get('listar-archivos/{id}' , 'PadronesController@listadoArchivos');
Route::get('listar-archivos-table/{id}' , 'PadronesController@listadoArchivosTabla');
Route::get('eliminar-padron/{archivo}' , 'PadronesController@eliminarArchivo');

/**
 * LOTES
 */
#	LISTADO
Route::get('listar-lotes/{id}' , 'LotesController@listadoLotes');
Route::get('listar-lotes-table/{id}' , 'LotesController@listadoLotesTabla');
#	DETALLE
Route::get('detalle-lote/{lote}' , 'LotesController@detalleLote');
#	ACCIONES
Route::post('aceptar-lote' , 'LotesController@aceptarLote');
Route::post('eliminar-lote' , 'LotesController@eliminarLote');
#	RECHAZOS
Route::get('rechazos-lote/{lote}' , 'LotesController@getRechazos');
Route::get('rechazos-lote-table/{lote}' , 'LotesController@getRechazosTabla');

/**
 * DICCIONARIO
 */
Route::get('diccionario/{id}' , 'DiccionariosController@getDatadic');
Route::get('diccionario-table/{id}' , 'DiccionariosController@getDatadicTabla');

/** 
 * PRESTACIONES 
 */
Route::get('procesar-prestaciones/{archivo}' , 'PrestacionesController@procesarArchivo');

/**
 * COMPROBANTES
 */
Route::get('procesar-comprobantes/{archivo}' , 'ComprobantesController@procesarArchivo');

/**
 * FONDOS
 */
Route::get('procesar-fondos/{archivo}' , 'FondosController@procesarArchivo');

/**
 * OBRA SOCIAL PROVINCIAL
 */
Route::get('procesar-osp/{archivo}' , 'OspController@procesarArchivo');
Route::get('check-periodo/{codigo}' , 'OspController@checkPeriodo');

/**
 * PROGRAMA FEDERAL DE SALUD
 */
Route::get('procesar-profe/{archivo}' , 'ProfeController@procesarArchivo');

/**
 * SUPERINTENDENCIA DE SERVICIOS DE SALUD
 */
Route::get('procesar-sss/{archivo}' , 'SuperController@procesarArchivo');
Route::get('check-sss/{archivo}' , 'SuperController@checkId');

/**
 * PUCO
 */
Route::get('puco-generar' , 'PucoController@getGenerar');
Route::get('puco-estadisticas-table' , 'PucoController@estadisticasTabla');
Route::get('puco-resumen-table' , 'PucoController@resumenTabla');
Route::post('puco-generar-archivo' , 'PucoController@generar');
Route::get('puco-consultas' , 'PucoController@getConsulta');

/**
 * BENEFICIARIOS
 */
Route::get('listado-beneficiarios' , 'BeneficiariosController@index');
Route::get('beneficiarios-listado-table' , 'BeneficiariosController@getListadoTabla');
Route::get('beneficiarios-historia-clinica/{id}/{back}' , 'BeneficiariosController@historiaClinica');


/**
 * PSS
 */
Route::get('pss-listado' , 'PssController@getListado');
Route::get('pss-listado-table' , 'PssController@getListadoTabla');
Route::get('pss-detalle/{id}' , 'PssController@getDetalle');
Route::get('pss-lineas' , 'PssController@getLineas');
Route::get('pss-lineas-table' , 'PssController@getLineasTabla');
Route::get('pss-lineas-codigos-table/{id}' , 'PssController@getLineasCodigosTabla');
Route::get('pss-lineas-detalle/{id}' , 'PssController@getDetalleLinea');
Route::get('pss-grupos' , 'PssController@getGrupos');
Route::get('pss-grupos-table' , 'PssController@getGruposTabla');
Route::get('pss-grupos-detalle/{id}' , 'PssController@getDetalleGrupos');

/**
 * EFECTORES
 */
#	LISTADO
Route::get('efectores-listado' , 'EfectoresController@listado');
Route::get('efectores-listado-table' , 'EfectoresController@listadoTabla');
Route::get('efectores-generar-tabla' , 'EfectoresController@generarTabla');
Route::get('efectores-descargar-tabla' , 'EfectoresController@descargarTabla');
#	ALTA
Route::get('efectores-alta' , 'EfectoresController@getAlta');
Route::post('efectores-alta' , 'EfectoresController@postAlta');
#	BAJA
Route::get('efectores-baja' , 'EfectoresController@getBaja');
Route::post('efectores-baja' , 'EfectoresController@postBaja');
#	MODIFICACION
Route::get('efectores-modificacion' , 'EfectoresController@getEdit');
Route::post('efectores-modificacion' , 'EfectoresController@postEdit');
Route::get('efectores-modificacion/{cuie}' , 'EfectoresController@getEditForm');
#	REVISION
Route::get('efectores-revision' , 'EfectoresController@getRevision');
Route::get('efectores-revision-table' , 'EfectoresController@getRevisionTabla');
#	COMMON
Route::get('cuie-nuevo/{provincia}' , 'EfectoresController@getCuie');
Route::get('siisa-nuevo/{provincia}' , 'EfectoresController@getSiisa');
Route::get('cuie-busqueda/{cuie}' , 'EfectoresController@findCuie');
Route::get('efectores-detalle/{id}/{back}' , 'EfectoresController@detalle');
#	OPERACIONES FINALES
Route::post('alta-efector' , 'EfectoresController@alta');
Route::post('baja-efector' , 'EfectoresController@baja');
Route::post('rechazo-efector' , 'EfectoresController@rechazo');

/**
 * ESTADISTICAS
 */
Route::get('estadisticas-graficos' , 'EstadisticasController@getGraficos');
Route::get('estadisticas-graficos/{id}' , 'EstadisticasController@getGrafico');
Route::get('estadisticas-graficos/{id}/{periodo}' , 'EstadisticasController@getGraficoPeriodo');
Route::get('grafico-2/{periodo}' , 'EstadisticasController@getGafico2');

/**
 * DDJJ
 */
Route::get('listado-lotes-cerrados/{padron}' , 'DdjjController@getListadoPendientes');
Route::get('listado-lotes-cerrados-table/{padron}' , 'DdjjController@getListadoPendientesTabla');
Route::post('declarar-lotes' , 'LotesController@declararLotes');
Route::get('listado-ddjj/{padron}' , 'DdjjController@getListado');
Route::get('listado-ddjj-table/{padron}' , 'DdjjController@getListadoTabla');
Route::get('ddjj-sirge/{padron}/{id}' , 'DdjjController@getDDJJSirge');

Route::get('ddjj-doiu-9' , 'DdjjController@getDoiu9');
Route::post('ddjj-doiu-9' , 'DdjjController@postDoiu9');
Route::get('ddjj-doiu9-table' , 'DdjjController@getDoiu9Tabla');
Route::get('ddjj-doiu9-reimprimir/{id}' , 'DdjjController@getD9');
Route::get('ddjj-doiu9-consolidado' , 'DdjjController@D9Consolidado');

Route::get('ddjj-backup' , 'DdjjController@getBackup');

Route::get('ddjj-periodo/{tipo}' , [
		'middleware' => 'uec' , 
		'uses' => 'DdjjController@getPeriodo'
	]);
Route::post('ddjj-reimpresion/{tipo}/{periodo}/{version}' , 'DdjjController@reimpresion');

Route::post('backup' , 'DdjjController@postBackup');
Route::get('ddjj-backup-table' , 'DdjjController@getBackupTabla');
Route::get('ddjj-backup-consolidado' , 'DdjjController@backupConsolidado');

Route::get('check-periodo/{tipo}/{periodo}' , 'DdjjController@checkPeriodo');

/**
 * COMPROMISO ANUAL 2016
 */
Route::get('compromiso-anual-16-descentralizacion' , 'CompromisoController@getDescentralizacion');
Route::get('compromiso-anual-16-descentralizacion-periodo-form' , 'CompromisoController@getFormPeriodoDescentralizacion');
Route::get('compromiso-anual-16-descentralizacion-progresion-form' , 'CompromisoController@getFormProgresionDescentralizacion');


/**
 * USUARIO
 */
Route::get('perfil' , 'UserController@getProfile');
Route::get('ajustes' , 'UserController@getEditProfile');
Route::post('ajustes' , 'UserController@postEditProfile');
Route::get('new-password' , 'UserController@getNewPassword');
Route::post('new-password' , 'UserController@postNewPassword');
Route::get('usuario-imagen' , 'UserController@getAvatar');
Route::post('usuario-imagen' , 'UserController@postAvatar');

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
Route::get('usuarios-table' , 'UserController@tabla');
Route::get('edit-usuario/{id}' , 'UserController@getEdit');
Route::post('edit-usuario/{id}' , 'UserController@postEdit');
Route::post('baja-usuario/{id}' , 'UserController@postBaja');
Route::post('unblock-usuario/{id}' , 'UserController@postUnblock');

Route::get('areas' , 'AreasController@index');
Route::get('areas-table' , 'AreasController@tabla');
Route::get('new-area' , 'AreasController@getNew');
Route::post('new-area' , 'AreasController@postNew');
Route::get('edit-area/{id}' , 'AreasController@getEdit');
Route::post('edit-area/{id}' , 'AreasController@postEdit');

Route::get('menues' , 'MenuesController@index');
Route::get('menues-table' , 'MenuesController@tabla');
Route::get('new-menu' , 'MenuesController@getNew');
Route::post('new-menu' , 'MenuesController@postNew');
Route::get('edit-menu/{id}' , 'MenuesController@getEdit');
Route::post('edit-menu/{id}' , 'MenuesController@postEdit');
Route::get('tree/{id}' , 'MenuesController@getTree');
Route::post('check-tree/{modulo}/{menu}' , 'MenuesController@check');
Route::post('uncheck-tree/{modulo}/{menu}' , 'MenuesController@uncheck');

Route::get('modulos' , 'ModulosController@index');
Route::get('modulos-table' , 'ModulosController@tabla');
Route::get('new-modulo' , 'ModulosController@getNew');
Route::post('new-modulo' , 'ModulosController@postNew');
Route::get('edit-modulo/{id}' , 'ModulosController@getEdit');
Route::post('edit-modulo/{id}' , 'ModulosController@postEdit');

Route::get('operadores' , 'OperadoresController@index');
Route::get('operadores-table' , 'OperadoresController@tabla');
Route::post('habilitar-operador' , 'OperadoresController@enable');
Route::post('deshabilitar-operador' , 'OperadoresController@disable');
Route::get('new-operador' , 'OperadoresController@getNew');
Route::post('new-operador' , 'OperadoresController@postNew');

/********************************************************************************
 *							 	   MISC ROUTES 									*
 ********************************************************************************/
Route::get('departamentos/{provincia}' , 'GeoController@departamentos');
Route::get('localidades/{provincia}/{departamento}' , 'GeoController@localidades');

Route::get('phpinfo' , function(){
	phpinfo();
});


/********************************************************************************
 *								 	TEST ROUTES 								*
 ********************************************************************************/
Route::get('excel' , 'EfectoresController@generarTabla');

/********************************************************************************
 *								 	WS ROUTES 									*
 ********************************************************************************/