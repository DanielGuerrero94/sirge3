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
		<td class="title-sumar">Tabla de Efectores</td>
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
		<td class="table-header">CUIE</td>
		<td class="table-header">SIISA</td>
		<td class="table-header">NOMBRE EFECTOR</td>
		<td class="table-header">DOMICILIO</td>
		<td class="table-header">CODIGO POSTAL</td>
		<td class="table-header">DENOMINACION LEGAL</td>
		<td class="table-header">ID TIPO EFECTOR</td>
		<td class="table-header">SIGLA TIPO EFECTOR</td>
		<td class="table-header">TIPO EFECTOR</td>
		<td class="table-header">RURAL</td>
		<td class="table-header">CICS</td>
		<td class="table-header">ID CATEGORIZACION</td>
		<td class="table-header">SIGLA CATEGORIZACION</td>
		<td class="table-header">CATEGORIZACION</td>
		<td class="table-header">DEPENDENCIA SANITARIA</td>
		<td class="table-header">COD PROVINCIAL</td>
		<td class="table-header">INTEGRANTE</td>
		<td class="table-header">COMPROMISO GESTION</td>
		<td class="table-header">PRIORIZADO</td>
		<td class="table-header">FECHA COMIENZO PRIORIZADO</td>
		<td class="table-header">PPAC</td>
		<td class="table-header">ADDENDA PERINATAL</td>
		<td class="table-header">FECHA ADDENDA PERINATAL</td>
		<td class="table-header">PERINATAL AC</td>
		<td class="table-header">SISTEMA HCD</td>
		<td class="table-header">ID PROVINCIA</td>
		<td class="table-header">INDEC DEPARTAMENTO</td>
		<td class="table-header">DEPARTAMENTO</td>
		<td class="table-header">INDEC LOCALIDAD</td>
		<td class="table-header">LOCALIDAD</td>
		<td class="table-header">CIUDAD</td>
		<td class="table-header">LATITUD</td>
		<td class="table-header">LONGITUD</td>
		<td class="table-header">INTERNET</td>
		<td class="table-header">FACTURA DESCENTRALIZADA</td>
		<td class="table-header">FACTURA ONLINE</td>
		<td class="table-header">NUMERO COMPROMISO</td>
		<td class="table-header">FIRMANTE COMPROMISO</td>
		<td class="table-header">FECHA SUSCRIPCION COMPROMISO</td>
		<td class="table-header">FECHA INICIO COMPROMISO</td>
		<td class="table-header">FECHA FIN COMPROMISO</td>
		<td class="table-header">PAGO INDIRECTO</td>
		<td class="table-header">NUMERO CONVENIO</td>
		<td class="table-header">FIRMANTE CONVENIO</td>
		<td class="table-header">NOMBRE TERCER ADMINISTRADOR</td>
		<td class="table-header">CODIGO TERCER ADMINISTRADOR</td>
		<td class="table-header">FECHA SUSCRIPCION CONVENIO</td>
		<td class="table-header">FECHA INICIO CONVENIO</td>
		<td class="table-header">FECHA FIN CONVENIO</td>
		<td class="table-header">NEONATAL SIISA</td>
		<td class="table-header">ID CATEGORIA NEONATAL</td>
		<td class="table-header">OBSTETRICOS SIISA</td>
		<td class="table-header">OBSTETRICOS ID CATEGORIA</td>
		<td class="table-header">FECHA ADDENDA</td>
		<td class="table-header">EMAIL</td>
		<td class="table-header">TELEFONO</td>
	</tr>
	@foreach($efectores as $key => $efector)
		@if ($key % 2 == 0)
		<tr>
		@else
		<tr>
		@endif
			<td>{{ $efector->cuie or ''}}</td>
			<td> <?php echo "'".$efector->siisa?></td>
			<td>{{ $efector->nombre_efector or ''}}</td>
			<td>{{ $efector->domicilio or ''}}</td>
			<td>{{ $efector->codigo_postal or ''}}</td>
			<td>{{ $efector->denominacion_legal or ''}}</td>
			<td>{{ $efector->id_tipo_efector or ''}}</td>
			<td>{{ $efector->sigla_tipo or ''}}</td>
			<td>{{ $efector->tipo_efector or ''}}</td>
			<td>{{ $efector->rural or ''}}</td>
			<td>{{ $efector->cics or ''}}</td>
			<td>{{ $efector->id_categorizacion or ''}}</td>
			<td>{{ $efector->sigla_categorizacion or ''}}</td>
			<td>{{ $efector->categorizacion or ''}}</td>
			<td>{{ $efector->dependencia_sanitaria or ''}}</td>
			<td>{{ $efector->cod_provincial or ''}}</td>
			<td>{{ $efector->integrante or ''}}</td>
			<td>{{ $efector->compromiso_gestion or ''}}</td>
			<td>{{ $efector->priorizado or ''}}</td>
			<td>{{ $efector->fecha_comienzo_priorizado or ''}}</td>
			<td>{{ $efector->ppac or ''}}</td>
			<td>{{ $efector->addenda_perinatal or ''}}</td>
			<td>{{ $efector->fecha_addenda_perinatal or ''}}</td>
			<td>{{ $efector->perinatal_ac or ''}}</td>
			<td>{{ $efector->sistema_hcd or ''}}</td>
			<td>{{ $efector->id_provincia or ''}}</td>
			<td>{{ $efector->indec_departamento or ''}}</td>
			<td>{{ $efector->departamento or ''}}</td>
			<td>{{ $efector->indec_localidad or ''}}</td>
			<td>{{ $efector->localidad or ''}}</td>
			<td>{{ $efector->ciudad or ''}}</td>
			<td>{{ $efector->latitud or ''}}</td>
			<td>{{ $efector->longitud or ''}}</td>
			<td>{{ $efector->internet or ''}}</td>
			<td>{{ $efector->factura_descentralizada or ''}}</td>
			<td>{{ $efector->factura_online or ''}}</td>
			<td>{{ $efector->numero_compromiso or ''}}</td>
			<td>{{ $efector->firmante_compromiso or ''}}</td>
			<td>{{ $efector->fecha_suscripcion_compromiso or ''}}</td>
			<td>{{ $efector->fecha_inicio_compromiso or ''}}</td>
			<td>{{ $efector->fecha_fin_compromiso or ''}}</td>
			<td>{{ $efector->pago_indirecto or ''}}</td>
			<td>{{ $efector->numero_convenio or ''}}</td>
			<td>{{ $efector->firmante_convenio or ''}}</td>
			<td>{{ $efector->nombre_tercer_administrador or ''}}</td>
			<td>{{ $efector->codigo_tercer_administrador or ''}}</td>
			<td>{{ $efector->fecha_suscripcion_convenio or ''}}</td>
			<td>{{ $efector->fecha_inicio_convenio or ''}}</td>
			<td>{{ $efector->fecha_fin_convenio or ''}}</td>
			<td> <?php echo "'".$efector->neo_siisa?></td>
			<td>{{ $efector->neonatal_id_categoria or ''}}</td>
			<td> <?php echo "'".$efector->obstetricos_siisa?></td>
			<td>{{ $efector->obstetricos_id_categoria or ''}}</td>
			<td>{{ $efector->fecha_addenda_hombres or ''}}</td>
			<td>{{ $efector->email or ''}}</td>
			<td>{{ $efector->telefono or ''}}</td>
		</tr>
	@endforeach
</table>z