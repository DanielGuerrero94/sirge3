
<style type="text/css">

	.table-header {
		font-weight: bold;
		text-align: center;
		background-color: #00C0Ef;
	}

	.table-title , .title-sumar{
		color: #FFFFFF;
		font-weight: bold;
		background-color: #00C0Ef;
	}

</style>

<table class="table">
	<tr>
		<td class="title-sumar">SUMAR</td>
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
		<td class="table-header">DEPENDENCIA</td>
		<td class="table-header">RURAL</td>
		<td class="table-header">CICS</td>
		<td class="table-header">ID CATEGORIZACION</td>
		<td class="table-header">SIGLA CATEGORIZACION</td>
		<td class="table-header">CATEGORIZACION</td>
		<td class="table-header">DEPENDENCIA SANITARIA</td>
		<td class="table-header">COMPROMISO GESTION</td>
		<td class="table-header">SISTEMA HCD</td>
		<td class="table-header">RECUPERA COSTOS</td>
		<td class="table-header">OSP</td>
		<td class="table-header">PAMI</td>
		<td class="table-header">OS DIRECTO</td>
		<td class="table-header">OTRO</td>
		<td class="table-header">HPGD</td>
		<td class="table-header">CATEGORIA MATERNIDAD</td>
		<td class="table-header">CUMPLE CONE</td>
		<td class="table-header">CATEGORIA NEONATOLOGIA</td>
		<td class="table-header">OPERA MALFORMACIONES</td>
		<td class="table-header">CATEGORIA CC</td>
		<td class="table-header">CATEGORIA IAM</td>
		<td class="table-header">RED FLAP</td>
		<td class="table-header">ID PROVINCIA</td>
		<td class="table-header">NOMBRE PROVINCIA</td>
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
			<td>{{ $efector->dependencia or ''}}</td>
			<td>{{ $efector->rural or ''}}</td>
			<td>{{ $efector->cics or ''}}</td>
			<td>{{ $efector->id_categorizacion or ''}}</td>
			<td>{{ $efector->sigla_categorizacion or ''}}</td>
			<td>{{ $efector->categorizacion or ''}}</td>
			<td>{{ $efector->dependencia_sanitaria or ''}}</td>
			<td>{{ $efector->compromiso_gestion or ''}}</td>
			<td>{{ $efector->nombre_hce or ''}}</td>
			<td>{{ $efector->recupera_costos or ''}}</td>
			<td>{{ $efector->osp or ''}}</td>
			<td>{{ $efector->pami or ''}}</td>
			<td>{{ $efector->os_directo or ''}}</td>
			<td>{{ $efector->otro or ''}}</td>
			<td>{{ $efector->hpgd or ''}}</td>
			<td>{{ $efector->categoria_maternidad or '' }}</td>
			<td>{{ $efector->cumple_cone or 'N' }}</td>
			<td>{{ $efector->categoria_neonatologia or '' }}</td>
			<td>{{ $efector->opera_malformaciones or 'N' }}</td>
			<td>{{ $efector->categoria_cc or '' }}</td>
			<td>{{ $efector->categoria_iam or '' }}</td>
			<td>{{ $efector->red_flap or 'N' }}</td>
			<td>{{ $efector->id_provincia or ''}}</td>
			<td>{{ $efector->nombre_provincia or ''}}</td>
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
			<td>{{ $efector->email or ''}}</td>
			<td>{{ $efector->telefono or ''}}</td>
		</tr>
	@endforeach
</table>
