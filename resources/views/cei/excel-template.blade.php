<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
	
	.row-even {
		background-color: #abcdef;
	}

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
<table>
	<tr>
		<td class="title-sumar">PROGRAMA SUMAR</td>
		<td class="title-sumar">{{$linea_cuidado}}</td>
	</tr>
	<tr>
		<td>Fecha de &uacute;ltima actualizaci&oacute;n: </td>
		<td>{{date('d/m/Y')}} </td>
	</tr>
	<tr>
		<td>Origen de datos: </td>
		<td>SIRGe Web V.3</td>
	</tr>
	<tr>
		
	</tr>
	<tr style="height: 15px">
		<th>Provincia</th>
		<th>Periodo</th>
		<th>Tipo</th>
		<th>Beneficiarios oportunos</th>
		<th>Beneficiarios puntuales</th>
		<th>Denominador</th>
	</tr>
	@foreach ($resultados as $registros)
		@foreach ($registros as $registro)
		<tr style="height: 15px">
			<td style="text-align:right;">{{$registro->provincia}}</td>	
			<td>{{$registro->periodo}}</td>	
			<td>{{$registros->tipo}}</td>	
			<td>{{$registro->resultados->beneficiarios_oportunos}}</td>	
			<td>{{$registro->resultados->beneficiarios_puntuales}}</td>	
			<td>{{$registro->resultados->denominador}}</td>	
		</tr>
		@endforeach
	@endforeach
</table>