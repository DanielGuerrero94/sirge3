@extends('content')
@section('content')
<div class="row">
	<div class="col-md-7">
		<div class="box box-warning">
			<div class="box-header">
				<h2 class="box-title">O.D.P - {{ $odp }}</h2>
			</div>
			<div class="box-body">
				<div class="g4"></div>
			</div>
		</div>
	</div>

	<div class="col-md-5">
		<div class="box box-danger">
			<div class="box-header">
				<h2 class="box-title">Resultados</h2>
			</div>
			<div class="box-body">				
				<div id="detalle-ca"></div>
			</div>
		</div>
	</div>
	
</div>

<div class="row">

	<div class="col-md-6">
		<div class="box box-danger">
			<div class="box-header">
				<h2 class="box-title">Provincias</h2>
				<div class="btn-group pull-right">
					<button type="button" href="componentes/{{ $odp }}" class="ver-pais btn btn-default">Ver pais</button>
				</div>
			</div>
			<div class="box-body">
				<div id="mapa-ceb"></div>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="box box-danger">
			<div class="box-header">
				<h2 class="box-title">Descripcion O.D.P {{ $odp }}</h2>
			</div>
			<div class="box-body">				
				<div id="detalle-indicador">{!! $odp_descripcion !!}</div>
			</div>
		</div>
	</div>	

</div>

<style>
.g4 text{font-size:13px !important;}
.g5 text{font-size:13px !important;}
.g4 text.highcharts-title{font-size:18px !important;}
.g5 text.highcharts-title{font-size:18px !important;}
</style>

<script type="text/javascript">
	$(document).ready(function(){

		$(Highcharts.charts).each(function(i, chart){    
	        if (chart) {
	            chart.destroy();
	        }
    	});					

	    $('.g4').highcharts({

	        chart: {
	            plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false,
	            type: 'pie'
	        },
	        title: {
	            text: '{!! $pie_cp["titulo"] !!}'
	        },
	        tooltip: {
	            pointFormat: 'Cantidad: <b>{point.y}</b> : {point.percentage:.1f} %'
	        },
	        plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                dataLabels: {
	                    enabled: true,
	                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
	                    style: {
	                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
	                    },
                    	connectorColor: 'silver'
	                }
	            }
	        },
	        series: [{
	        	name: 'Grupos',	        	
	        	data: {!! $pie_cp['data'] !!}
	        	
	        }]
	    });	   

		$("#mapa-ceb").highcharts('Map', {
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
							var provincia = e.point.provincia;				    	
					    	$.get('componentes/{{ $odp }}/' + provincia, function(data){
								$('.content-wrapper').html(data);
							});
						}
					}
				}
			},
			series : [{
				data : {!! $map['map-data'] !!},
				mapData: Highcharts.maps['countries/ar/ar-all'],
				joinBy: 'hc-key',
				name: 'C.P.',
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

		$.get('odp-resumen/' + {{ $odp }} +'/'+ {{ $periodo_calculado }} + '/' + '{{ $provincia }}', function(data){
					$('#detalle-ca').html(data);
		});		

    	$('[data-toggle="tooltip"]').tooltip(); 

    	$('.ver-pais').on('click', function(event) {
    		event.preventDefault();
		 	var redireccion = $(this).attr('href');
		        $.get(redireccion, function(data){
					$('.content-wrapper').html(data);
				});						
    	});  		
	});
</script>
@endsection