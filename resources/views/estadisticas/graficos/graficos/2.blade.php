@extends('content')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Distribución de facturación C.E.B. - TOP 15</h2>
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

    $.get('grafico-2/{{ $periodo }}' , function(data){
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
            subtitle: {
                text: 'Fuente: SIRGe Web.'
            },
            title : {
            	text : 'Facturación CEB'
            }
        });
    });
</script>
@endsection