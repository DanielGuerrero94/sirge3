@extends('content')
@section('content')
<style type="text/css">
	hr {
    border: 0;
    height: 1px;
    /*background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));*/
    background-color: #39CCCC;
}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="box box-warning">
			<div class="box-header">
				<h2 class="box-title">Resultados de indicadores para la provincia de {{ "$provincia->descripcion" }} - periodo {{ $periodo }}</h2>
			</div>
			<div class="box-body">

				<!-- INDICADOR -->
				@foreach ($indicadores as $unIndicador)
				<h4>{{ preg_replace(array("/\-/","/\|/"),".",$unIndicador['indicador']) }}</h4>
				<div class="row">
					<div class="col-md-4">
						<div class="info-box bg-{{$unIndicador['color']}}">
							<span class="info-box-icon"><i class="fa fa-stethoscope"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">RESULTADO {{ preg_replace(array("/\-/","/\|/"),".",$unIndicador['indicador']) }}</span>
								<span class="info-box-number">{{ number_format((float)$unIndicador['resultadoTotal'], 2, '.', '') }}%</span>
								<div class="progress">
									<div class="progress-bar" style="width: 25%"></div>
								</div>
								<span class="progress-description">
									{{ date ('m/y', strtotime($periodo)) }}
								</span>
							</div><!-- /.info-box-content -->
						</div>
					</div>
					<div class="col-md-4">
						<div class="{{ 'indicador-'.preg_replace(array("/\./","/\|/"),"-",$unIndicador['indicador']) }}" style="height: 250px;"></div>
					</div>
					<div class="col-md-4">

							<p><b>Numerador</b></p>
<?php $o_detalles = (object) $unIndicador['detalles']?>
							<p>{!! $o_detalles->numerador !!}</p>
							<p><b>Denominador</b></p>
							<p>{!! $o_detalles->denominador !!}</p>

					</div>
				</div>

				<hr />
				@endforeach
			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button type="button" class="back btn btn-info">Atrás</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){


		@foreach ($grafico as $unGrafico)
			$('.indicador-{{ preg_replace(array("/\./","/\|/"),"-",$unGrafico["indicador"]) }}').highcharts({
			title: {
				text: 'Evolución',
			},
			xAxis: {
				// ULTIMOS 6 MESES
				categories: {!! json_encode($unGrafico["categories"]) !!}
			},
			yAxis: {
				title: {
					text: ''
				},
				plotLines: [
					{
						value: {{ $unGrafico['rangos']['min_verde'] }},
						width: 2,
						dashStyle: 'shortdash',
						color: '#00a65a'
					},
					{
						value: {{ $unGrafico['rangos']['min_yellow'] }},
						width: 2,
						dashStyle: 'shortdash',
						color: '#ffff00'
					},
					{
						value: {{ $unGrafico['rangos']['min_rojo'] }},
						width: 2,
						dashStyle: 'shortdash',
						color: '#ff851b'
					}
				],
				labels : {
					enabled : false
				},
				min : 0
			},
			legend: {
				enabled: false
			},
			series: [{
				name : 'resultado',
				data : {!! json_encode($unGrafico["data"]) !!}
			}]
		});
		@endforeach

		$('.back').click(function(){
			$.get('{{ $back }}' , function(data){
				$('.content-wrapper').html(data);
			});
		});
	});
</script>
@endsection