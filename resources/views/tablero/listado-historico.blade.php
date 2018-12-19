@extends('content')
@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Listado completo de indicadores</h2>
					<div class="box-tools pull-right">
                        <div data-toggle="descargar-tooltip" data-placement="bottom" style="display:inline-block;">
                            <a class="descargar-historico btn btn-warning" href="listado-historico-descargar/{{$periodo_desde}}/{{$periodo_hasta}}/{{$provincia}}/{{$indicador}}"><i class="fa fa-download"></i> Descargar</a>
                        </div>
                    </div>
			<div class="box-body" style="margin-top: 10px">
				<table class="table table-hover" id="tablero-historico-table">
				    <thead>
				        <tr>
				            <th>Periodo</th>
				            <th>Provincia</th>
				            <th>Indicador</th>
				            <th>Numerador (A)</th>
				            <th>Denominador (B)</th>
				            <th>Estado</th>
				        </tr>
				    </thead>
				</table>
			</div>
            <div class="box-footer">
                    <div class="btn-group" role="group">
                        <button type="button" class="back btn btn-primary">Atrás</button>
                    </div>
                </div>
		</div>
	</div>
</div>
</div>
<div class="modal modal-warning">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Atención!</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<style type="text/css">
    .moveright { text-align: right; margin-right: 10px; }
    .movecenter { text-align: center; }
</style>
<script>
$(function() {

	var table;

    console.log('{{url("/tablero-listado-historico-table")}}/'+ '{{$periodo_desde}}' + '/' + '{{$periodo_hasta}}' + '/' + '{{$provincia}}' + '/' + '{{$indicador}}');

    table = $('#tablero-historico-table').DataTable({
        type: 'get',
        processing: true,
        serverSide: true,
        sortable: true,
        pageLength: 18,
        dataType: 'json',
        ajax : {
                url: '{{url("/tablero-listado-historico-table")}}/' + '{{$periodo_desde}}' + '/' + '{{$periodo_hasta}}' + '/' + '{{$provincia}}' + '/' + '{{$indicador}}'
        },
        columns: [
            { data: 'periodo'},
            { data: 'provincias.descripcion'},
            { data: 'indicador_real',"sClass": "movecenter" },
            { data: 'numerador_format',"sClass": "moveright" },
            { data: 'denominador_format',"sClass": "moveright"},
            { data: 'estado',"sClass": "movecenter" }
        ]
    });

    $('.back').click(function(){
        $.get('tablero-filtros-historico/' + '{{$periodo_desde}}' + '/' + '{{$periodo_hasta}}' + '/' + '{{$provincia}}' + '/' + '{{$indicador}}' , function(data){
            $('.content-wrapper').html(data);
        });
    });
});
</script>
@endsection

