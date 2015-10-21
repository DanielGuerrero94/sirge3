@extends('content')
@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Archivos subidos</h2>
			</div>
			<div class="box-body">
				<div class="alert alert-danger" id="errores-div">
					<ul id="errores-form">
					</ul>
				</div>
				<table class="table table table-hover" id="archivos-table">
	                <thead>
	                  <tr>
	                    <th>Nombre</th>
	                    <th>Tamaño</th>
	                    <th>Fecha subida</th>
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

		var dt = $('#archivos-table').DataTable({
			processing: true,
            serverSide: true,
            ajax : 'listar-archivos-table/{{ $id_padron }}',
            columns: [
                { data: 'nombre_original', name: 'nombre_original' },
                { data: 'size', name: 'size' },
                { data: 'fecha_subida', name: 'fecha_subida' },
                { data: 'action'}
            ]
		});

		$('#archivos-table').on('click' , '.eliminar' , function(){
			var id = $(this).attr('id-subida');
			$.get('eliminar-padron/' + id , function(data){
				$('#modal-text').html(data);
                $('.modal').modal();
                $('.modal').on('hidden.bs.modal', function (e) {
                    dt.ajax.reload( null, false );
                });
			});
		});

		$('#archivos-table').on('click' , '.procesar' , function(){
			$('#errores-div').hide();
			var id = $(this).attr('id-subida');
			$.ajax({
				url : '{{ $ruta_procesar }}/' + id,
				success : function(data){
					var info = '';
					$.each(data , function (index , value){
						info += 'REGISTROS ' + index.toUpperCase() + ' : ' + value + '<br />';
					});
					$('#modal-text').html(info);
	                $('.modal').modal();
	                $('.modal').on('hidden.bs.modal', function (e) {
	                    dt.ajax.reload( null, false );
	                });
				},
				error : function(data){
					$('#errores-form').html('<li>No se pudo abrir el archivo</li>');
					$('#errores-div').show();
				}
			});
		});

	});
</script>
@endsection