@extends('content')
@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div id="operadores-container">
			<div class="box box-info">
				<div class="box-header">
					<h2 class="box-title">Operadores habilitados</h2>
					<p>Se muestran todos los operadores que pueden resolver requerimientos:</p>
                    <div class="box-tools pull-right">
                        <button class="new-operador btn btn-success">Nuevo operador <i class="fa fa-plus-circle"></i></button>
                    </div>
				</div>
				<div class="box-body">
					<table class="table table table-hover" id="operadores-table">
	                    <thead>
	                      <tr>
	                        <th>ID</th>
	                        <th>Nombre</th>
	                        <th>Grupo</th>
	                        <th></th>
	                      </tr>
	                    </thead>
	                </table>
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
		
		var dt = $('#operadores-table').DataTable({
            processing: true,
            serverSide: true,
            ajax : 'operadores-table',
            columns: [
            	{ data: 'id' , name: 'id'},
                { data: 'usuario.nombre', name: 'usuario.nombre' },
                { data: 'sector.descripcion', name: 'sector.descripcion' },
                { data: 'action' , name: 'action'}
            ],
            order : [
                [0 , 'asc']
            ]
        });

		$('#operadores-table').on('click' , '.enable-operador' , function(){
			var id = $(this).attr('id-operador');
			$.post('habilitar-operador' , 'id_operador=' + id , function(data){
				$('#modal-text').html(data);
				$('.modal').modal();
			});
		});

		$('#operadores-table').on('click' , '.disable-operador' , function(){
			var id = $(this).attr('id-operador');
			$.post('deshabilitar-operador' , 'id_operador=' + id , function(data){
				$('#modal-text').html(data);
				$('.modal').modal();
				$('.modal').on('hidden.bs.modal', function (e) {
		            dt.ajax.reload( null, false );
		        });
			});
		});

		$('.new-operador').click(function(){
			$.get('new-operador' , function(data){
				$('#operadores-container').html(data);
			})
		})


	});
</script>
@endsection