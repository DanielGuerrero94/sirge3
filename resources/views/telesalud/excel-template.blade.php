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
		<td class="title-sumar">PACES</td>
		<td class="title-sumar">Telesalud</td>
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

<th>motivo</th>
<th>estado_actual</th>
<th>tratamiento</th>
<th>sospecha</th>
<th>estado_consulta</th>
<th>fecha</th>
<th>hospitalizado</th>
<th>nhc_local</th>
<th>estudio_ecg</th>
<th>estudio_eeg</th>
<th>estudio_eco</th>
<th>estudio_tac</th>
<th>estudio_rayosx</th>
<th>estudio_otros</th>
<th>examen_peso</th>
<th>examen_estatura</th>
<th>examen_imc</th>
<th>examen_pulso</th>
<th>examen_respiracion</th>
<th>examen_temperatura</th>
<th>examen_sistolica</th>
<th>examen_diastolica</th>
<th>creador_nombre</th>
<th>creador_apellido</th>
<th>creador_email</th>
<th>asignado_nombre</th>
<th>asignado_apellido</th>
<th>asignado_email</th>
<th>centro_origen</th>
<th>centro_destino</th>
<th>paciente_nombre</th>
<th>paciente_apellido</th>
<th>paciente_fecha_nacimiento</th>
<th>paciente_tipo_documento</th>
<th>paciente_numero_documento</th>


	</tr>
	@foreach ($resultados as $registro)
		<tr style="height: 15px">
<td>{{$registro->motivo}}</td>
<td>{{$registro->estado_actual}}</td>
<td>{{$registro->tratamiento}}</td>
<td>{{$registro->sospecha}}</td>
<td>{{$registro->estado_consulta}}</td>
<td>{{$registro->fecha}}</td>
<td>{{$registro->hospitalizado}}</td>
<td>{{$registro->nhc_local}}</td>
<td>{{$registro->estudio_ecg}}</td>
<td>{{$registro->estudio_eeg}}</td>
<td>{{$registro->estudio_eco}}</td>
<td>{{$registro->estudio_tac}}</td>
<td>{{$registro->estudio_rayosx}}</td>
<td>{{$registro->estudio_otros}}</td>
<td>{{$registro->examen_peso}}</td>
<td>{{$registro->examen_estatura}}</td>
<td>{{$registro->examen_imc}}</td>
<td>{{$registro->examen_pulso}}</td>
<td>{{$registro->examen_respiracion}}</td>
<td>{{$registro->examen_temperatura}}</td>
<td>{{$registro->examen_sistolica}}</td>
<td>{{$registro->examen_diastolica}}</td>
<td>{{$registro->creador_nombre}}</td>
<td>{{$registro->creador_apellido}}</td>
<td>{{$registro->creador_email}}</td>
<td>{{$registro->asignado_nombre}}</td>
<td>{{$registro->asignado_apellido}}</td>
<td>{{$registro->asignado_email}}</td>
<td>{{$registro->centro_origen}}</td>
<td>{{$registro->centro_destino}}</td>
<td>{{$registro->paciente_nombre}}</td>
<td>{{$registro->paciente_apellido}}</td>
<td>{{$registro->paciente_fecha_nacimiento}}</td>
<td>{{$registro->paciente_tipo_documento}}</td>
<td>{{$registro->paciente_numero_documento}}</td>
		</tr>
	@endforeach
</table>
