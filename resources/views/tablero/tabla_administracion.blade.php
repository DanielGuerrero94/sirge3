<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">

	/*
	.row-even {
		background-color: #abcdef;
	}
	*/

	.table-header {
		font-size: 10;
		font-weight: bold;
		text-align: center;
		background-color: #00c0ef;
	}

	.table-title , .title-sumar{
		color: #ffffff;
		font-size: 12;
		font-weight: bold;
		background-color: #00c0ef;
	}

	td {
		font-size: 9;
	}

</style>

<table class="table">
	<tr>
		<td class="title-sumar">SUMAR</td>
		<td class="title-sumar">Administracion Tablero de Control</td>
	</tr>
	<tr>
		<td>Fecha de ultima actualizacion: </td>
		<td>{{date('d/m/Y')}} </td>
	</tr>
	<tr>
		<td>Origen de datos: </td>
		<td>SIRGe Web V.3</td>
	</tr>
	<tr></tr>
	<tr>
		<td class="table-header">PERIODO</th>
		<td class="table-header">PROVINCIA</th>
		<td class="table-header">RESUELTO POR</th>
		<td class="table-header">CANTIDAD INGRESADA</th>
		<td class="table-header">ESTADO</th>
	</tr>
	@foreach($tablero as $key => $registro)
		<tr>
			<td>{{$registro['periodo']  or '' }}</td>
			<td>{{$registro['provincia_descripcion']  or '' }}</td>
			<td>{{$registro['usuario_nombre']  or '' }}</td>
			<td>{{$registro['completado']}}</td>
			<td>{{$registro['estado']  or '' }}</td>
		</tr>
	@endforeach
</table>
