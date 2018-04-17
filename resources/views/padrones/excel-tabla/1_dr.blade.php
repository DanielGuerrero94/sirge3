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
		<td class="title-sumar">Informe de datos reportables</td>
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
		<td class="table-header">OPERACION</th>
		<td class="table-header">ESTADO</th>
		<td class="table-header">NUMERO_COMPROBANTE</th>
		<td class="table-header">CODIGO_PRESTACION</th>
		<td class="table-header">SUBCODIGO_PRESTACION</th>
		<td class="table-header">PRECIO_UNITARIO</th>
		<td class="table-header">FECHA_PRESTACION</th>
		<td class="table-header">CLAVE_BENEFICIARIO</th>
		<td class="table-header">TIPO_DOCUMENTO</th>
		<td class="table-header">CLASE_DOCUMENTO</th>
		<td class="table-header">NUMERO_DOCUMENTO</th>
		<td class="table-header">DATOS_REPORTABLES</th>
		<td class="table-header">ORDEN</th>
		<td class="table-header">EFECTOR</th>
		<td class="table-header">LOTE</th>
		<td class="table-header">MOTIVOS</th>
		
	</tr>
	@foreach($rechazos as $rechazo)
	<tr>		
		<?php $registros = json_decode($rechazo->registro); if(isset($registros->clave_beneficiario)){ $registros->clave_beneficiario = '"' . $registros->clave_beneficiario . '"';}?>
		<td>{{ $registros->operacion  or '' }}</td>
		<td>{{ $registros->estado  or '' }}</td>
		<td>{{ $registros->numero_comprobante  or '' }}</td>
		<td>{{ $registros->codigo_prestacion  or '' }}</td>
		<td>{{ $registros->subcodigo_prestacion  or '' }}</td>				
		<td>{{ $registros->precio_unitario  or '' }}</td>
		<td>{{ $registros->fecha_prestacion  or '' }}</td>
		<td>{{ $registros->clave_beneficiario  or '' }}</td>
		<td>{{ $registros->tipo_documento  or '' }}</td>
		<td>{{ $registros->clase_documento  or '' }}</td>
		<td>{{ $registros->numero_documento  or '' }}</td>
		<td>{{ $registros->datos_deportables  or '' }}</td>
		<td>{{ $registros->orden  or '' }}</td>	
		<td>{{ $registros->efector  or '' }}</td>
		<td>{{ $registros->lote  or '' }}</td>
     	<td>{{ $rechazo->motivos or '' }} </td>
      		
	</tr>
	@endforeach
</table>