@extends('content')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header"> 
				<h2 class="box-title with-border">Detalle linea de cuidado</h2>
			</div>
			<div class="box-body">

				<div class="col-md-5">
					<div class="box box-warning">
						<div class="box-header">
							<h2 class="box-title">Listado de códigos pertenecientes</h2>
						</div>
						<div class="box-body">
							<table class="table table-hover" id="pss-table">
				                <thead>
				                  <tr>
				                    <th>Código</th>
				                    <th>Grupo Etario</th>
				                  </tr>
				                </thead>
				            </table>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="row">
						<div class="col-md-12">
							<div class="g1" style="height: 300px;"></div>
						</div>
						<div class="col-md-12">
							<div class="g2" style="height: 300px;"></div>
						</div>
					</div>
				</div>
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

		$('#pss-table').DataTable({
            processing: true,
            serverSide: true,
            ajax : 'pss-lineas-codigos-table/' + {{$linea->id_linea_cuidado}},
            columns: [
                { data: 'codigo_prestacion'},
                { data: 'grupo_etario.descripcion'}
            ]
        });

        $('.g1').highcharts({
			title: {
	            text: 'Evolución facturación',
	        },
	        xAxis: {
	            categories: {!! $meses !!}
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

		$('.g2').highcharts({
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
                data : {!! $tree_map !!},
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
            	text : 'Distribución facturación'
            }
        });

	});
</script>
@endsection