<div class="row">
	<div class="col-md-7">
		<div id="grafico{{ $indicador }}"></div>
	</div> 
	<div class="col-md-5">
		<form class="form-horizontal">

			<div class="form-group">
				<label class="col-md-9 control-label">Beneficarios oportunos</label>
				<div class="col-md-3">
					<p class="form-control-static">{{ $beneficiarios_oportunos }}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-9 control-label">Beneficarios puntuales</label>
				<div class="col-md-3">
					<p class="form-control-static">{{ $beneficiarios_puntuales }}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-9 control-label">% Beneficarios</label>
				<div class="col-md-3">
					<p class="form-control-static">{{ round ($beneficiarios_puntuales / $beneficiarios_oportunos * 100 , 2) }}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-9 control-label">Denominador</label>
				<div class="col-md-3">
					<p class="form-control-static">{{ $denominador }}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-9 control-label">Resultado</label>
				<div class="col-md-3">
					@if ($denominador != 0)
					<p class="form-control-static">{{ round ($beneficiarios_puntuales / $denominador * 100 , 2) }}</p>
					@else
					<p class="form-control-static">0</p>
					@endif
				</div>
			</div>

		</form>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){

		$("#grafico{{ $indicador }}").highcharts({
			chart: {
	            type: 'column'
	        },
	        title: {
	            text: "{!! $serie['provincia'] !!}"
	        },
	        xAxis: {
	            categories: {!! json_encode($serie['categorias']) !!}
	        },
	        yAxis: {
	            min: 0,
	            title: null,
	            labels: {
	            	enabled: true
	            },
	        },
	        series: {!! json_encode($serie['serie']) !!}
		});

	});
</script>