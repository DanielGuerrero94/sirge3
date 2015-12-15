@extends('content')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Progresión histórica de reporte</h2>
			</div>
			<div class="box-body">
				<div class="g1"></div>
			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button class="back btn btn-info">Atrás</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){

		$('.back').click(function(){
			$.get('padron-consolidado' , function(data){
				$('.content-wrapper').html(data);
			})
		})

		$('.g1').highcharts({
			title: {
	            text: 'Evolución facturación',
	        },
	        xAxis: {
	            categories: {!! $categorias !!}
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
	            	enabled : true
	            },
	            min : 0
	        },
	        legend: {
	            layout: 'horizontal',
	            align: 'center',
	            verticalAlign: 'bottom',
	            borderWidth: 0
	        },
	        series: {!! $series !!}
		});
	});
</script>
@endsection