@extends('content')
@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="box box-warning">
			<div class="box-header">
				<h2 class="box-title">O.D.P - 1.A</h2>
			</div>
			<div class="box-body">
				<div class="g4"></div>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="box box-warning">
			<div class="box-header">
				<h2 class="box-title">O.D.P - 1.B (Hombres)</h2>
			</div>
			<div class="box-body">
				<div class="g5"></div>
			</div>
		</div>
	</div>	
</div>

<div class="row">

	<div class="col-md-4">
		<div class="box box-danger">
			<div class="box-header">
				<h2 class="box-title">Provincias</h2>
				<div class="btn-group pull-right">
					<button type="button" href="componentes-ceb" class="ver-pais btn btn-default">Ver pais</button>
				</div>
			</div>
			<div class="box-body">
				<div id="mapa-ceb"></div>
			</div>
		</div>
	</div>

	<div class="col-md-8">
		<div class="box box-danger">
			<div class="box-header">
				<h2 class="box-title">Resultados {{ ucfirst(strtolower($provincia_descripcion)) }}</h2>
			</div>
			<div class="box-body">				
				<div id="detalle-ceb">
					<div class="row">					

						<div class="col-md-6">
							<form class="form-horizontal">		
								<div class="form-group">
									<div class="col-md-1">
									</div>
									<div class="col-md-10">
										<h4 class="form-control-static">Ceb mujeres, adolescentes y niños</h4>				
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-7 control-label">Entidad</label>
									<div class="col-md-5">
										<p class="form-control-static">Pa&iacute;s</p>
									</div>
								</div>								

								<div class="form-group">
									<label class="col-md-7 control-label">% Observado Actual</label>
									<div class="col-md-5">
										<p class="form-control-static">34.2</p>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-7 control-label">% Meta Anual</label>
									<div class="col-md-5">
										<p class="form-control-static">45</p>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-7 control-label">Planificado Abril 2016</label>
									<div class="col-md-5">
										<p class="form-control-static">38</p>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-7 control-label">Planificado Agosto 2016</label>
									<div class="col-md-5">
										<p class="form-control-static">44</p>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-7 control-label">Estado a&ntilde;o anterior</label>
									<div class="btn-group col-md-5" data-toggle="tooltip" title="Desde esta opción podrá ver el estado del último año del O.D.P 1.A a nivel nacional y regional" role="group">
										<button type="button" href="componentes-odp1-evolucion/A" class="detalle btn btn-info">Ver detalles</button>
									</div>		
								</div>
							</form>
						</div>

						<div class="col-md-6">
							<form class="form-horizontal">		
								<div class="form-group">
									<div class="col-md-1">
									</div>
									<div class="col-md-10">
										<h4 class="form-control-static">Ceb hombres adultos</h4>				
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-7 control-label">Entidad</label>
									<div class="col-md-5">
										<p class="form-control-static">Pa&iacute;s</p>
									</div>
								</div>								

								<div class="form-group">
									<label class="col-md-7 control-label">% Observado Actual</label>
									<div class="col-md-5">
										<p class="form-control-static">11.3</p>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-7 control-label">% Meta Anual</label>
									<div class="col-md-5">
										<p class="form-control-static">7</p>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-7 control-label">Planificado Abril 2016</label>
									<div class="col-md-5">
										<p class="form-control-static">5</p>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-7 control-label">Planificado Agosto 2016</label>
									<div class="col-md-5">
										<p class="form-control-static">7</p>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-7 control-label">Estado a&ntilde;o anterior</label>
									<div class="btn-group col-md-5" data-toggle="tooltip" title="Desde esta opción podrá ver el estado del último año del O.D.P 1.B a nivel nacional y regional" role="group">
										<button type="button" href="componentes-odp1-evolucion/B" class="detalle btn btn-info">Ver detalles</button>
									</div>		
								</div>
							</form>
						</div>						

					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<!-- <div class="row">
	<div class="col-md-8">
		<div class="box box-warning">
			<div class="box-header">
				<h2 class="box-title">Facturación</h2>
			</div>
			<div class="box-body">
				<div class="g3"></div>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="box box-warning">
			<div class="box-header">
				<h2 class="box-title">Prestaciones por sexo</h2>
			</div>
			<div class="box-body">
				<div class="g6"></div>
			</div>
		</div>
	</div>
</div> -->

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
							

		$('.g5').highcharts({

	        chart: {
	            plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false,
	            type: 'pie'
	        },
	        title: {
	            text: '{!! $pie_ceb_hombres["titulo"] !!}'	            
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
	                    }
	                }
	            }
	        },
	        series: [{
	        	name: 'Grupos',	        	
	        	data: {!! $pie_ceb_hombres['data'] !!}	        	
	        }]
	    });

	    $('.g4').highcharts({

	        chart: {
	            plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false,
	            type: 'pie'
	        },
	        title: {
	            text: '{!! $pie_ceb["titulo"] !!}'
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
	        	data: {!! $pie_ceb['data'] !!}
	        	
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
							var periodo = e.point.periodo;
							var provincia = e.point.provincia;														
				    	
					    	$.get('componentes-ceb/' + periodo + '/' + provincia, function(data){
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
				name: 'C.E.B.',
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

		/*$.get('ceb-resumen/' + {{ $periodo_calculado }} + '/' + '{{ $provincia }}', function(data){
					$('#detalle-ceb').html(data);
		});*/

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