<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap 3.3.2 -->
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}"  /> -->
    <link rel="stylesheet" type="text/css" href="/var/www/html/sirge3/public/bower_components/admin-lte/bootstrap/css/bootstrap.min.css">
    <!-- Theme style -->
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/admin-lte/dist/css/AdminLTE.css")}}"  /> -->
    <link rel="stylesheet" type="text/css" href="/var/www/html/sirge3/public/bower_components/admin-lte/dist/css/AdminLTE.css">
    <style type="text/css">
    	tbody:before, tbody:after { display: none; }
      	.footer { position: fixed; bottom: 60px; }
      	.page {  margin-left: 49%; }
      	.pagenum:before { content: counter(page); }
      	.resumen , .lugar-dia-hora { text-align: right;}
      	td { text-align: center;  border: solid 1px black; height: 40px; font-weight: bold;}
      	p , li { line-height: 1.5em }
      	body { font-size: 13px}
	</style>
</head>
<body>
<!-- <img src="{{ asset("/dist/img/header-sumar.png") }}" style="width: 100%;"> -->
<img src="/var/www/html/sirge3/public/dist/img/encabezado-cus-sin-linea.jpg" style="margin-left: 2%; width: 100%;">
	<div style="text-align: right">
		<i>{{ $mensaje->valor }}</i>
	</div>
	<hr />
	<table style="width: 100%">
		<tr>
			<td style="font-size:12px;">FORMULARIO DE INFORMACIÓN PRIORIZADA - COBERTURA UNIVERSAL DE SALUD - SUMAR</td>
			<td style="font-size:12px;">Nº {{ $ddjj->id_provincia}}/{{ $ddjj->periodo_reportado}}</td>
		</tr>
	</table>
	<p class="lugar-dia-hora"><b>{{ ucwords(strtolower($ddjj->provincia->descripcion)) }} , {{ $fecha_impresion }}</b></p>
	<p style="font-weight: bold">
		SEÑOR COORDINADOR NACIONAL<br/>
		DR. EDUARDO MARTINEZ <br />		 
		COBERTURA UNIVERSAL DE SALUD - SUMAR
		
	</p>
	<p>
		De mi mayor consideración:
	</p>
	<p style="text-indent: 2em;">
		Por medio de la presente se informa que se encuentra actualizada en el SIRGe Web la Tabla de Efectores correspondiente al mes de
		{{ $fecha_tabla_efectores }}
	</p>
	<p style="text-indent: 2em;">
		De acuerdo con dichos elementos, el número de Efectores Integrantes ascienda a {{ $ddjj->efectores_integrantes }}. Asimismo, el número de Efectores 
		con Compromiso de Gestión firmado en la provincia asciende a {{ $ddjj->efectores_convenio }}.
	</p>
	<p>
		Por otra parte dejo constancia que:
		<ol>
			<li>
				Se encuentra cargado y autorizado el Tablero de Control con los datos correspondientes al período {{ $ddjj->periodo_tablero_control }}.
			</li>
			<li>
				Con fecha {{ $ddjj->fecha_cuenta_capitas }} se remitió al Área de Supervisión y Auditoría de la Gestión Administrativa y Financiera de la UEC
				 la Declaración Jurada que incluye los ingresos y egresos de la Cuenta Cápitas Provincial del SPS durante el mes de {{ $fecha_cc }}, 
				 y la copia del extracto bancario de dicha cuenta correspondiente al mismo período.
			</li>
			<li>
				Con fecha {{ $ddjj->fecha_sirge }} se remitió al Área Sistemas Informáticos de la UEC la Declaración Jurada de Prestaciones, Comprobantes y Uso de Fondos 
				realizado por los efectores correspondientes al Sistema de Reportes de Gestión (SIRGE), actualizando con los datos correspondientes al período {{ $ddjj->periodo_sirge }}.
			</li>
			<li>
				Con fecha {{ $ddjj->fecha_reporte_bimestral }} se remitió al Área Planificación Estratégica de la UEC, el Reporte bimestral de Prestaciones del SPS y 
				el Reporte bimestral de Uso de Fondos del SPS correspondientes al bimestre Nº {{ $ddjj->bimestre }} del año {{ $ddjj->anio_bimestre }}.
			</li>
		</ol>
	</p>
	<p style="text-indent: 2em;">
		Dejo constancia bajo juramento que la información referida en la presente nota y los soportes ópticos acompañados, han sido elaborados siguiendo todos los procedimientos 
		razonables para garantizar la mayor exactitud posible en los mismos
	</p>
	<p>
		Sin otro particular, saludo a Ud. cordialmente
	</p>
	<div class="footer">
		<div style="margin-left:60%; width: 40%; text-align: left;">
			<p style="border-top: 1px solid; text-align: center;">Firma y sello del Coordinador Ejecutivo</p>
		</div>
		<hr />
		<div class="page">
			Página: <span class="pagenum"></span>
		</div>
	</div>
</body>
</html>