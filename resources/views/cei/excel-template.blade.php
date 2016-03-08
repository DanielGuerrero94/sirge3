<table>
	<tr>
		<th>Provincia</th>
		<th>Periodo</th>
		<th>Tipo</th>
		<th>Beneficiarios oportunos</th>
		<th>Beneficiarios puntuales</th>
		<th>Denominador</th>
	</tr>
	@foreach ($resultados as $registros)
		@foreach ($registros as $registro)
		<tr>
			<td>{{$registro->provincia}}</td>	
			<td>{{$registro->periodo}}</td>	
			<td>{{$registros->tipo}}</td>	
			<td>{{$registro->resultados->beneficiarios_oportunos}}</td>	
			<td>{{$registro->resultados->beneficiarios_puntuales}}</td>	
			<td>{{$registro->resultados->denominador}}</td>	
		</tr>
		@endforeach
	@endforeach
</table>