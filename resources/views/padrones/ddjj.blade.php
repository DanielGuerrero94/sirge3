@extends('content')
@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Declaración de lotes pendientes</h2>
				<div class="box-tools pull-right">
				@if ($pendientes)
					<button class="declarar-lotes btn btn-warning"><i class="fa fa-flag"></i> Declarar</button>
				@endif
				</div>
			</div>
			<div class="box-body">
				<div class="alert alert-danger" id="errores-div">
					<ul id="errores-form">
					</ul>
				</div>
				<table class="table table-hover" id="lotes-table">
	                <thead>
	                  <tr>
	                    <th>Lote</th>
	                    <th>Fecha cierre</th>
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
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){

		$('#errores-div').hide();	

		$('.back').click(function(){
			$.get('padron/{{ $padron }}' , function(data){
				$('.content-wrapper').html(data);
			})
		});

		var dt = $('#lotes-table').DataTable({
			processing: true,
            serverSide: true,
            ajax : 'listado-lotes-cerrados-table/{{ $padron }}',
            columns: [
                { data: 'lote' , name : 'lote'},
                { data: 'fecha_format' , name: 'fecha_format'}
                
            ],
            order : [[0,'desc']]
		});

		$('.declarar-lotes').click(function(){
			$.post('declarar-lotes' , 'padron={{ $padron }}'  , function(data){
				$('#modal-text').html(data);
                $('.modal').modal();
                $('.modal').on('hidden.bs.modal', function (e) {
                    dt.ajax.reload( null, false );
                    //$('.declarar-lotes').attr('disabled' , 'disabled');
                });
			});
		});

	});
</script>
@endsection