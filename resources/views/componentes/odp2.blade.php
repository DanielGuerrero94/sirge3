@extends('content')
@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="box box-warning">
			<div class="box-header">
				<h2 class="box-title">O.D.P 1.A y 1.B</h2>
			</div>
			<div class="box-body">
				<div class="g4"></div>
			</div>
		</div>
	</div>

	<div class="col-md-4">
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
				<h2 class="box-title">Resultados Provinciales</h2>
			</div>
			<div class="box-body">
				<div id="mapa-cei-0"></div>
			</div>
		</div>
	</div>

	<div class="col-md-8">
		<div class="box box-danger">
			<div class="box-header">
				<h2 class="box-title">Resultados Provincia</h2>
			</div>
			<div class="box-body">
				<div id="grafico-cei-0"></div>
				<div id="detalle-cei-0"></div>
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

	    // Make monochrome colors and set them as default for all pies
	    Highcharts.getOptions().plotOptions.pie.colors = (function () {
	        var colors = [],
	            base = Highcharts.getOptions().colors[0],
	            i;

	        for (i = 0; i < 10; i += 1) {
	            // Start out with a darkened base color (negative brighten), and end
	            // up with a much brighter color
	            colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());
	        }
	        return colors;
	    }());

		$('.g4').highcharts({
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: '{!! $barras["titulo"] !!}'
        },
        subtitle: {
            text: '{!! $barras["subtitulo"] !!}'
        },
        xAxis: [{
            categories: {!! $barras["categorias"] !!},
            crosshair: true
        }],
        yAxis: [{ // Primary yAxis
            labels: {
                format: '{value}°C',
                style: {
                    color: Highcharts.getOptions().colors[2]
                }
            },
            title: {
                text: 'Temperature',
                style: {
                    color: Highcharts.getOptions().colors[2]
                }
            },
            opposite: true

        }, { // Secondary yAxis
            gridLineWidth: 0,
            title: {
                text: 'Actuales',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            labels: {
                format: '{value} mm',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            }

        }, { // Tertiary yAxis
            gridLineWidth: 0,
            title: {
                text: 'Resultados en el periodo',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            labels: {
                format: '{value} mb',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            opposite: true
        }],
        tooltip: {
            shared: true
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            x: 80,
            verticalAlign: 'top',
            y: 55,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
        },
        series: [{
            name: 'Resultados actuales',
            type: 'column',
            yAxis: 1,
            data: {!! $barras["data"] !!},
            tooltip: {
                valueSuffix: ' mm'
            }

        }, {
            name: 'Meta 1.B (Hombres adultos)',
            type: 'spline',
            yAxis: 2,
            data: {!! $barras["meta_hombres"] !!},
            marker: {
                enabled: false
            },
            dashStyle: 'shortdot',
            tooltip: {
                valueSuffix: ' mb'
            }

        }, {
            name: 'Meta 1.A (Niños, adol. y mujeres adultas)',
            type: 'spline',
            data: {!! $barras["meta_naymujeres"] !!},
            tooltip: {
                valueSuffix: ' °C'
            }
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
	});
</script>
@endsection