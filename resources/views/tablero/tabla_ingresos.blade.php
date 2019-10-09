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
		<td class="title-sumar">PACES</td>
		<td class="title-sumar">Ingresos Tablero de Control - {{$periodo}}</td>
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
		<td class="table-header">PERIODO</th>
		<td class="table-header">PROVINCIA</th>
		<td class="table-header">INDICADOR</th>
		<td class="table-header">NUMERADOR</th>
		<td class="table-header">DENOMINADOR</th>
		<td class="table-header">ESTADO</th>
	</tr>
	@foreach($tablero as $key => $registro)
		<tr>
			<td>{{$registro['periodo']  or '' }}</td>
			<td>{{$registro['provincia']  or '' }}</td>
			<td><?php echo "'".$registro['indicador']?></td>
			<td>{{$registro['numerador']  or '' }}</td>
			<td>{{$registro['denominador']  or '' }}</td>
			<td>{{$registro['estado'] or ''}}</td>
		</tr>
	@endforeach
</table>
