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
</head>
<body>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<img src="/var/www/html/sirge3/public/dist/img/Zocalo_SUMAR.jpg" style="margin-left: 2%; width: 100%;">
			<div class="box box-danger">
				<div class="box-header">
					<h2 class="box-title">Cierre requerimiento Nº: <b>{{ $solicitud->id }}</b></h2>
					<hr>
				</div>
				<div class="box-body">
					<h4><u>Estimado {{ $solicitud->usuario->nombre }}:</u></h4>
					<br/>
					<br/>
					Le informamos que la solicitud ingresada el día <b>{{ $solicitud->fecha_solicitud }}</b> con la siguiente descripción:
					<br/>
					<br/>
					<blockquote>
						<small>{{ $solicitud->descripcion_solicitud }}</small>
					</blockquote>
					Ha sido solucionada por el operador <b>{{ $solicitud->operador->nombre }}</b> con el siguiente detalle.
					<br/>
					<br/>
					<blockquote>
						<small>{{ $solicitud->descripcion_solucion }}</small>
					</blockquote>					
					<br/>
					@if(isset($solicitud->adjuntos->nombre_actual_respuesta))
					<b>Atencion!</b> Tiene documentos adjuntos en SIRGe sección "Mis solicitudes".
					@endif
					<br/>
					<br/>
					Para visualizar el estado y detalle de su solicitud ingrese al SIRGe Web, opción <b>SOLICITUDES</b>
					<br/>
					Desde ya, muchas gracias
					<br/>
					<br/>
					<br/>
					<address>
						<strong>SUMAR</strong><br>
							Av. Hipolito Yrigoyen  440/60 P.3<br>
							Ciudad Autónoma de Buenos Aires, CP C1086AAF<br>
							<abbr>Tel:</abbr> (011) 7090-3600
						</address>

						<address>
							<strong>Área Cápitas - Sistemas de Información</strong><br>
							<a href="mailto:#">sistemasuec@gmail.com</a>
						</address>
				</div>
			</div>
		</div>
	</div>
</body>
