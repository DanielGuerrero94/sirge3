@extends('content')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/cropper/dist/cropper.css") }}">
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h1 class="box-title">{{ $usuario->nombre }} <small>{{ $usuario->mensaje }}</small></h1>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-md-3">
						<div class="text-center">
							<img src="{{ asset("/dist/img/usuarios/") . '/' . $usuario->ruta_imagen }}" class="img-circle">
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
<script type="text/javascript" src="{{ asset("/bower_components/cropper/dist/cropper.js") }}"></script>
@endsection