@extends('content')
@section('content')
<!-- Contact list -->
<div class="row">
	<div class="col-md-4">
		<div class="row">
			<div class="col-lg-12">
				<div class="input-group">
		  			<input id="busqueda-contacto" type="text" class="form-control" placeholder="Contacto...">	
			  		<span class="input-group-btn">
				    	<button id="busqueda" class="btn btn-default" type="button">Buscar</button>
				  	</span>
				</div><!-- /input-group -->
			</div><!-- /.col-lg-6 -->
		</div>
		<br/>
		<div class="row" id="listado-contactos">
		    @include('contactos.listado')
		</div>
	</div>
	<div class="col-md-4" id="card-profile"></div>
	<div class="col-md-4" id="box-mensajes"></div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	
	$('#listado-contactos').on('click' , '.usuario' , function(event){
		event.preventDefault();
		var usuario = $(this).attr('id-usuario');
		$.get('tarjeta/' + usuario, function(data){
			$('#card-profile').html(data);
		});
	});

	$('#card-profile').on('click' , '#enviar-mensaje' , function(){
		var user_to = $(this).attr('id-usuario');
		var user_from = {{ Auth::user()->id_usuario }};

		if (user_to == user_from){
			alert ('No se puede mandar mensajes a usted mismo');
		} else {
			$.get('mensajes/' + user_from + '/' + user_to , function(data){
				$('#box-mensajes').html(data);
			});	
		}
	});

	$('#busqueda').click(function(event){
		var query = $('#busqueda-contacto').val();
		if (! query.length) { query = 'ALL'; }
		$.get('listado/' + query , function(data){
			$('#listado-contactos').html(data);
		});	
	});

});
</script>
@endsection