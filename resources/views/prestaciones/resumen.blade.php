@extends('content')
@section('content')
<div class="row">
	<div class="col-md-4">
		<div class="box box-warning">
			<div class="box-header">
				<h2 class="box-title">Progresión</h2>
			</div>
			<div class="box-body">
				<div class="g1"></div>
			</div>
		</div>
	</div>

	<div class="col-md-8">
		<div class="box box-warning">
			<div class="box-header">
				<h2 class="box-title">Distribución</h2>
			</div>
			<div class="box-body">
				<div class="g2"></div>
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
				<h2 class="box-title">Prestaciones por grupo etario</h2>
			</div>
			<div class="box-body">
				<div class="g4"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="box box-warning">
			<div class="box-header">
				<h2 class="box-title">Prestaciones por sexo</h2>
			</div>
			<div class="box-body">
				<div class="g5"></div>
			</div>
		</div>
	</div>

	<div class="col-md-8">
		<div class="box box-warning">
			<div class="box-header">
				<h2 class="box-title">Información</h2>
			</div>
			<div class="box-body">
				<table class="table table-hover" id="tabla">
					<thead>
						<tr>
							<th>Provincia</th>
							<th>Código</th>
							<th>Grupo</th>
							<th>Cantidad</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){

		$('#tabla').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax : 'prestaciones-resumen-table/{{$periodo}}',
	        columns: [
	            { data: 'id_provincia', name: 'id_provincia' },
	            { data: 'codigo_prestacion', name: 'codigo_prestacion' },
	            { data: 'grupo_etario', name: 'grupo_etario' },
	            { data: 'cantidad' }
	        ]
	    });
		
		$('.g1').highcharts({
			title: {
	            text: '',
	        },
	        xAxis: {
	            categories: {!! $progreso_prestaciones_categorias !!}
	        },
	        yAxis: {
	            title: {
	                text: ''
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }],
	            labels : {
	            	enabled : false
	            }
	        },
	        legend: {
	            layout: 'horizontal',
	            align: 'center',
	            verticalAlign: 'bottom',
	            borderWidth: 0
	        },
	        series: {!! $progreso_prestaciones_series !!}
		});

	 	$('.g2').highcharts({
	        chart: {
	            type: 'column'
	        },
	        title: {
	            text: null
	        },
	        xAxis: {
	            categories: {!! $distribucion_provincial_categorias !!}
	        },
	        yAxis: {
	            min: 0,
	            title: null,
	            labels: {
	            	enabled: false
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
	        series: {!! $distribucion_provincial_series !!}
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
            	text : 'Distribución facturación'
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
	            plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false,
	            type: 'pie'
	        },
	        title: {
	            text: null
	        },
	        tooltip: {
	            pointFormat: 'Prestaciones: <b>{point.y}</b> : {point.percentage:.1f} %'
	        },
	        plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                dataLabels: {
	                    enabled: false,
	                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
	                    style: {
	                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
	                    }
	                }
	            }
	        },
	        series: [{
	        	name: 'Grupos',
	        	colorByPoint: true,
	        	data: {!! $pie_grupos_etarios !!}
	        	
	        }]
	    });

	    $('.g5').highcharts({
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
                        'Prestaciones: ' + Highcharts.numberFormat(Math.abs(this.point.y) * 1000, 0);
                }
            },

            series: {!! $distribucion_sexos !!}
        });


	});
</script>
@endsection