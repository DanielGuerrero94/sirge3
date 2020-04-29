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
		<td class="title-sumar">Rechazados Tablero de Control</td>
	</tr>
	<tr>
		<td>Fecha de &uacute;
ltima actualizaci&oacute;
n: </td>
		<td>{{date('d/m/Y')}} </td>
	</tr>
	<tr>
		<td>Origen de datos: </td>
		<td>SIRGe Web V.3</td>
	</tr>
	<tr></tr>
	<tr>
		<td class="table-header">ID</th>
		<td class="table-header">FECHA</th>
		<td class="table-header">PERIODO</th>
		@if($id_entidad == 1)
		    <td class="table-header">PROVINCIA</th>
        @endif
		<td class="table-header">RESUELTO POR</th>
		<td class="table-header">ESTADO</th>
	</tr>
	@foreach($tablero as $key => $registro)
		<tr>
			<td>{{$registro['id']  or '' }}</td>
			<td>{{$registro['fecha']}}</td>
			<td>{{$registro['periodo']  or '' }}</td>
			@if($id_entidad == 1)
				<td>{{$registro['provincia_descripcion']  or '' }}</td>
			@endif
			<td>{{$registro['nombre']  or '' }}</td>
			<td>{{$registro['estado']  or '' }}</td>
		</tr>
	@endforeach
</table>
