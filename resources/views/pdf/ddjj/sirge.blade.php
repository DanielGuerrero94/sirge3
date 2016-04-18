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
      	.resumen { text-align: right;}
	</style>
</head>
<body>
	<!-- <img src="{{ asset("/var/www/html/sirge3/public/dist/img/header-sumar.png") }}" style="width: 100%;"> -->
	<img src="/var/www/html/sirge3/public/dist/img/header-sumar.png" style="width: 100%;">
	<hr />
	<p class="resumen"><b>{{ $jurisdiccion->descripcion }} , {{ $ddjj->fecha_impresion }}</b></p>
	<p><b>SEÑOR</b></p>
	<p><b>COORDINADOR DEL ÁREA SISTEMAS INFORMÁTICOS</b></p>
	<p><b>LIC. JAVIER E. MINSKY</b></p>
	<p><b><u>S&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;D</u></b></p>
	<p>De mi mayor consideración</p>
	<p style="text-indent: 10em;">Por medio de la presente elevo a Ud. en carácter de Declaración Jurada, 
	los últimos resultados del proceso de validación de la información en el <b>SIRGe Web</b> correspondiente a
	{{ $nombre_padron }} reportadas por los efectores desde la última presentación hasta el día de la fecha, detalladas en el siguiente cuadro</p>

	<p><b><u>INFORMACIÓN DE {{ $nombre_padron }}</u></b></p>
	<div style="width: 100%; margin-left: 1%;">
		<table class="table table-condensed table-bordered">
			<tr class="active" style="text-align:center;">
				<th>Lote</th>
				@if ($padron == 4)
				<th>Obra Social</th>
				@endif
				<th>Ingresados</th>
				<th>Modificados</th>
				<th>Rechazados</th>
			</tr>
		@foreach ($lotes as $lote)
			<tr style="text-align:right;">
				<td>{{ $lote->lote }}</td>
				@if ($padron == 4)
				<td>{{ $lote->nombre }}</td>				
				@endif
				<td>{{ number_format($lote->registros_in) }}</td>
				<td>{{ number_format($lote->registros_mod) }}</td>
				<td>{{ number_format($lote->registros_out) }}</td>
			</tr>
		@endforeach
			<tr class="active">
				<td>Totales</td>
				@if ($padron == 4)
				<td></td>
				@endif
				<td class="resumen">{{ number_format($resumen['in']) }}</td>
				<td class="resumen">{{ number_format($resumen['mod']) }}</td>
				<td class="resumen">{{ number_format($resumen['out']) }}</td>
			</tr>
		</table>
	</div>
	<p>Sin otro particular saludo a Ud. con mi consideración más distinguida</p>
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
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