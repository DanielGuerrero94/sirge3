<style type="text/css">
	
	.row-even {
		background-color: #abcdef;
	}

	.table-header {
		font-size: 10px; 
		font-weight: bold; 
		text-align: center;
	}

	.table-title {
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
		<td class="table-header">CUIE</th>
		<td class="table-header">SIISA</th>
		<td class="table-header">NOMBRE EFECTOR</th>
		<td class="table-header">SIGLA TIPO EFECTOR</th>
		<td class="table-header">TIPO EFECTOR</th>
		<td class="table-header">ID PROVINCIA</th>
		<td class="table-header">PROVINCIA</th>
		<td class="table-header">ID DEPARTAMENTO</th>
		<td class="table-header">DEPARTAMENTO</th>
		<td class="table-header">ID LOCALIDAD</th>
		<td class="table-header">LOCALIDAD</th>
		<td class="table-header">CIUDAD</th>
		<td class="table-header">CODIGO POSTAL</th>
		<td class="table-header">DOMICILIO</th>
		<td class="table-header">RURAL</th>
		<td class="table-header">CICS</th>
		<td class="table-header">SIGLA CATEGORIA</th>
		<td class="table-header">CATEGORIA</th>
		<td class="table-header">SIGLA DEPENDENCIA ADMINISTRATIVA</th>
		<td class="table-header">DEPENDENCIA ADMINISTRATIVA</th>
		<td class="table-header">CODIGO PROVINCIAL EFECTOR</th>
		<td class="table-header">DEPENDENCIA SANITARIA</th>
		<td class="table-header">INTEGRANTE</th>
		<td class="table-header">COMPROMISO GESTION</th>
		<td class="table-header">NUMERO COMPROMISO</th>
		<td class="table-header">FIRMANTE</th>
		<td class="table-header">SUSCRIPCION</th>
		<td class="table-header">INICIO</th>
		<td class="table-header">FIN</th>
		<td class="table-header">PAGO INDIRECTO</th>
		<td class="table-header">NUMERO CONVENIO</th>
		<td class="table-header">FIRMANTE</th>
		<td class="table-header">NOMBRE TERCER ADMINISTRADOR</th>
		<td class="table-header">CODIGO TERCER ADMINISTRADOR</th>
		<td class="table-header">SUSCRIPCION</th>
		<td class="table-header">INICIO</th>
		<td class="table-header">FIN</th>
		<td class="table-header">PRIORIZADO</th>
		<td class="table-header">PPAC</th>
		<td class="table-header">PERINATAL AC</th>
		<td class="table-header">ADDENDA PERINATAL</th>
		<td class="table-header">FECHA FIRMA</th>
		<td class="table-header">CATEGORIA NEONATAL</th>
		<td class="table-header">CATEGORIA OBSTETRICO</th>
		<td class="table-header">NOMBRE REFERENTE</th>
		<td class="table-header">INTERNET</th>
		<td class="table-header">FACTURA DESCENTRALIZADA</th>
		<td class="table-header">FACTURA ONLINE</th>
		<td class="table-header">ID ESTADO</th>
		<td class="table-header">ESTADO</th>
		<td class="table-header">ADDENDAS</th>
	</tr>
	@foreach($efectores as $key => $efector)
		@if ($key % 2 == 0)
		<tr>
		@else
		<tr class="row-even">
		@endif
			<td>{{$efector->cuie  or '' }}</td>
			<td>{{$efector->siisa  or '' }}</td>
			<td>{{$efector->nombre  or '' }}</td>
			<td>{{$efector->id_tipo_efector  or '' }}</td>
			<td>{{$efector->tipo->descripcion  or '' }}</td>
			<td>{{$efector->geo->id_provincia or '' }}</td>
			<td>{{$efector->geo->provincia->descripcion or '' }}</td>
			<td>{{$efector->geo->id_departamento or '' }}</td>
			<td>{{$efector->geo->departamento->nombre_departamento or '' }}</td>
			<td>{{$efector->geo->id_localidad or '' }}</td>
			<td>{{$efector->geo->localidad->nombre_localidad or '' }}</td>
			<td>{{$efector->geo->ciudad or '' }}</td>
			<td>{{$efector->codigo_postal or '' }}</td>
			<td>{{$efector->domicilio or '' }}</td>
			<td>{{$efector->rural or '' }}</td>
			<td>{{$efector->cics or '' }}</td>
			<td>{{$efector->categoria->sigla  or '' }}</td>
			<td>{{$efector->categoria->descripcion  or '' }}</td>
			<td>{{$efector->dependencia->sigla or '' }}</td>
			<td>{{$efector->dependencia->descripcion or '' }}</td>
			<td>{{$efector->codigo_provincial_efector or '' }}</td>
			<td>{{$efector->dependencia_sanitaria or '' }}</td>
			<td>{{$efector->integrante or '' }}</td>
			<td>{{$efector->compromiso_gestion or '' }}</td>
			<td>{{$efector->compromiso->numero_compromiso  or '' }}</td>
			<td>{{$efector->compromiso->firmante  or '' }}</td>
			<td>{{$efector->compromiso->fecha_suscripcion  or '' }}</td>
			<td>{{$efector->compromiso->fecha_inicio  or '' }}</td>
			<td>{{$efector->compromiso->fecha_fin  or '' }}</td>
			<td>{{$efector->compromiso->pago_indirecto  or '' }}</td>
			<td>{{$efector->convenio->numero_convenio  or '' }}</td>
			<td>{{$efector->convenio->firmante  or '' }}</td>
			<td>{{$efector->convenio->nombre_tercer_administrador  or '' }}</td>
			<td>{{$efector->convenio->codigo_tercer_administrador  or '' }}</td>
			<td>{{$efector->convenio->fecha_suscripcion  or '' }}</td>
			<td>{{$efector->convenio->fecha_inicio  or '' }}</td>
			<td>{{$efector->convenio->fecha_fin  or '' }}</td>
			<td>{{$efector->priorizado or '' }}</td>
			<td>{{$efector->ppac  or '' }}</td>
			<td>{{$efector->peritanal->perinatal_ac  or '' }}</td>
			<td>{{$efector->perinatal->addenda_perinatal  or '' }}</td>
			<td>{{$efector->perinatal->fecha_addenda_perinatal  or '' }}</td>
			<td>{{$efector->neonatal->info->categoria  or '' }}</td>
			<td>{{$efector->obstetrico->info->categoria  or '' }}</td>
			<td>{{$efector->referente->nombre  or '' }}</td>
			<td>{{$efector->internet->internet  or '' }}</td>
			<td>{{$efector->internet->factura_descentralizada  or '' }}</td>
			<td>{{$efector->internet->factura_on_line  or '' }}</td>
			<td>{{$efector->id_estado or '' }}</td>
			<td>{{$efector->estado->descripcion or '' }}</td>
			@if (count ($efector->addendas))
				@foreach($efector->addendas as $k => $ad)
					{{--*/ $addendas[$k][] = $ad->tipo->nombre /*--}}
					{{--*/ $addendas[$k][] = $ad->fecha_addenda /*--}}
				@endforeach
				<td>{{ json_encode($addendas , JSON_UNESCAPED_SLASHES)  or '' }}</td>
			@else
			<td></td>
			@endif
		</tr>
	@endforeach
</table>