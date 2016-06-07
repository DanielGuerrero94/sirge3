<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
	
	/*
	.row-even {
		background-color: #abcdef;
	}
	*/

	.table-header {
		font-size: 10px; 
		font-weight: bold; 
		text-align: center;
		background-color: #00c0ef;
	}

	.table-title , .title-sumar{
		color: #ffffff;
		font-size: 12px;
		font-weight: bold;
		background-color: #00c0ef;
	}

	td {
		font-size: 9px;
	}

</style>

<table class="table">
	<tr>
		<td class="title-sumar">PROGRAMA SUMAR</td>
		<td class="title-sumar">Tabla de codigos</td>
	</tr>
	<tr>
		<td>Fecha de &uacute;ltima actualizaci&oacute;n: </td>
		<td>{{date('d/m/Y')}} </td>
	</tr>
	<tr>
		<td>Origen de datos: </td>
		<td>SIRGe Web V.3</td>
	</tr>
	<tr></tr>
	<tr>
		<td class="table-header">CODIGO_PRESTACION</th>
		<td class="table-header">TIPO</th>
		<td class="table-header">OBJETO</th>
		<td class="table-header">DIAGNOSTICO</th>
		<td class="table-header">DESCRIPCION_PRESTACION</th>
		<td class="table-header">DESCRIPCION_DIAGNOSTICO</th>		
	</tr>
	@foreach($codigos as $key => $codigo)
		@if ($key % 2 == 0)
		<tr>
		@else
		<tr>
		@endif
			<td>{{$codigo->codigo_prestacion  or '' }}</td>
			<td>{{$codigo->tipo  or '' }}</td>
			<td>{{$codigo->objeto  or '' }}</td>
			<td>{{$codigo->diagnostico  or '' }}</td>
			<td>{{$codigo->descripcion_grupal  or '' }}</td>
			<td>{{$codigo->descripcion_diagnostico or '' }}</td>						
		</tr>
	@endforeach
</table>