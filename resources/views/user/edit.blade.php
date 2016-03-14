@extends('content')
@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div id="action-container">
			<div class="box box-info">
				<div class="box-header">
					<h2 class="box-title">{{ $usuario->nombre }}</h2>
				</div>
				<form id="form-edit-user">
					<div class="box-body">
					    <div class="alert alert-danger" id="errores-div">
					        <ul id="errores-form">
					        </ul>
					    </div>
						<!--- NOMBRE -->
						<div class="form-group">
							<label for="nombre">Nombre</label>
							<input class="form-control" type="text" name="nombre" value="{{ $usuario->nombre }}">
						</div>

						<!--- EMAIL -->
						<div class="form-group">
							<label for="nombre">Email</label>
							<input class="form-control" type="text" name="email" value="{{ $usuario->email }}">
						</div>
						<div class="row">
							<div class="col-md-3">
								<!--- PROVINCIA -->
								<div class="form-group">
									<label for="provincia">Provincia</label>
									@include('common.select-provincia')
								</div>
							</div>
							<div class="col-md-3">
								<!--- ENTIDAD -->
								<div class="form-group">
									<label for="entidad">Entidad</label>
									@include('common.select-entidad')
								</div>
							</div>
							<div class="col-md-3">
								<!--- AREA -->
								<div class="form-group">
									<label for="area">Área</label>
									@include('common.select-area')
								</div>
							</div>
							<div class="col-md-3">
								<!--- OCUPACION -->
								<div class="form-group">
									<label for="ocupacion">Ocupación</label>
									<input class="form-control" type="text" name="cargo" value="{{ $usuario->cargo }}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<!--- FECHA DE NACIMIENTO -->
								<div class="form-group">
									<label for="fecha-nacimiento">Fecha de nacimiento</label>
									<input id="fecha-nacimiento" class="form-control" type="text" name="fecha_nacimiento" value="{{ date('d/m/Y' , strtotime($usuario->fecha_nacimiento)) }}">
								</div>
							</div>
							<div class="col-md-3">
								<!--- TELEFONO -->
								<div class="form-group">
									<label for="telefono">Teléfono</label>
									<input id="telefono" class="form-control" type="text" name="telefono" value="{{ $usuario->telefono }}">
								</div>
							</div>
							<div class="col-md-6">
								<!--- MENSAJE PERSONAL -->
								<div class="form-group">
									<label for="mensaje">Mensaje personal</label>
									<input id="mensaje" class="form-control" type="text" name="mensaje" value="{{ $usuario->mensaje }}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
	                        		<div class="input-group">
									 	<span class="input-group-addon" id="fb"><i class="fa fa-facebook"></i></span>
									 	<input type="text" class="form-control" id="fb" name="fb" value="{{ $usuario->facebook }}" aria-describedby="fb">
									</div>
	                        	</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
	                        		<div class="input-group">
									 	<span class="input-group-addon" id="tw"><i class="fa fa-twitter"></i></span>
									 	<input type="text" class="form-control" id="tw" name="tw" value="{{ $usuario->twitter }}" aria-describedby="tw">
									</div>
	                        	</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
	                        		<div class="input-group">
									 	<span class="input-group-addon" id="g+"><i class="fa fa-google-plus"></i></span>
									 	<input type="text" class="form-control" id="gp" name="gp" value="{{ $usuario->google }}" aria-describedby="g+">
									</div>
	                        	</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
	                        		<div class="input-group">
									 	<span class="input-group-addon" id="skype"><i class="fa fa-skype"></i></span>
									 	<input type="text" class="form-control" name="skype" value="{{ $usuario->skype }}" aria-describedby="skype">
									</div>
	                        	</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
	                        		<div class="input-group">
									 	<span class="input-group-addon" id="ln"><i class="fa fa-linkedin"></i></span>
									 	<input type="text" class="form-control" id="ln" name="ln" value="{{ $usuario->linkedin }}" aria-describedby="ln">
									</div>
	                        	</div>
							</div>
							<div class="col-md-4">
							</div>
						</div>
					</div>
					<div class="box-footer">
						<div class="btn-group" role="group">
							<button class="save btn btn-info">Guardar</button>
							<button type="button" class="pass btn btn-warning">Cambiar contraseña</button>
						</div>
					</div>
				</form>
			</div>
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

		$('#fecha-nacimiento').inputmask('99/99/9999');
		$('#telefono').inputmask('99999999999');
		$('#errores-div').hide();

		$('.pass').click(function(){
			$.get('new-password' , function(data){
				$('#action-container').html(data);
			});
		});

		$('.save').click(function(){
			$('#form-edit-user').validate({
				rules : {
		            nombre : {
		                required: true,
		                minlength: 4,
		                maxlength: 30
		            },
		            apellido : {
		                required: true,
		                minlength: 4,
		                maxlength: 30
		            },
		            email : {
		                required: true,
		                email: true
		            },
		            fecha_nacimiento : {
		                required: true
		            },
		            cargo : {		                
		                minlength: 8,
		                maxlength: 100
		            }
		        },
				submitHandler : function(form){
					
					console.log($(form).serialize());

					$.ajax({
						method : 'post',
						data : $(form).serialize(),
						url  : 'ajustes',
						success : function(data){
							$('#errores-div').hide();

							if (data == '0'){
								html = '<li>El email especificado ya está siendo usado por otro usuario</li>';
								$('#errores-form').html(html);
								$('#errores-div').show();	
							} else {
								$('#modal-text').html('Se han modificado los datos');
								$('.modal').modal();

								$('.modal .modal-dialog button').on('click', function(){
									$.get('{{ $back }}' , function(data){
										$('.content-wrapper').html(data);
									});	
								})						
							}
						},
						error : function(data){
							var html = '';
							var e = JSON.parse(data.responseText);
							$.each(e , function (key , value){
								html += '<li>' + value[0] + '</li>';
							});
							$('#errores-form').html(html);
							$('#errores-div').show();
						}
					});
				}
			});
		});
	});
</script>
@endsection