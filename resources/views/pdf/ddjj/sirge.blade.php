<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap 3.3.2 -->
    <link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}"  />
    <!-- Theme style -->
    <link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/admin-lte/dist/css/AdminLTE.css")}}"  />
    <style type="text/css">tbody:before, tbody:after { display: none; }</style>
</head>
<body>
	
	<table class="table">
		<tr>
			<th>Lote</th>
			<th>Ingresados</th>
			<th>Modificados</th>
			<th>Rechazados</th>
		</tr>
	@foreach ($lotes as $lote)
		<tr>
			<td>{{ $lote->lote }}</td>
			<td>{{ $lote->registros_in }}</td>
			<td>{{ $lote->registros_mod }}</td>
			<td>{{ $lote->registros_out }}</td>
		</tr>
	@endforeach
	</table>
</body>