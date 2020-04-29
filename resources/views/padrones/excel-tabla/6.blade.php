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
		<td class="title-sumar">SUMAR</td>
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
		<td class="table-header">CUIL_BENEFICIARIO</th>
		<td class="table-header">TIPO_DOCUMENTO</th>
		<td class="table-header">NUMERO_DOCUMENTO</th>
		<td class="table-header">NOMBRE_APELLIDO</th>
		<td class="table-header">SEXO</th>
		<td class="table-header">FECHA_NACIMIENTO</th>
		<td class="table-header">TIPO_BENFICIARIO</th>
		<td class="table-header">CODIGO_PARENTEZCO</th>		
		<td class="table-header">CODIGO_POSTAL</th>
		<td class="table-header">ID_PROVINCIA</th>
		<td class="table-header">CUIL_TITULAR</th>
		<td class="table-header">CODIGO_OS</th>
		<td class="table-header">ULTIMO_APORTE</th>
		<td class="table-header">CUIL_VALIDO</th>
		<td class="table-header">CUIT_EMPLEADOR</th>
		<td class="table-header">LOTE</th>
		<td class="table-header">MOTIVOS</th>
	</tr>
	@foreach($rechazos as $rechazo)
	<tr>		
		<?php $registros = json_decode($rechazo->registro); ?>
		<td>{{ $registros->cuil_beneficiario  or '' }}</td>
		<td>{{ $registros->tipo_documento  or '' }}</td>
		<td>{{ $registros->numero_documento  or '' }}</td>
		<td>{{ $registros->nombre_apellido  or '' }}</td>
		<td>{{ $registros->sexo  or '' }}</td>				
		<td>{{ $registros->fecha_nacimiento  or '' }}</td>
		<td>{{ $registros->tipo_benficiario  or '' }}</td>
		<td>{{ $registros->codigo_parentezco  or '' }}</td>
		<td>{{ $registros->codigo_postal  or '' }}</td>
		<td>{{ $registros->id_provincia  or '' }}</td>
		<td>{{ $registros->cuil_titular  or '' }}</td>
		<td>{{ $registros->codigo_os  or '' }}</td>
		<td>{{ $registros->ultimo_aporte  or '' }}</td>
		<td>{{ $registros->cuil_valido  or '' }}</td>
		<td>{{ $registros->cuit_empleador  or '' }}</td>		
		<td>{{ $registros->lote  or '' }}</td>
		<td>{{ $rechazo->motivos  or '' }}</td>
	</tr>
	@endforeach
</table>
