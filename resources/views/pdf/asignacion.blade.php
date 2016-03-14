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
			<img width="700px" src="{{ asset("/dist/img/header-sumar.png") }}">
			<div class="box box-danger">
				<div class="box-header">
					<h2 class="box-title">Asignación requerimiento Nº: <b>{{ $solicitud->id }}</b></h2>
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
					Ha sido asignado al operador <b>{{ $solicitud->operador->nombre }}</b>, quien será el encargado de brindarle una solución.
					<br/>
					<br/>
					Para visualizar el estado y detalle de su solicitud ingrese al SIRGe Web, opción <b>SOLICITUDES</b>
					<br/>
					Desde ya, muchas gracias
					<br/>
					<br/>
					<br/>
					<address>
						<strong>Programa SUMAR.</strong><br>
							Av. 9 de Julio 1925 P.12<br>
							Ciudad Autónoma de Buenos Aires, CP C1072AAH<br>
							<abbr>Tel:</abbr> (011) 4331-5701
						</address>

						<address>
							<strong>Área Sistemas Informáticos</strong><br>
							<a href="mailto:#">sistemasuec@gmail.com</a>
						</address>
				</div>
			</div>
		</div>
	</div>
</body>