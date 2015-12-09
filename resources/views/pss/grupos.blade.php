@extends('content')
@section('content')
<div class="row">
	<div class="col-md-5">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Listado de grupos etarios del P.S.S.</h2>
			</div>
			<div class="box-body">
				<table class="table table-hover" id="pss-table">
	                <thead>
	                  <tr>
	                    <th>Sigla</th>
	                    <th>Descripción</th>
	                    <th></th>
	                  </tr>
	                </thead>
	            </table>
			</div>
		</div>
	</div>
	<div class="col-md-7">
		<div class="box box-info">
			<div class="box-body">
				<div style="height: 900px;" class="g1"></div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){

		$('#pss-table').DataTable({
            processing: true,
            serverSide: true,
            ajax : 'pss-grupos-table',
            columns: [
                { data: 'sigla'},
                { data: 'descripcion'},
                { data: 'action'}
            ]
        });

        $('#pss-table').on('click' , '.ver' , function(){
        	var id = $(this).attr('grupo');
        	$.get('pss-grupos-detalle/' + id , function(data){
        		$('.content-wrapper').html(data);
        	})
        });


    
    $(document).ready(function () {
        $('.g1').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Facturación por edad y sexo'
            },
            subtitle : {
                text: 'Últimos 12 meses'
            },
            xAxis: [{
                    categories: [{!! $edades !!}],
                    reversed: false,
                    labels: {
                        step: 1
                    },
                }, { // mirror axis on right side
                    opposite: true,
                    reversed: false,
                    categories: [{!! $edades !!}],
                    linkedTo: 0,
                    labels: {
                        step: 1
                    },
                }],
            yAxis: {
                title: {
                    text: null
                },
                labels: {
                    formatter: function () {
                        return Math.abs(this.value) + '%';
                    }
                }
            },

            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },

            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + ', edad ' + this.point.category + '</b><br/>' +
                        'Prestaciones: ' + Highcharts.numberFormat(Math.abs(this.point.y) * 1000, 0);
                }
            },

            series: {!! $series !!}
        });
    });

	})
</script>
@endsection