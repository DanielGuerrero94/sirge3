@extends('content')
@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">{{ $usuario->nombre }}</h2>
			</div>
			<form id="form-edit-user">
				<div class="box-body">
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
								<label for="nombre">Entidad</label>
								@include('common.select-entidad')
							</div>
						</div>
						<div class="col-md-3">
							<!--- AREA -->
							<div class="form-group">
								<label for="nombre">Área</label>
								@include('common.select-area')
							</div>
						</div>
						<div class="col-md-3">
							<!--- OCUPACION -->
							<div class="form-group">
								<label for="ocupacion">Ocupación</label>
								<input class="form-control" type="text" name="ocupacion" value="{{ $usuario->ocupacion }}">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<!--- FECHA DE NACIMIENTO -->
							<div class="form-group">
								<label for="nombre">Fecha de nacimiento</label>
								<input class="form-control" type="text" name="fecha_nacimiento" value="{{ date('d/m/Y' , strtotime($usuario->fecha_nacimiento)) }}">
							</div>
						</div>
						<div class="col-md-3">
							<!--- FECHA DE NACIMIENTO -->
							<div class="form-group">
								<label for="nombre">Teléfono</label>
								<input class="form-control" type="text" name="telefono" value="{{ $usuario->telefono }}">
							</div>
						</div>
						<div class="col-md-6">
							<!--- MENSAJE PERSONAL -->
							<div class="form-group">
								<label for="nombre">Mensaje peronsal</label>
								<input class="form-control" type="text" name="email" value="{{ $usuario->mensaje }}">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
                        		<div class="input-group">
								 	<span class="input-group-addon" id="fb"><i class="fa fa-facebook"></i></span>
								 	<input type="text" class="form-control" name="fb" placeholder="Facebook" aria-describedby="fb">
								</div>
                        	</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
                        		<div class="input-group">
								 	<span class="input-group-addon" id="tw"><i class="fa fa-twitter"></i></span>
								 	<input type="text" class="form-control" name="tw" placeholder="Twitter" aria-describedby="tw">
								</div>
                        	</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
                        		<div class="input-group">
								 	<span class="input-group-addon" id="g+"><i class="fa fa-google-plus"></i></span>
								 	<input type="text" class="form-control" name="gp" placeholder="Google +" aria-describedby="g+">
								</div>
                        	</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
                        		<div class="input-group">
								 	<span class="input-group-addon" id="skype"><i class="fa fa-skype"></i></span>
								 	<input type="text" class="form-control" name="skype" placeholder="Skype" aria-describedby="skype">
								</div>
                        	</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
                            		<div class="input-group">
									 	<span class="input-group-addon" id="ln"><i class="fa fa-linkedin"></i></span>
									 	<input type="text" class="form-control" name="ln" placeholder="LinkedIn" aria-describedby="ln">
									</div>
                            	</div>
                        	</div>
						</div>
						<div class="col-md-4"></div>
					</div>
				</div>
				<div class="box-footer">
					<div class="btn-group" role="group">
						<button class="save btn btn-info">Guardar</button>
						<button class="btn btn-warning">Cambiar contraseña</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- jQuery validator -->
<script src="{{ asset ("/dist/js/jquery.validate.min.js") }}"></script>
<!-- Inputmask jQuery -->
<script src="{{ asset ("/dist/js/jquery.inputmask.js") }}"></script>
<!-- Inputmask -->
<script src="{{ asset ("/dist/js/inputmask.js") }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.save').click(function(){
			$('#form-edit-user').validate({
				rules : {
					nombre : {
						required : true
					},
					email : {
						required : true,
						email : true,
						remote : 'checkemail'
					}
				},
				submitHandler : function(from){}
			});
		});
	});
</script>
@endsection