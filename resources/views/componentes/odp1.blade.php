@extends('content')
@section('content')
<div class="row">
	<div class="col-md-5">
		<div class="box box-warning">
			<div class="box-header">
				<h2 class="box-title">O.D.P - 1.A</h2>
			</div>
			<div class="box-body">
				<div class="g4"></div>
			</div>
		</div>
	</div>

	<div class="col-md-5">
		<div class="box box-warning">
			<div class="box-header">
				<h2 class="box-title">O.D.P - 1.B (Hombres)</h2>
			</div>
			<div class="box-body">
				<div class="g5"></div>
			</div>
		</div>
	</div>

	<div class="col-md-2">
		<div class="row">
			<div class="col-md-12">
				<div class="callout callout-warning">
					<h4>Importante!</h4>
					<p>Los gráficos de la izquierda corresponden a los resultados del O.D.P 1 calculada en el período {{$periodo_calculado}}</p>
				</div>
			</div>			
			<div class="col-md-12">
				<div class="box box-warning">
					<div class="box-header">
						<h2 class="box-title">Progresión nacional</h2>
					</div>
					<div class="box-body">
						<p>Desde esta opción podrá ver la evolución del O.D.P a nivel nacional</p>
					</div>
					<div class="box-footer">
						<div class="btn-group" role="group">
							<button type="button" href="ca-provincia-form/ca-16-descentralizacion/ca-16-descentralizacion-progresion" class="detalle btn btn-info">Ver detalles</button>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</div>
</div>

<div class="row">

	<div class="col-md-4">
		<div class="box box-danger">
			<div class="box-header">
				<h2 class="box-title">Provincias</h2>
			</div>
			<div class="box-body">
				<div id="mapa-ceb"></div>
			</div>
		</div>
	</div>

	<div class="col-md-8">
		<div class="box box-danger">
			<div class="box-header">
				<h2 class="box-title">Resultados</h2>
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

<script type="text/javascript">
	$(document).ready(function(){
					
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

	    // Radialize the colors
	    Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
	        return {
	            radialGradient: {
	                cx: 0.5,
	                cy: 0.3,
	                r: 0.7
	            },
	            stops: [
	                [0, color],
	                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
	            ]
	        };
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

							$("#grafico-ceb").hide();
							$("#detalle-ceb").load('ceb-resumen/' + periodo  + '/' + provincia);
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

		$.get('ceb-resumen', function(data){
				$('#detalle-ceb').html(data);
		});			
		
	});
</script>
@endsection