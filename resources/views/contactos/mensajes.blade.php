<div class="box box-warning direct-chat direct-chat-warning">
	<div class="box-header with-border">
		<h3 class="box-title">Mensajes directos</h3>
	</div><!-- /.box-header -->
	<div class="box-footer" style="display: block;">
	  <form id="form-mensaje">
	    <div class="input-group">
	      <input type="text" name="message" placeholder="Escribir mensaje ..." class="form-control">
	      <span class="input-group-btn">
	        <button type="submit" class="btn btn-warning btn-flat">Enviar</button>
	      </span>
	    </div>
	    
	    <input name="id_conversacion" type="hidden" value="{{ $info->conversacion->id }}">
	    {!! csrf_field() !!}
	  </form>
	</div><!-- /.box-footer-->
	<div class="box-body" style="display: block;">
		<!-- Conversations are loaded here -->
		<div class="direct-chat-messages">
@foreach ($mensajes as $key => $mensaje)
			<div class="direct-chat-msg 
			@if ($mensaje['id_usuario'] != Auth::user()->id_usuario)
				right
			@endif
			">
		      <div class="direct-chat-info clearfix">
		        <span class="direct-chat-name pull-left">{{ $mensaje['usuario']['nombre'] }}</span>
		        <span class="direct-chat-timestamp pull-right">{{ date ('d M y - H:m:s', strtotime($mensaje['fecha'])) }}</span>
		      </div><!-- /.direct-chat-info -->
		      <img class="direct-chat-img" src="{{asset ("/dist/img/usuarios/") . '/' . $mensaje['usuario']['ruta_imagen']}}" alt="message user image"><!-- /.direct-chat-img -->
		      <div class="direct-chat-text">
		        {{ $mensaje['mensaje'] }}
		      </div><!-- /.direct-chat-text -->
		    </div><!-- /.direct-chat-msg -->
@endforeach
		</div><!--/.direct-chat-messages-->
	</div><!-- /.box-body -->

</div>
<script type="text/javascript">
	$('#form-mensaje').submit(function(event){
		event.preventDefault();
		var mensaje = $(this).serializeArray();
		console.log(mensaje);
		$('.box-body').load('mensajes .direct-chat-messages', mensaje, function(data){
			$('#form-mensaje')[0].reset();
		});
	});
</script>
	  
	
	
