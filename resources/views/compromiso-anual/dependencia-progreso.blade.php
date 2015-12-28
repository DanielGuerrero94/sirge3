@extends('content')
@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Dependencias Sanitarias</h2>
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
			title: {
	            text: 'Evolución dependencias sanitarias',
	        },
	        xAxis: {
	            categories: {!! $categorias !!}
	        },
	        yAxis: {
	            title: {
	                text: ''
	            },
	            plotLines: [{
	                value: {{$metas->primer_cuatrimestre}},
	                width: 2,
	                dashStyle: 'shortdash',
	                color: '#00a65a',
	                label: {
                        text: 'Meta 1º cuatrimestre'
                    }
	            },
	            {
	                value: {{$metas->segundo_cuatrimestre}},
	                width: 2,
	                dashStyle: 'shortdash',
	                color: '#ff851b',
	                label: {
                        text: 'Meta 2º cuatrimestre'
                    }
	            },
	            {
	                value: {{$metas->tercer_cuatrimestre}},
	                width: 2,
	                dashStyle: 'shortdash',
	                color: '#d33724',
	                label: {
                        text: 'Meta 3º cuatrimestre'
                    }
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