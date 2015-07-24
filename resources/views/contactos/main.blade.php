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
	<div class="col-md-4">
		<div class="box box-warning direct-chat direct-chat-warning">
	        <div class="box-header with-border">
	          <h3 class="box-title">Mensajes directos</h3>
	        </div><!-- /.box-header -->
	        <div class="box-body" style="display: block;">
	          <!-- Conversations are loaded here -->
	          <div class="direct-chat-messages">
	            <!-- Message. Default to the left -->
	            <div class="direct-chat-msg">
	              <div class="direct-chat-info clearfix">
	                <span class="direct-chat-name pull-left">Gustavo D. Hekel</span>
	                <span class="direct-chat-timestamp pull-right">23 Ene 2015 2:00 pm</span>
	              </div><!-- /.direct-chat-info -->
	              <img class="direct-chat-img" src="http://localhost/sirge3/public/bower_components/admin-lte/dist/img/user2-160x160.jpg" alt="message user image"><!-- /.direct-chat-img -->
	              <div class="direct-chat-text">
	                Hola Ari, te vas a quedar hasta tarde hoy haciendote la puñeta? ... Viejo pajero!
	              </div><!-- /.direct-chat-text -->
	            </div><!-- /.direct-chat-msg -->

	            <!-- Message to the right -->
	            <div class="direct-chat-msg right">
	              <div class="direct-chat-info clearfix">
	                <span class="direct-chat-name pull-right">Ariel J</span>
	                <span class="direct-chat-timestamp pull-left">23 Ene 2015 2:05 pm</span>
	              </div><!-- /.direct-chat-info -->
	              <img class="direct-chat-img" src="http://localhost/sirge3/public/bower_components/admin-lte/dist/img/user4-128x128.jpg" alt="message user image"><!-- /.direct-chat-img -->
	              <div class="direct-chat-text">
	                No te quepan dudas!! ;)
	              </div><!-- /.direct-chat-text -->
	            </div><!-- /.direct-chat-msg -->
	          </div><!--/.direct-chat-messages-->
	        </div><!-- /.box-body -->
	        <div class="box-footer" style="display: block;">
	          <form action="#" method="post">
	            <div class="input-group">
	              <input type="text" name="message" placeholder="Escribir mensaje ..." class="form-control">
	              <span class="input-group-btn">
	                <button type="button" class="btn btn-warning btn-flat">Enviar</button>
	              </span>
	            </div>
	          </form>
	        </div><!-- /.box-footer-->
	      </div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	
	$('.usuario').on('click' , function(event){
		event.preventDefault();
		var usuario = $(this).attr('id-usuario');
		$.get('tarjeta/' + usuario, function(data){
			$('#card-profile').html(data);
		});
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