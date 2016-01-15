<script type="text/javascript">
	$(document).ready(function(){

		$('.g1').highcharts({
			title: {
				text: 'Evolución indicador {{$unIndicador->codigo_indicador}}',
			},
			xAxis: {
				// ULTIMOS 6 MESES
				categories: ['mes1','mes2','mes3','mes4','mes5','mes seleccionado']
			},
			yAxis: {
				title: {
					text: ''
				},
				plotLines: [
					{
						value: 5,
						width: 2,
						dashStyle: 'shortdash',
						color: '#d33724'
					},
					{
						value: 15,
						width: 2,
						dashStyle: 'shortdash',
						color: '#ff851b'
					},
					{
						value: 21,
						width: 2,
						dashStyle: 'shortdash',
						color: '#00a65a'
					}
				],
				labels : {
					enabled : false
				},
				min : 0
			},
			legend: {
				enabled: false
			},
			series: [{
				name : 'lalala',
				data : [1.3,3.4,5.6,6.7,7.8,25]
			}]
		});

		$('.g2').highcharts({
			title: {
				text: 'Evolución indicador x.x',
			},
			xAxis: {
				// ULTIMOS 6 MESES
				categories: ['mes1','mes2','mes3','mes4','mes5','mes seleccionado']
			},
			yAxis: {
				title: {
					text: ''
				},
				plotLines: [
					{
						value: 5,
						width: 2,
						dashStyle: 'shortdash',
						color: '#d33724'
					},
					{
						value: 15,
						width: 2,
						dashStyle: 'shortdash',
						color: '#ff851b'
					},
					{
						value: 21,
						width: 2,
						dashStyle: 'shortdash',
						color: '#00a65a'
					}
				],
				labels : {
					enabled : false
				},
				min : 0
			},
			legend: {
				enabled: false
			},
			series: [{
				name : 'lalala',
				data : [0,0,1.1,1.2,1.3,1.4]
			}]
		});

	});
</script>