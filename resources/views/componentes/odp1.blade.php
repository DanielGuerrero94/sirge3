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
				<div id="detalle-ceb"></div>
			</div>
		</div>
	</div>

</div>

<div class="row">
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
					
		$('.g3').highcharts({
            series: [{
                type: "treemap",
                layoutAlgorithm: 'squarified',
                allowDrillToNode: true,
                dataLabels: {
                    enabled: false
                },
                levelIsConstant: false,
                levels: [{
                    level: 1,
                    dataLabels: {
                        enabled: true
                    },
                    borderWidth: 3
                }],
                data : {!! $treemap_data !!},
                tooltip: {
                    pointFormatter : function(){
                        if (this.codigo_prestacion){
                            return this.texto_prestacion + ' : ' + Highcharts.numberFormat(this.value , '0');
                        } else {
                            return Highcharts.numberFormat(this.value , '0');
                        }
                    }
                },
                turboThreshold : 5000
            }],
            title : {
            	text : 'Distribución códigos'
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

	    $('.g6').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: null
            },
            xAxis: [{
                    categories: ['0-5' , '6-9' , '10-19' , '20-64'],
                    reversed: false,
                    labels: {
                        step: 1
                    },
                }, { // mirror axis on right side
                    opposite: true,
                    reversed: false,
                    categories: ['0-5' , '6-9' , '10-19' , '20-64'],
                    linkedTo: 0,
                    labels: {
                        step: 1
                    },
                }],
            yAxis: {
                title: {
                    text: null
                },
                labels: {
                	enabled : false,
                    formatter: function () {
                        return Math.abs(this.value) + '%';
                    }
                }
            },

            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },

            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + ', edad ' + this.point.category + '</b><br/>' +
                        'Prestaciones: ' + Highcharts.numberFormat(Math.abs(this.point.y), 0);
                }
            },

            series: {!! $distribucion_sexos !!}
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

		$.get('ceb-resumen/' + {{ $periodo_calculado }} + '/' + '{{ $provincia }}', function(data){
					$('#detalle-ceb').html(data);
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