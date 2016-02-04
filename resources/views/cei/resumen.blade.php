
<!-- MAPAS -->

<div class="row">

	<div class="col-md-4">
		<div class="box box-danger">
			<div class="box-header">
				<h2 class="box-title">C.E.I. Inicial</h2>
			</div>
			<div class="box-body">
				<div id="mapa-cei-0"></div>
			</div>
		</div>
	</div>

	<div class="col-md-8">
		<div class="box box-danger">
			<div class="box-header">
				<h2 class="box-title">C.E.I. Inicial</h2>
			</div>
			<div class="box-body">
				<div id="grafico-cei-0"></div>
			</div>
		</div>
	</div>
	
</div>
<div class="row">

	<div class="col-md-4">
		<div class="box box-warning">
			<div class="box-header">
				<h2 class="box-title">C.E.I. Mínima</h2>
			</div>
			<div class="box-body">
				<div id="mapa-cei-1"></div>
			</div>
		</div>
	</div>

	<div class="col-md-8">
		<div class="box box-warning">
			<div class="box-header">
				<h2 class="box-title">C.E.I. Mínima</h2>
			</div>
			<div class="box-body">
				<div id="grafico-cei-1"></div>
			</div>
		</div>
	</div>

</div>
<div class="row">

	<div class="col-md-4">
		<div class="box box-success">
			<div class="box-header">
				<h2 class="box-title">C.E.I. Adecuada</h2>
			</div>
			<div class="box-body">
				<div id="mapa-cei-2"></div>
			</div>
		</div>
	</div>

	<div class="col-md-8">
		<div class="box box-success">
			<div class="box-header">
				<h2 class="box-title">C.E.I. Adecuada</h2>
			</div>
			<div class="box-body">
				<div id="grafico-cei-2"></div>
			</div>
		</div>
	</div>

</div>

<!-- TREEMAP -->

<script type="text/javascript">
	$(document).ready(function(){

		@foreach ($maps as $map)

		$("#mapa-cei-{{ $map['clase'] }}").highcharts('Map', {
			title : {
				text : ''
			},
			mapNavigation: {
				enabled: true,
				buttonOptions: {
					verticalAlign: 'bottom'
				}
			},
			colorAxis: {
				min: 0
			},
			legend : {
				enabled : true
			},
			plotOptions: {
				series : {
					events: {
						click : function(e){
							var periodo = e.point.periodo;
							var provincia = e.point.provincia;
							var indicador = e.point.indicador;

							$("#grafico-cei-{{ $map['clase'] }}").html('');
							$("#grafico-cei-{{ $map['clase'] }}").load('cei-resumen/' + periodo + '/' + indicador + '/' + provincia);
						}
					}
				}
			},
			series : [{
				data : {!! $map['map-data'] !!},
				mapData: Highcharts.maps['countries/ar/ar-all'],
				joinBy: 'hc-key',
				name: 'C.E.I.',
				states: {
					hover: {
						color: '#BADA55'
					}
				},
				dataLabels: {
					enabled: false,
					format: '{point.properties.postal}'
				},
				cursor : 'pointer'
			}]
		});

		@endforeach

		@foreach ($graficos['info'] as $grafico)

		$("#grafico-cei-{{ $grafico['clase'] }}").highcharts({
			chart: {
	            type: 'column'
	        },
	        title: {
	            text: null
	        },
	        xAxis: {
	            categories: {!! $graficos['categorias'] !!}
	        },
	        yAxis: {
	            min: 0,
	            title: null,
	            labels: {
	            	enabled: true
	            },
	            stackLabels: {
	                enabled: false,
	                formatter: function(){
	                	return this.total;
	                },
	                style: {
	                    //fontWeight: 'bold',
	                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
	                }
	            }
	        },
	        tooltip: {
	            //headerFormat: '<b>{point.x}</b><br/>',
	            //pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
	        },
	        plotOptions: {
	            /*column: {
	                stacking: 'normal',
	                dataLabels: {
	                    enabled: false,
	                }
	            }*/
	        },
	        series: [{!! $grafico['serie'] !!}]
		});

		@endforeach


	});
</script>