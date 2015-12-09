@extends('content')
@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Volumen de descentralización de los efectores</h2>
			</div>
			<div class="box-body">
				<div class="g1"></div>
			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button type="button" class="detalle btn btn-info">Ver detalles</button>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="row">
			<div class="col-md-12">
				<div class="callout callout-warning">
					<h4>Importante!</h4>
					<p>El gráfico de la izquierda corresponde a la descentralización calculada en el período {{$periodo_calculado}}</p>
				</div>
			</div>
			<div class="col-md-12">
				<div class="box box-warning">
					<div class="box-header">
						<h2 class="box-title">Períodos anteriores</h2>
					</div>
					<div class="box-body">
						<p>Desde esta opción podrá ver la descentralización a nivel país de meses anteriores al actual.</p>
					</div>
					<div class="box-footer">
						<div class="btn-group" role="group">
							<button type="button" href="compromiso-anual-16-descentralizacion-periodo-form" class="detalle btn btn-info">Ver detalles</button>
						</div>
					</div>
				</div>	
			</div>
			<div class="col-md-12">
				<div class="box box-warning">
					<div class="box-header">
						<h2 class="box-title">Progresión provincial</h2>
					</div>
					<div class="box-body">
						<p>Desde esta opción podrá ver la evolución de la descentralización de una provincia determinada</p>
					</div>
					<div class="box-footer">
						<div class="btn-group" role="group">
							<button type="button" href="compromiso-anual-16-descentralizacion-progresion-form" class="detalle btn btn-info">Ver detalles</button>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){

		$('.detalle').click(function(){
			var route = $(this).attr('href');
			$.get(route , function(data){
				$('.content-wrapper').html(data);
			});
		});


		$('.g1').highcharts({
	        chart: {
	            type: 'column'
	        },
	        title: {
	            text: ''
	        },
	        xAxis: {
	            categories: {!!$categorias!!},
	            labels : {
					align : 'right' ,
					style: {
						fontSize: '9px',
						fontFamily: 'Verdana, sans-serif'
					}
				}
	        },
	        yAxis: {
	            min: 0,
	            max: 100,
	            title: {
	                text: 'Descentralización (%)'
	            }
	        },
	        tooltip: {
	            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
	            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
	                '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
	            footerFormat: '</table>',
	            shared: true,
	            useHTML: true
	        },
	        plotOptions: {
	            column: {
	                grouping: false,
	                shadow: false,
	                borderWidth: 0
	            }
	        },
	        series: {!! $series !!}
	    });
	});
</script>
@endsection