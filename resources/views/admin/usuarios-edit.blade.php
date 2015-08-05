<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="box box-info">
			<div class="box-header">
				<h2>{{ $usuario->nombre }}</h2>
			</div>
			<div class="box-body">
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
			</div>
			<div class="box-footer">
				<div class="btn-group " role="group">
				 	<button type="button" class="btn btn-info">Atrás</button>
					<button type="button" class="btn btn-danger">Bloquear</button>
					<button type="button" class="btn btn-info">Guardar</button>
				</div>
			</div>
		</div>
	</div>
</div>