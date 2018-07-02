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
Route::get('/', 'HomeController@index');

//	Authentication routes ...
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'AuthController@authenticate');
Route::get('logout', 'Auth\AuthController@getLogout');

//	Registration routes ...
Route::get('registrar', 'RegistrationController@index');
Route::post('registrar', 'RegistrationController@register');
Route::get('checkemail', 'RegistrationController@email');

//	Password recovery routes ...
Route::get('password', 'PasswordController@index');
Route::post('password', 'PasswordController@recover');
Route::get('checkemail-exists', 'PasswordController@email');

//	Inicio route ...
Route::get('inicio', 'HomeController@inicio');

/********************************************************************************
 *								 MENU ROUTES 									*
 ********************************************************************************/

/**
 * DASHBOARD
 */
Route::get('dashboard', 'HomeController@dashboard');

// PROTECTED
Route::group(array('before' => 'auth'), function () {
		Route::get('nuevos-mensajes', 'InboxController@mensajesNoLeidos');
	});

Route::post('avisos-leidos', 'InboxController@avisosLeidos');

/**
 * SOLICITUDES
 */
#	INGRESO
Route::get('nueva-solicitud', 'SolicitudController@getNuevaSolicitud');
Route::post('nueva-solicitud', 'SolicitudController@postNuevaSolicitud');
Route::post('attach-document', 'SolicitudController@attachDocument');
Route::post('attach-document-cierre', 'SolicitudController@attachDocumentResponse');
Route::get('descargar-adjunto-solicitante/{id}', 'SolicitudController@downloadAdjuntoSolicitante');
Route::get('descargar-adjunto-cierre/{id}', 'SolicitudController@downloadAdjuntoCierre');
#	MIS SOLICITUDES
Route::get('mis-solicitudes', 'SolicitudController@getMisSolicitudes');
Route::get('mis-solicitudes-table', 'SolicitudController@myRequestsTable');
#	ASIGNACION
Route::get('asignacion-solicitud', 'SolicitudController@getSolicitudesNoAsignadas');
Route::get('asignacion-solicitud-table', 'SolicitudController@asignacionSolicitudesTable');
#	PENDIENTES
Route::get('solicitudes-pendientes', 'SolicitudController@getPendientes');
Route::get('solicitudes-pendientes-table', 'SolicitudController@solicitudesPendientesTable');
#	CERRAR
Route::get('cerrar-solicitud/{id}', 'SolicitudController@getCerrar');
Route::post('cerrar-solicitud/{id}', 'SolicitudController@postCerrar');
#	LISTADO COMPLETO
Route::get('listado-solicitudes', 'SolicitudController@listado');
Route::get('listado-solicitudes-table', 'SolicitudController@listadoTable');
#	MISC
Route::post('asignar-operador', 'SolicitudController@postOperador');
Route::get('ver-solicitud/{id}/{back}', 'SolicitudController@getSolicitud');
Route::get('tipo-solicitud/{id}', 'SolicitudController@getTipos');
Route::get('operadores/{id}', 'SolicitudController@getOperadores');
Route::get('notificar-cierre/{id}', 'SolicitudController@notificarCierre');
Route::get('solicitud-final/{id}/{hash}', 'SolicitudController@finalizarSolicitud');

/**
 * PADRONES
 */
Route::get('padron/{id}', 'PadronesController@getMain');
Route::get('subir-padron/{id}', 'PadronesController@getUpload');
Route::post('subir-padron', 'PadronesController@postUpload');
Route::post('subir-padron/{id}', 'PadronesController@postUpload');
Route::get('listar-archivos/{id}', 'PadronesController@listadoArchivos');
Route::get('listar-archivos-table/{id}', 'PadronesController@listadoArchivosTabla');
Route::get('eliminar-padron/{archivo}', 'PadronesController@eliminarArchivo');
Route::get('padron-consolidado', 'PadronesController@getConsolidado');
Route::get('padron-graficar/{padron}/{provincia}', 'PadronesController@graficarPadron');

/**
 * LOTES
 */
#	LISTADO
Route::get('listar-lotes/{id}', 'LotesController@listadoLotes');
Route::get('listar-lotes-table/{id}', 'LotesController@listadoLotesTabla');
#	DETALLE
Route::get('detalle-lote/{lote}', 'LotesController@detalleLote');
#	ACCIONES
Route::post('aceptar-lote', 'LotesController@aceptarLote');
Route::post('eliminar-lote', 'LotesController@eliminarLote');
#	RECHAZOS
Route::get('rechazos-lote/{lote}', 'LotesController@getRechazos');
Route::get('rechazos-lote-table/{lote}', 'LotesController@getRechazosTabla');
#   MAL PROCESADOS
Route::get('subidas-mal-procesadas', 'LotesController@alertSubidasMalProcesadas');

/**
 * DICCIONARIO
 */
Route::get('diccionario/{id}', 'DiccionariosController@getDatadic');
Route::get('diccionario-table/{id}', 'DiccionariosController@getDatadicTabla');

/**
 * PRESTACIONES
 */
Route::get('procesar-prestaciones/{archivo}', 'PrestacionesController@procesarArchivo');
Route::post('nuevo-lote-prestaciones/{id_subida}', 'PrestacionesController@nuevoLote');

/**
 * COMPROBANTES
 */
Route::get('procesar-comprobantes/{archivo}', 'ComprobantesController@procesarArchivo');
Route::post('nuevo-lote-comprobantes/{id_subida}', 'ComprobantesController@nuevoLote');

/**
 * FONDOS
 */
Route::get('procesar-fondos/{archivo}', 'FondosController@procesarArchivo');
Route::post('nuevo-lote-fondos/{id_subida}', 'FondosController@nuevoLote');

/**
 * OBRA SOCIAL PROVINCIAL
 */
Route::get('procesar-osp/{archivo}', 'OspController@procesarArchivo');
Route::get('check-periodo/{codigo}', 'OspController@checkPeriodo');
Route::post('nuevo-lote-osp/{id_subida}', 'OspController@nuevoLote');

/**
 * PROGRAMA FEDERAL DE SALUD
 */
Route::get('procesar-profe/{archivo}', 'ProfeController@procesarArchivo');
Route::post('nuevo-lote-profe/{id_subida}', 'ProfeController@nuevoLote');

/**
 * SUPERINTENDENCIA DE SERVICIOS DE SALUD
 */
Route::get('procesar-sss/{archivo}', 'SuperController@procesarArchivo');
Route::get('check-sss/{archivo}', 'SuperController@checkId');
Route::post('nuevo-lote-sss/{id_subida}', 'SuperController@nuevoLote');

/**
 * TRAZADORAS
 */
Route::get('procesar-trazadoras/{archivo}', 'TrazadorasController@procesarArchivo');
Route::post('nuevo-lote-trazadoras/{id_subida}', 'TrazadorasController@nuevoLote');

/**
 * PUCO
 */
Route::get('puco-generar', 'PucoController@getGenerar');
Route::get('puco-estadisticas-table', 'PucoController@estadisticasTabla');
Route::get('puco-resumen-table', 'PucoController@resumenTabla');
Route::post('puco-generar-archivo', 'PucoController@generar');
Route::get('puco-consultas', 'PucoController@getConsulta');
Route::get('generar-ace', 'PucoController@generarZipACE');

/**
 * BENEFICIARIOS
 */
Route::get('beneficiarios-listado', 'BeneficiariosController@index');
Route::get('beneficiarios-listado-table', 'BeneficiariosController@getListadoTabla');
Route::get('beneficiarios-historia-clinica/{id}/{back}', 'BeneficiariosController@historiaClinica');
Route::get('beneficiarios-busqueda/{beneficiario}', 'BeneficiariosController@busquedaBeneficiario');

/**
 * PSS
 */
Route::get('pss-listado', 'PssController@getListado');
Route::get('pss-listado-table', 'PssController@getListadoTabla');
Route::get('pss-detalle/{id}', 'PssController@getDetalle');
Route::get('pss-lineas', 'PssController@getLineas');
Route::get('pss-lineas-table', 'PssController@getLineasTabla');
Route::get('pss-lineas-codigos-table/{id}', 'PssController@getLineasCodigosTabla');
Route::get('pss-lineas-detalle/{id}', 'PssController@getDetalleLinea');
Route::get('pss-grupos', 'PssController@getGrupos');
Route::get('pss-grupos-table', 'PssController@getGruposTabla');
Route::get('pss-grupos-detalle/{id}', 'PssController@getDetalleGrupos');
Route::get('pss-grupos-codigos-table/{id}', 'PssController@getGruposCodigosTabla');
Route::get('pss-descargar-tabla', 'PssController@descargarTabla');
Route::get('pss-generar-tabla', 'PssController@generarTabla');
Route::get('pss-generar-matriz', 'PssController@generarMatriz');
Route::get('pss-descargar-matriz', 'PssController@descargarMatriz');

/**
 * ANALISIS CEB
 */
Route::get('ceb-resumen-periodo', 'CebController@getPeriodo');
Route::get('ceb-resumen/{periodo}', 'CebController@getResumen');
Route::get('ceb-resumen-table/{periodo}', 'CebController@getResumenTabla');
Route::get('ceb-evolucion', 'CebController@getEvolucion');

/**
 * ANALISIS CEI
 */
Route::get('cei-filtros', 'CeiController@getFiltros');
Route::get('cei-lineas-cuidado/{grupo}', 'CeiController@getLineas');
Route::get('cei-resumen/{periodo}/{linea}', 'CeiController@getResumen');
Route::get('cei-resumen/{periodo}/{indicador}/{provincia}', 'CeiController@getDetalleProvincia');
Route::get('cei-reportes', 'CeiController@getReportes');
Route::get('cei-reportes-table', 'CeiController@getReportesTabla');
Route::get('cei-reportes/{id}', 'CeiController@getReporte');
Route::get('cei-reportes-download/{id}/{periodo?}/{tipo?}', 'CeiController@getLineaDownload');
Route::get('cei-indicador/{periodo}/{id_indicador}', 'CeiController@getIndicadorCei');

Route::get('cei-calculo-linea/{linea}/{periodo}', 'CeiController@nuevoCalculo');
Route::get('cei-lineas-todas/{periodo}', 'CeiController@nuevoCalculoCompleto');
Route::get('cei-indicadores-todos/{periodo}', 'CeiController@indicadoresCompleto');
Route::get('cei-indicador-test-1/{linea}/{periodo}', 'CeiController@getTipoDos');
Route::get('cei-indicador-new/{periodo}/{indicador}', 'CeiController@getIndicadorCeiNew');
Route::get('cei-excel-linea/{periodo}/{linea}', 'CeiController@generarExcelLinea');
Route::get('cei-excel-beneficiarios/{periodo}/{linea}', 'CeiController@generarExcelLineaBeneficiario');

/**
 * ANALISIS PRESTACIONES
 */
Route::get('prestaciones-resumen-periodo', 'PrestacionesController@getPeriodo');
Route::get('prestaciones-resumen/{periodo}', 'PrestacionesController@getResumen');
Route::get('prestaciones-resumen-table/{periodo}', 'PrestacionesController@getResumenTabla');
Route::get('prestaciones-evolucion', 'PrestacionesController@getEvolucion');

/**
 * EFECTORES
 */
#	LISTADO
Route::get('efectores-listado', 'EfectoresController@listado');
Route::get('efectores-listado-table', 'EfectoresController@listadoTabla');
Route::get('efectores-generar-tabla', 'EfectoresController@generarTabla');
Route::get('efectores-descargar-tabla', 'EfectoresController@descargarTabla');
#	ALTA
Route::get('efectores-alta', 'EfectoresController@getAlta');
Route::post('efectores-alta', 'EfectoresController@postAlta');
#	BAJA
Route::get('efectores-baja', 'EfectoresController@getBaja');
Route::post('efectores-baja', 'EfectoresController@postBaja');
#	MODIFICACION
Route::get('efectores-modificacion', 'EfectoresController@getEdit');
Route::post('efectores-modificacion', 'EfectoresController@postEdit');
Route::get('efectores-modificacion/{cuie}', 'EfectoresController@getEditForm');
#	REVISION
Route::get('efectores-revision', 'EfectoresController@getRevision');
Route::get('efectores-revision-table', 'EfectoresController@getRevisionTabla');
#	COMMON
Route::get('cuie-nuevo/{provincia}', 'EfectoresController@getCuie');
Route::get('siisa-nuevo/{provincia}', 'EfectoresController@getSiisa');
Route::get('cuie-busqueda/{cuie}', 'EfectoresController@findCuie');
Route::get('efectores-detalle/{id}/{back}', 'EfectoresController@detalle');
#	OPERACIONES FINALES
Route::post('alta-efector', 'EfectoresController@alta');
Route::post('baja-efector', 'EfectoresController@baja');
Route::post('rechazo-efector', 'EfectoresController@rechazo');

/**
 * ESTADISTICAS
 */
Route::get('estadisticas-graficos', 'EstadisticasController@getGraficos');
Route::get('estadisticas-graficos/{id}', 'EstadisticasController@getGrafico');
Route::get('estadisticas-graficos/{id}/{periodo}', 'EstadisticasController@getGraficoPeriodo');
Route::get('estadisticas-graficos/{id}/{periodo}/{provincia}', 'EstadisticasController@getGraficoProvinciaPeriodo');
Route::get('estadisticas-graficos-pp/{id}/{provincia}/{padron}', 'EstadisticasController@getGraficoProvinciaPadron');

Route::get('estadisticas-reportes', 'EstadisticasController@getReportes');
Route::get('estadisticas-reportes/{id}', 'EstadisticasController@getReporte');
Route::get('estadisticas-reportes/{id}/{periodo}', 'EstadisticasController@getReportePeriodo');
Route::get('estadisticas-reportes/{id}/{periodo}/{provincia}', 'EstadisticasController@getReporteProvinciaPeriodo');

/**
 * GRAFICOS
 */
Route::get('grafico-2/{periodo}', 'GraficosController@getGrafico2');
Route::get('grafico-3/{periodo}', 'GraficosController@getGrafico3');
Route::get('grafico-3-treemap/{periodo}', 'GraficosController@getDistribucionGrafico3');
Route::get('grafico-3-table/{periodo}', 'GraficosController@getGrafico3Tabla');
Route::get('grafico-3-dr/{periodo}', 'GraficosController@getGrafico3Dr');
Route::get('grafico-3-drlote/{periodo}', 'GraficosController@getGrafico3DrLote');
Route::get('grafico-3-drlote-2/{periodo}', 'GraficosController@getGrafico3DrLote2');
Route::get('grafico-4/{periodo}', 'GraficosController@getGrafico4');
Route::get('grafico-4-table/{periodo}', 'GraficosController@getGrafico4Tabla');
Route::get('grafico-5/{periodo}', 'GraficosController@getGrafico5');
Route::get('grafico-5-table/{periodo}', 'GraficosController@getGrafico5Tabla');
Route::get('grafico-6', 'GraficosController@getGrafico6');
Route::get('grafico-6-table', 'GraficosController@getGrafico6Tabla');
Route::get('grafico-7/{periodo}/{provincia}', 'GraficosController@getGrafico7');
Route::get('grafico-7-table/{periodo}/{provincia}', 'GraficosController@getGrafico7Tabla');

/**
 * INDICADORES
 */
Route::get('indicadores-medica', 'IndicadoresController@getIndicadoresMedicaForm');
Route::get('indicadores-medica/{id}/{periodo}/{back}', 'IndicadoresController@getIndicadoresMedica');
Route::get('indicadores-efectores', 'IndicadoresController@getIndicadoresEfectoresForm');
Route::get('indicadores-efectores/{id}/{indicador}/{anio}/{back}', 'IndicadoresController@getListadoPriorizadosView');
Route::get('priorizados-listado-table/{id}/{indicador}/{anio}', 'IndicadoresController@getListadoPriorizadosTabla');
Route::get('priorizados-indicadores/{id}/{anio}', 'Indicadores\PriorizadosController@getIndicador_3_3_numerador');

/**
 * DDJJ
 */
Route::get('listado-lotes-cerrados/{padron}', 'DdjjController@getListadoPendientes');
Route::get('listado-lotes-cerrados-table/{padron}', 'DdjjController@getListadoPendientesTabla');
Route::post('declarar-lotes', 'LotesController@declararLotes');
Route::get('listado-ddjj/{padron}', 'DdjjController@getListado');
Route::get('listado-ddjj-table/{padron}', 'DdjjController@getListadoTabla');
Route::get('ddjj-sirge/{padron}/{id}', 'DdjjController@getDDJJSirge');

Route::get('ddjj-doiu-9', 'DdjjController@getDoiu9');
Route::post('ddjj-doiu-9', 'DdjjController@postDoiu9');
Route::get('ddjj-doiu9-table', 'DdjjController@getDoiu9Tabla');
Route::get('ddjj-doiu9-reimprimir/{id}', 'DdjjController@getD9');
Route::get('ddjj-doiu9-consolidado', 'DdjjController@D9Consolidado');

Route::get('ddjj-backup', 'DdjjController@getBackup');
Route::get('ddjj-backup-reimprimir/{id}', 'DdjjController@getBack');
Route::get('ddjj-periodo/doiu-9', [
		'middleware' => ['uec'],
		'uses'       => 'DdjjController@getPeriodoDoiu9'
	]);
Route::get('ddjj-periodo/backup', [
		'middleware' => ['uec'],
		'uses'       => 'DdjjController@getPeriodoBackup'
	]);
Route::post('ddjj-reimpresion/{tipo}/{periodo}/{version}', 'DdjjController@reimpresion');

Route::post('backup', 'DdjjController@postBackup');
Route::get('ddjj-backup-table', 'DdjjController@getBackupTabla');
Route::get('ddjj-backup-consolidado', 'DdjjController@backupConsolidado');

Route::get('check-periodo/{tipo}/{periodo}', 'DdjjController@checkPeriodo');

/**
 * COMPROMISO ANUAL
 */
Route::get('ca-periodo-form/{back}/{modulo}', 'CompromisoController@getFormPeriodo');
Route::get('ca-provincia-form/{back}/{modulo}', 'CompromisoController@getFormProvincia');

Route::get('ca-16-descentralizacion/{periodo?}', 'CompromisoController@getDescentralizacion');
Route::get('ca-16-descentralizacion-progresion/{provincia}', 'CompromisoController@getDescentralizacionProgresion');

Route::get('ca-16-facturacion/{periodo?}', 'CompromisoController@getFacturacion');
Route::get('ca-16-facturacion-progresion/{provincia}', 'CompromisoController@getFacturacionProgresion');

Route::get('ca-16-datos-reportables/{periodo?}', 'CompromisoController@getDatos');
Route::get('ca-16-datos-reportables-progresion/{provincia}', 'CompromisoController@getDatosProgresion');

Route::get('ca-16-dependencia/{periodo?}', 'CompromisoController@getDependencia');
Route::get('ca-16-dependencia-progresion/{provincia}', 'CompromisoController@getDependenciaProgresion');

/**
 * USUARIO
 */
Route::get('perfil', 'UserController@getProfile');
Route::get('ajustes', 'UserController@getEditProfile');
Route::post('ajustes', 'UserController@postEditProfile');
Route::get('new-password', 'UserController@getNewPassword');
Route::post('new-password', 'UserController@postNewPassword');
Route::get('usuario-imagen', 'UserController@getAvatar');
Route::post('usuario-imagen', 'UserController@postAvatar');
Route::get('usuario-cambiar-pass', 'UserController@modificarContrasenas');

/**
 * CONTACTOS
 */
Route::get('contactos', 'ContactosController@index');
Route::get('listado/{nombre?}', 'ContactosController@listado');
Route::get('tarjeta/{id}', 'ContactosController@tarjeta');
Route::get('mensajes/{id_from}/{id_to}', 'ContactosController@chat');
Route::post('mensajes', 'ContactosController@nuevoMensaje');
Route::get('sonido-notificacion', 'InboxController@notificacion');

/**
 * INBOX
 */
Route::get('inbox', 'InboxController@index');
Route::get('mensajes-inbox/{id_from}/{id_to}', 'InboxController@chat');

/**
 * ABOUT US
 */
Route::get('about-us', 'HomeController@about');
Route::get('contact', 'HomeController@getContacto');
Route::post('contact', 'HomeController@postContacto');

/**
 * ADMIN
 */
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

/********************************************************************************
 *							 	   MISC ROUTES 									*
 ********************************************************************************/
Route::get('departamentos/{provincia}', 'GeoController@departamentos');
Route::get('localidades/{provincia}/{departamento}', 'GeoController@localidades');

Route::get('phpinfo', function () {
		phpinfo();
	});

Route::get('informe-mensual', 'ReportesController@getReporteSirge');

/********************************************************************************
 *								 	TEST ROUTES 								*
 ********************************************************************************/
Route::get('excel', 'EfectoresController@generarTabla');

/********************************************************************************
 *								 	WS ROUTES 									*
 ********************************************************************************/
Route::get('descargar-rechazos/{lote}', 'RechazosController@descargarExcelLote');
Route::get('rechazos-generar/{lote}', 'RechazosController@generarExcelRechazos');
Route::get('ver-rechazos/{lote}', 'RechazosController@verRechazos');
Route::get('rechazos-curl/{lote}', 'RechazosController@curlRechazo');
Route::get('convertir-en-json-de-jsons', 'RechazosController@convertirEnJsonDeJsons');

/********************************************************************************
 *								 	AUTH FILTER									*
 ********************************************************************************/
Route::filter('auth', function () {
		if (Auth::guest()) {header("Refresh:0; url=login");
		}
	}
);

/**
 * COMPONENTES
 */
Route::get('componentes/{odp}/{provincia?}/{year?}', 'ComponentesController@getResumenODP');

Route::get('ceb-resumen/{periodo?}/{provincia?}', 'ComponentesController@getDetalleProvincia');
Route::get('componentes-odp1-evolucion/{provincia?}', 'ComponentesController@getEvolucionODP1');
Route::get('componentes-control-embarazadas/{periodo?}/{provincia?}', 'ComponentesController@getResumenODP2');
Route::get('componentes-metas-ca/{periodo?}/{provincia?}', 'ComponentesController@getResumenODP2');
Route::get('componentes-control-ninos/{periodo?}/{provincia?}', 'ComponentesController@getResumenODP2');
Route::get('componentes-mujeres-cu/{periodo?}/{provincia?}', 'ComponentesController@getResumenODP2');
Route::get('componentes-control-adolescentes/{periodo?}/{provincia?}', 'ComponentesController@getResumenODP2');
Route::get('carga-datos-odp', 'ComponentesController@getCarga');
Route::post('carga-odp', 'ComponentesController@postCarga');
Route::get('odp-resumen/{odp}/{periodo?}/{provincia?}', 'ComponentesController@getDetalleProvinciaODP');
Route::get('componentes-odp2-evolucion/{provincia?}', 'ComponentesController@getEvolucionODP1');
Route::get('descripcion-indicador/{indicador?}', 'ComponentesController@getDescripcionIndicador');
Route::get('metas-odp-indicador/{indicador}/{provincia}/{tipo_meta}/{year}', 'ComponentesController@getFormularioMetas');

/**
 * SIISA WEB SERVICES
 */
Route::get('consulta-siisa-renaper/{nrodoc}/{sexo?}', 'WebServicesController@siisaXMLRequest');
Route::get('cruce-siisa-sirge', 'WebServicesController@cruzarBeneficiariosConSiisa');

/**
 * EXCEPCIONES
 */
Route::get('limite-info-priorizada', 'ExcepcionesController@index');
Route::post('limite-info-priorizada', 'ExcepcionesController@edit');

/**
 * TABLERO DE CONTROL
 */
Route::get('tablero', 'TableroController@index');
Route::get('main-tablero/{periodo}/{provincia}', 'TableroController@main');
Route::get('tablero-listado-table/{periodo}/{provincia}', 'TableroController@listadoTabla');
Route::get('tablero-modificar-indicador/{id}', 'TableroController@getModificar');
Route::post('tablero-modificar-indicador', 'TableroController@postModificar');
Route::get('tablero-observar-indicador/{id}', 'TableroController@getObservacion');
Route::post('nueva-observacion', 'TableroController@postObservacion');
Route::get('procesar-tablero/{archivo}', 'TableroController@procesarArchivo');
Route::post('nuevo-lote-tablero/{id_subida}', 'TableroController@nuevoLote');
Route::post('aceptar-indicadores', 'TableroController@aceptar');
Route::post('rechazar-indicadores', 'TableroController@rechazar');
Route::get('administrar-tablero', 'TableroController@administracion');
Route::get('tablero-administracion-table/{provincia}/{periodo?}', 'TableroController@listadoAdministracionTabla');
Route::get('tablero-descargar-tabla/{provincia}/{periodo?}', 'TableroController@excelAdministracionTabla');
Route::post('aceptar-periodo', 'TableroController@aceptarPeriodo');
Route::post('rechazar-periodo', 'TableroController@rechazarPeriodo');
Route::get('tablero-rechazados-table', 'TableroController@listadoRechazadosTabla');
Route::get('listado-descargar-tabla/{periodo}/{provincia}', 'TableroController@excelListadoTabla');
Route::get('rechazados-descargar-tabla', 'TableroController@excelRechazadosTabla');
Route::get('rechazados-tablero', 'TableroController@rechazados');
Route::get('select-graficos-tablero', 'TableroController@getSelectGraficosTablero');
Route::get('graficos-tablero/{periodo}/{provincia}/{indicador}', 'TableroController@getGraficoTablero');
Route::get('log-acciones', 'TableroController@getLogAcciones');
Route::get('tablero-log-acciones-table', 'TableroController@listadoAcciones');

/**
*  SIGOP REPORTES (REDIRECT)
*/

Route::get('sigop/reportes', function () {return view('sigop.reportes.main')});;