@extends('content')
@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Volumen de descentralización de los efectores</h2>
			</div>
			<div class="box-body">
				<div class="g1"></div>
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

		$('.back').click(function(){
			$.get('{{$back}}' , function(data){
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