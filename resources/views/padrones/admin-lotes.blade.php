@extends('content')
@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Administración de Lotes</h2>
			</div>
			<div class="box-body">
				<div class="alert alert-danger" id="errores-div">
					<ul id="errores-form">
					</ul>
				</div>
				<table class="table table table-hover" id="lotes-table">
	                <thead>
	                  <tr>
	                    <th>Lote</th>
	                    <th>Registros IN</th>
	                    <th>Registros OUT</th>
	                    <th>Registros MOD</th>
	                    <th>Estado</th>
	                    <th></th>
	                  </tr>
	                </thead>
	            </table>
			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button class="back btn btn-info">Atrás</button>
				</div>			
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
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
	$(document).ready(function(){

		$('#errores-div').hide();

		$('.back').click(function(){
			$.get('padron/{{ $id_padron }}' , function(data){
				$('.content-wrapper').html(data);
			})
		});

		var dt = $('#lotes-table').DataTable({
			processing: true,
            serverSide: true,
            ajax : 'listar-lotes-table/{{ $id_padron }}',
            columns: [
                { data: 'lote', name: 'lote' },
                { data: 'registros_in'},
                { data: 'registros_out'},
                { data: 'registros_mod'},
                { data: 'estado_css' , name: 'estado_css'},
                { data: 'action' }
            ],
            order : [[0,'desc']]
		});



	});
</script>
@endsection('content')