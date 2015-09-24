@extends('content')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Tasa de ARIS+ Global 2012, por 100 000 habitantes</h2>
			</div>
			<div class="box-body">
				<div id="container"></div>
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
	$('.back').click(function(){
		$.get('estadisticas-graficos' , function(data){
			$('.content-wrapper').html(data);
		});
	});

    $.get('grafico-2' , function(data){
        $('#container').highcharts({
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
                data : data,
                tooltip: {
                    pointFormat: "{point.value}"
                },
                turboThreshold : 5000
            }],
            subtitle: {
                text: 'Fuente: <a href="http://apps.who.int/gho/data/node.main.12?lang=en">OMS</a>.'
            },
            title : {
            	text : 'Facturación CEB'
            }
        });
    });
</script>
@endsection