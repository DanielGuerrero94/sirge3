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
	    
	    <input name="id_conversacion" type="hidden" value="{{ $info[0]->id }}">
	    {!! csrf_field() !!}
	  </form>
	</div><!-- /.box-footer-->
	<div class="box-body" style="display: block;">
		<!-- Conversations are loaded here -->
		<div class="direct-chat-messages">
			@foreach ($info as $key => $mensaje)
				@foreach ($mensaje->mensajes as $key2 => $data)
					<div class="direct-chat-msg
					@if ($data->id_usuario != Auth::user()->id_usuario)
						right
					@endif
					">
						<div class="direct-chat-info clearfix">
							<span class="direct-chat-name 
								@if ($data->id_usuario != Auth::user()->id_usuario)
									pull-right
								@else 
									pull-left
								@endif
							">{{ $data->usuario->nombre }}</span>
							<span class="direct-chat-timestamp
								@if ($data->id_usuario != Auth::user()->id_usuario)
									pull-left
								@else 
									pull-right
								@endif
							">{{ date ('d M y - H:i:s', strtotime($data->fecha)) }}</span>
						</div>
						<img class="direct-chat-img" src="{{asset ("/dist/img/usuarios/") . '/' . $data->usuario->ruta_imagen}}" alt="message user image"><!-- /.direct-chat-img -->
						<div class="direct-chat-text">
							{{ $data->mensaje }}
					  	</div><!-- /.direct-chat-text -->
					</div>
				@endforeach
			@endforeach
		</div><!--/.direct-chat-messages-->
	</div><!-- /.box-body -->

</div>
<script type="text/javascript">
	
	function reloadChat (){
		setInterval(function(){
			var user_to = $('#enviar-mensaje').attr('id-usuario');
			var user_from = {{ Auth::user()->id_usuario }};
				$('.box-body').load('mensajes/' + user_from + '/' + user_to + ' .direct-chat-messages');	
		} , 2000);
	}

	$('#form-mensaje').submit(function(event){
		event.preventDefault();
		var mensaje = $(this).serializeArray();
		$('.box-body').load('mensajes .direct-chat-messages', mensaje, function(data){
			$('#form-mensaje')[0].reset();
		});
	});

	$(document).ready(function(){
		//reloadChat();
	});
</script>
	  
	
	
