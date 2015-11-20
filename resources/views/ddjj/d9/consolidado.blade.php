@extends('content')
@section('content')

{{print_r($geo)}}

<div class="row">
	<div class="col-md-4">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Período : Ene 2015</h2>
			</div>
			<div class="box-body">
				<div class="map-ene"></div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Período : Ene 2015</h2>
			</div>
			<div class="box-body">
				<div class="map-ene"></div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Período : Ene 2015</h2>
			</div>
			<div class="box-body">
				<div class="map-ene"></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Período : Ene 2015</h2>
			</div>
			<div class="box-body">
				<div class="map-ene"></div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Período : Ene 2015</h2>
			</div>
			<div class="box-body">
				<div class="map-ene"></div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Período : Ene 2015</h2>
			</div>
			<div class="box-body">
				<div class="map-ene"></div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.map-ene').highcharts('Map', {
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
			series : [{
				data : {!!$geo!!},
				mapData: Highcharts.maps['countries/ar/ar-all'],
				joinBy: 'hc-key',
				name: 'Población',
				states: {
					hover: {
						color: '#BADA55'
					}
				},
				dataLabels: {
					enabled: false,
					format: '{point.name}'
				},/*
				point : {
					events : {
						click : InfoProvincia
					}
				},*/
				cursor : 'pointer'
			}]
		});
	});
</script>
@endsection