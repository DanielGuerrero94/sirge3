@extends('content')
@section('content')
<div class="row">
	<div class="col-md-4">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Progresión CEB</h2>
			</div>
			<div class="box-body">
				<div class="g1"></div>
			</div>
		</div>
	</div>

	<div class="col-md-8">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Progresión CEB</h2>
			</div>
			<div class="box-body">
				<div class="g2"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-8">
		<div class="g3"></div>
	</div>

	<div class="col-md-4">
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		
		$('.g1').highcharts({
			title: {
	            text: '',
	        },
	        xAxis: {
	            categories: {!! $progreso_ceb_categorias !!}
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
	        series: {!! $progreso_ceb_series !!}
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
	                enabled: true,
	                formatter: function(){
	                	return (this.total/1000) + 'k';
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
	            column: {
	                stacking: 'normal',
	                dataLabels: {
	                    enabled: false,
	                }
	            }
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
            	text : 'Facturación CEB'
            }
        });

	
	});
</script>
@endsection