@extends('content')
@section('content')
<!-- Contact list -->
<div class="row">
	<div class="col-md-4">
		<div class="row" id="listado-contactos">
			@include('inbox.usuarios')
		</div>
	</div>
	<div class="col-md-8" id="box-mensajes">
	</div>
</div>
@endsection