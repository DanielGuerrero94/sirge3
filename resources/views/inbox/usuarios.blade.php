<div class="col-md-12">
	@foreach ($usuarios as $contacto)
	<div class="box box-warning">
		<div class="container" style="margin-top:20px;">
			<div class="media">
        		<a href="#" class="pull-left usuario" id-usuario="{{ $contacto->id_usuario }}">
        		<img src="{{asset ("/dist/img/usuarios/$contacto->ruta_imagen") }}" class="user-image img-circle" alt="User Image" style="width: 48px; height: 48px;">
        		</a>
        		<div class="media-body">
	          		<h4 class="media-heading usuario" id-usuario="{{ $contacto->id_usuario }}"><a href="#">{{ $contacto->nombre }}</a></h4>
	          		<p class="small"></p>
	          		<p class="small"><span class="glyphicon glyphicon-time timestamp" data-toggle="tooltip" data-placement="bottom" ></span></p>
        		</div>
      		</div>
		</div>
	</div>
	@endforeach
</div>