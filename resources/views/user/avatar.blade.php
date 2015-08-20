@extends('content')
@section('content')
<style type="text/css">
.btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}
</style>
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Seleccione una nueva foto</h2>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-md-4">
						<div class="text-center">
							<img src="{{ asset("/dist/img/usuarios/") . '/' . $user->ruta_imagen }}" class="img-circle">
						</div>
					</div>
					<div class="col-md-8">
						<div class="form-group">
							<label for="avatar">Imagen de perfil</label>
							<span class="form-control btn btn-primary btn-file">
								Elegir una imagen <input name="avatar" type="file">
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
				
			</div>
		</div>
	</div>
</div>
@endsection