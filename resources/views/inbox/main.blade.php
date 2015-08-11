@extends('content')
@section('content')
<!-- Contact list -->
<div class="row">
	<div class="col-md-4">
		<div class="row">
			<!--
			<div class="col-lg-12">
				<div class="input-group">
		  			<input id="busqueda-contacto" type="text" class="form-control" placeholder="Contacto...">	
			  		<span class="input-group-btn">
				    	<button id="busqueda" class="btn btn-default" type="button">Buscar</button>
				  	</span>
				</div>
			</div>
			-->
		</div>
		<br/>
		<div class="row" id="listado-contactos">
			@include('inbox.usuarios')
		</div>
	</div>
	<div class="col-md-8" id="box-mensajes">
	</div>
</div>
@endsection