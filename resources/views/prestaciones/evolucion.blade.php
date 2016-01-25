@extends('content')
@section('content')
<div class="row">
	@foreach ($series->provincias as $provincia)
	<div class="col-md-4">
		<div class="box box-{{ $provincia->css }}">
			<div class="box-header">
				<h2 class="box-title">{{ $provincia->provincia }}</h2>
			</div>
			<div class="box-body">
				<div style="height:300px;" class="{{ $provincia->elem }}"></div>
			</div>
		</div>
	</div>
	@endforeach
</div>


<script type="text/javascript">
	$(document).ready(function(){

		@foreach ($series->provincias as $provincia)
			$('.{{$provincia->elem}}').highcharts({
				chart: {
					type: 'area'
				},
				legend: {
					enabled: false
				},
		        title: {
		            text: null
		        },
		        xAxis: {
		            categories: {!! $provincia->categorias !!}
		        },
		        yAxis: {
		        	labels: {
		        		enabled: true
		        	},
		            min: 0,
		            title: {
		                text: null
		            }
		        },
		        plotOptions: {
		            column: {
		                pointPadding: 0.2,
		                borderWidth: 0
		            }
		        },
		        series: {!! json_encode($provincia->series) !!}
		    });
		@endforeach

	});
</script>
@endsection