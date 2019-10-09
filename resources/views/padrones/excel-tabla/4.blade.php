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
		<td class="title-sumar">PACES</td>
		<td class="title-sumar">Tabla de Rechazos</td>
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
		<td class="table-header">TIPO_DOCUMENTO</th>
		<td class="table-header">NUMERO_DOCUMENTO</th>
		<td class="table-header">NOMBRE_APELLIDO</th>
		<td class="table-header">SEXO</th>
		<td class="table-header">CODIGO_OSP</th>
		<td class="table-header">CODIGO_POSTAL</th>
		<td class="table-header">ID_PROVINCIA</th>
		<td class="table-header">TIPO_AFILIADO</th>		
		<td class="table-header">LOTE</th>
		<td class="table-header">MOTIVOS</th>
	</tr>
	@foreach($rechazos as $rechazo)
	<tr>		
		<?php $registros = json_decode($rechazo->registro); ?>
		<td>{{ $registros->tipo_documento  or '' }}</td>
		<td>{{ $registros->numero_documento  or '' }}</td>
		<td>{{ $registros->nombre_apellido  or '' }}</td>
		<td>{{ $registros->sexo  or '' }}</td>
		<td>{{ $registros->codigo_osp  or '' }}</td>				
		<td>{{ $registros->codigo_postal  or '' }}</td>
		<td>{{ $registros->id_provincia  or '' }}</td>
		<td>{{ $registros->tipo_afiliado  or '' }}</td>
		<td>{{ $registros->lote  or '' }}</td>
		<td>{{ $rechazo->motivos  or '' }}</td>
	</tr>
	@endforeach
</table>
