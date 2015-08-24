@extends('content')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/cropper/dist/cropper.css") }}">
<link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/cropper/dist/cropper.css") }}">
<link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/cropper/dist/main.css") }}">

<div class="container" id="crop-avatar">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header">
					<h1 class="box-title">{{ $usuario->nombre }} <small>{{ $usuario->mensaje }}</small></h1>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-3">
							<!-- Current avatar -->
						    <div class="avatar-view" title="Cambiar imagen de perfil">
						    	<img class="img-circle" src="{{ asset("/dist/img/usuarios/") . '/' . $usuario->ruta_imagen }}" alt="Avatar">
						    </div>
							<br />
							<div class="text-center">
								<a href="{{ $usuario->google }}" class="btn btn-danger"><i class="fa fa-google-plus fa-lg"></i></a>
								<a href="{{ $usuario->facebook }}" class="btn btn-primary"><i class="fa fa-facebook fa-lg"></i></a>
								<a href="{{ $usuario->linkedin }}" class="btn btn-primary"><i class="fa fa-linkedin fa-lg"></i></a>
								<a href="{{ $usuario->twitter }}" class="btn btn-info"><i class="fa fa-twitter fa-lg"></i></a>
								<a href="{{ $usuario->skype }}" class="btn btn-info"><i class="fa fa-skype fa-lg"></i></a>
							</div>
						</div>
						<div class="col-md-5">
							<form class="form-horizontal">
								<!-- NOMBRE -->
								<div class="form-group">
									<label class="col-md-5 control-label">Nombre</label>
									<div class="col-md-7">
										<p class="form-control-static">{{ $usuario->nombre }}</p>
									</div>
								</div>

								<!-- EMAIL -->
								<div class="form-group">
									<label class="col-md-5 control-label">Email</label>
									<div class="col-md-7">
										<p class="form-control-static">{{ $usuario->email }}</p>
									</div>
								</div>

								<!-- PROVINCIA -->
								<div class="form-group">
									<label class="col-md-5 control-label">Provincia</label>
									<div class="col-md-7">
										<p class="form-control-static">{{ $usuario->provincia->descripcion }}</p>
									</div>
								</div>

								<!-- ENTIDAD -->
								<div class="form-group">
									<label class="col-md-5 control-label">Entidad</label>
									<div class="col-md-7">
										<p class="form-control-static">{{ $usuario->entidad->descripcion }}</p>
									</div>
								</div>

								<!-- AREA -->
								<div class="form-group">
									<label class="col-md-5 control-label">Area</label>
									<div class="col-md-7">
										<p class="form-control-static">{{ $usuario->area->nombre }}</p>
									</div>
								</div>

								<!-- PERMISOS -->
								<div class="form-group">
									<label class="col-md-5 control-label">Permisos</label>
									<div class="col-md-7">
										<p class="form-control-static">{{ $usuario->menu->descripcion }}</p>
									</div>
								</div>

								<!-- OCUPACION -->
								<div class="form-group">
									<label class="col-md-5 control-label">Ocupación</label>
									<div class="col-md-7">
										<p class="form-control-static">{{ $usuario->ocupacion }}</p>
									</div>
								</div>

								<!-- FECHA DE NACIMIENTO -->
								<div class="form-group">
									<label class="col-md-5 control-label">Fecha de nacimiento</label>
									<div class="col-md-7">
										<p class="form-control-static">{{ date ('d M Y' , strtotime($usuario->fecha_nacimiento)) }}</p>
									</div>
								</div>

								<!-- TELEFONO -->
								<div class="form-group">
									<label class="col-md-5 control-label">Teléfono</label>
									<div class="col-md-7">
										<p class="form-control-static">{{ $usuario->telefono }}</p>
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-4">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Últimas conexiones</h3>
								</div>
								<div class="box-body">
									<table class="table table-hover">
										<thead>
											<th>Fecha</th>
											<th>Hora</th>
										</thead>
										<tbody>
											@foreach ($usuario->conexiones as $conexiones)
												<tr>
													<td>{{ date ('d M y', strtotime($conexiones->fecha_login)) }}</td>
													<td>{{ date ('H:i:s', strtotime($conexiones->fecha_login)) }}</td>
												</tr>
											@endforeach
										</tbody>
									</table> 
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
	<!-- Cropping modal -->
    <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
    	<div class="modal-dialog modal-lg">
        	<div class="modal-content">
          		<form class="avatar-form" action="usuario-imagen" enctype="multipart/form-data" method="post">
            		<div class="modal-header">
              			<button type="button" class="close" data-dismiss="modal">&times;</button>
              			<h4 class="modal-title" id="avatar-modal-label">Cambiar imágen</h4>
            		</div>
            		<div class="modal-body">
              			<div class="avatar-body">

                		<!-- Upload image and data -->
                			<div class="avatar-upload">
	                  			<input type="hidden" class="avatar-src" name="avatar_src">
	                  			<input type="hidden" class="avatar-data" name="avatar_data">
	                  			<label for="avatarInput">Archivo local</label>
	                  			<input type="file" class="avatar-input" id="avatarInput" name="avatar_file">
                			</div>

                			<!-- Crop and preview -->
                			<div class="row">
                  				<div class="col-md-9">
                    				<div class="avatar-wrapper"></div>
                  				</div>
                  				<div class="col-md-3">
                    				<div class="avatar-preview preview-lg"></div>
                    				<div class="avatar-preview preview-md"></div>
                    				<div class="avatar-preview preview-sm"></div>
                  				</div>
                			</div>

                			<div class="row avatar-btns">
                  				<div class="col-md-3">
                    				<button type="submit" class="btn btn-primary btn-block avatar-save">Listo!</button>
                  				</div>
                			</div>
              			</div>
            		</div>
          		</form>
        	</div>
      	</div>
    </div><!-- /.modal -->
    <!-- Loading state -->
    <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
</div>
<script type="text/javascript" src="{{ asset("/bower_components/cropper/dist/cropper.js") }}"></script>
<script type="text/javascript" src="{{ asset("/bower_components/cropper/dist/main.js") }}"></script>
@endsection