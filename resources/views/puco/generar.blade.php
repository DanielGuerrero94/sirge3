@extends('content')
@section('content')
<div class="row">
	<div class="col-md-5">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Estadísticas</h2>
			</div>
			<div class="box-body">
				<table class="table table-hover" id="estadisticas-puco-table">
	                <thead>
	                  <tr>
	                    <th>Período</th>
	                    <th>Beneficiarios</th>
	                    <th>Clave</th>
	                  </tr>
	                </thead>
	            </table>
			</div>
		</div>
	</div>
	<div class="col-md-7">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Beneficiarios</h2>
				<div class="box-tools pull-right">
					@if ($puco_ready == 31)
					<button class="generar-puco btn btn-warning"><i class="fa fa-flag"></i> Generar PUCO</button>
					@endif
				</div>
			</div>
			<div class="box-body">
				<table class="table table-hover" id="resumen-puco-table">
	                <thead>
	                  <tr>
	                    <th>Lote</th>
	                    <th>Nombre</th>
	                    <th>Beneficiarios</th>
	                  </tr>
	                </thead>
	            </table>
			</div>
		</div>
	</div>
</div>
<div class="modal fade modal-info">
	<div class="modal-dialog">
		<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    			<h4 class="modal-title">Atención!</h4>
      		</div>
  			<div class="modal-body">
  				<p id="modal-text"></p>
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
      		</div>
    	</div>
  	</div>
</div>
<div class="row">

	@foreach($meses as $mes)
	
	<div class="col-md-5">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Período : {{ $mes['periodo'] }}</h2>
			</div>
			<div class="box-body">
				<div class="{{ $mes['class'] }}"></div>
			</div>
		</div>
	</div>

	@endforeach
	
</div>

<script type="text/javascript">

$(document).ready(function(){

	var dt1 = $('#estadisticas-puco-table').DataTable({
		processing: true,
        serverSide: true,
        ajax : 'puco-estadisticas-table',
        columns: [
            { data: 'periodo' , name: 'periodo'},
            { data: 'registros' , name: 'registros'},
            { data: 'clave'}
            
        ],
        order : [[0,'desc']]
	});

	var dt = $('#resumen-puco-table').DataTable({
		processing: true,
        serverSide: true,
        ajax : 'puco-resumen-table',
        columns: [
            { data: 'lote' , name: 'periodo'},
            { data: 'nombre' , name: 'nombre'},
            { data: 'registros_in'}
            
        ],
        order : [[0,'desc']]
	});

	$('.generar-puco').click(function(){
		$.post('puco-generar-archivo' , function(data){
			$('#modal-text').html('Se ha generado el PUCO. Recibirá un mail con la contraseña');
            $('.modal').modal();
            $('.modal').one('hidden.bs.modal', function (e) {
                dt1.ajax.reload( null, false );
            });
		});
	});

	@foreach($meses as $mes)

	$('.{{$mes['class']}}').highcharts('Map', {
			title : {
				text : ''
			},
			mapNavigation: {
				enabled: false,
				buttonOptions: {
					verticalAlign: 'bottom'
				}
			},
			colorAxis: {
				min: 0
			},
			legend : {
				enabled : false
			},
			series : [{
				data : {!!$mes['data']!!},
				mapData: Highcharts.maps['countries/ar/ar-all'],
				joinBy: 'hc-key',
				name: 'OSP',
				states: {
					hover: {
						color: '#BADA55'
					}
				},
				dataLabels: {
					enabled: false,
					format: '{point.properties.postal}'
				},
				tooltip : {
					pointFormatter: function(){
						if (this.value){
							return this.name + ' : REPORTADO';
						} else {
							return this.name + ' : PENDIENTE';
						}
					} 
				},
				cursor : 'pointer'
			}]
	});

	@endforeach

});

</script>
@endsection
