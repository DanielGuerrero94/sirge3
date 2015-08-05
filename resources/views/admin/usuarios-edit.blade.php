<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="box box-info">
			<div class="box-header">
				<h2>{{ $usuario->nombre }}</h2>
			</div>
			<div class="box-body">
				<form id="form-edit-user">
					{!! csrf_field() !!}
					<!-- NOMBRE -->
					<div class="form-group">
						<label for="nombre">Nombre</label>
						<input type="text" id="nombre" name="nombre" class="form-control" value="{{ $usuario->nombre }}">
					</div>
					<!-- EMAIL -->
					<div class="form-group">
						<label for="email">Email</label>
						<input type="text" id="email" name="email" class="form-control" value="{{ $usuario->email }}">
					</div>
					<!-- PROVINCIA -->
					<div class="form-group">
						<label for="provincia">Provincia</label>
						@include('common.select-provincia')
					</div>
					<!-- ENTIDAD -->
					<div class="form-group">
						<label for="entidad">Entidad</label>
						@include('common.select-entidad')
					</div>
					<!-- MENU -->
					<div class="form-group">
						<label for="menu">Permisos</label>
						@include('common.select-menu')
					</div>
					<!-- AREA -->
					<div class="form-group">
						<label for="area">Area</label>
						@include('common.select-area')
					</div>
				</div>
				<div class="box-footer">
					<div class="btn-group " role="group">
					 	<button type="button" class="back btn btn-info">Atrás</button>
						<button id-usuario="{{ $usuario->id_usuario }}" type="button" class="block btn btn-danger">Bloquear</button>
						<button id-usuario="{{ $usuario->id_usuario }}" type="button" class="save btn btn-info">Guardar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal modal-info">
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
        <button type="button" class="btn btn-outline" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
	$(document).ready(function(){

		$('.back').click(function(){
			$.get('usuarios' , function(data){
				$('.content-wrapper').html(data);
			});
		});

		$('.block').click(function(){});

		$('.save').click(function(){
			var id = $(this).attr('id-usuario');
			$.post('edit-usuario/' + id , $('#form-edit-user').serialize() , function(data){
				//console.log(data);
				$('#modal-text').html(data);
				$('.modal').modal();
			})
		});

	});
</script>