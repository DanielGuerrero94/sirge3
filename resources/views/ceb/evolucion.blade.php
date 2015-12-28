@extends('content')
@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">CENTRO</h2>
			</div>
			<div class="box-body">
				<div class="region1"></div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">NEA</h2>
			</div>
			<div class="box-body">
				<div class="region2"></div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">NOA</h2>
			</div>
			<div class="box-body">
				<div class="region3"></div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">CUYO</h2>
			</div>
			<div class="box-body">
				<div class="region4"></div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">PATAGONIA</h2>
			</div>
			<div class="box-body">
				<div class="region5"></div>
			</div>
		</div>
	</div>
	
</div>
<script type="text/javascript">
	$(document).ready(function(){
		@foreach ($series->regiones as $region)
			$('.{{$region->elem}}').highcharts({
		        chart: {
		            type: 'column'
		        },
		        title: {
		            text: null
		        },
		        xAxis: {
		            categories: {!! json_encode($region->provincias) !!},
		            crosshair: true
		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: 'Beneficiarios'
		            }
		        },
		        tooltip: {
		            shared: true,
		            useHTML: true
		        },
		        plotOptions: {
		            column: {
		                pointPadding: 0.2,
		                borderWidth: 0
		            }
		        },
		        series: {!! json_encode($region->series) !!}
		    });
		@endforeach

	});
</script>
@endsection