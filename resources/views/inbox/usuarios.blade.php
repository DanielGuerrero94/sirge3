<div class="col-md-12">
	@foreach ($usuarios as $contacto)
	<div class="box box-warning">
		<div class="container" style="margin-top:20px;">
			<div class="media">
        		<a href="#" class="pull-left usuario" id-usuario="{{ $contacto->id_usuario }}">
        		<img src="{{asset ("/dist/img/usuarios/$contacto->ruta_imagen") }}" class="user-image img-circle" alt="User Image" style="width: 48px; height: 48px;">
        		</a>
        		<div class="media-body">
	          		<h4 class="media-heading usuario" id-usuario="{{ $contacto->id_usuario }}"><a href="#">{!! ucwords(strtolower($contacto->nombre)) !!}</a></h4>
	          		<p class="small">{{ $contacto->descripcion }}</p>
	          		<p class="small"><span class="glyphicon glyphicon-time timestamp" data-toggle="tooltip" data-placement="bottom" ></span> {{ date ('d M y', strtotime($contacto->last_login)) }}</p>
        		</div>
      		</div>
		</div>
	</div>
	@endforeach
</div>
<script type="text/javascript">
	$(document).ready(function(){

		$('.usuario').click(function(){

			if (typeof interval != 'undefined'){
				console.log(interval);
				clearInterval(interval);
			}

			var user_to = $(this).attr('id-usuario');
			var user_from = {{ Auth::user()->id_usuario }};
			
			$.get('mensajes-inbox/' + user_from + '/' + user_to , function(data){
				$('#box-mensajes').html(data);
			});
		});
	});
</script>