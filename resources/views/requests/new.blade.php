@extends('content')
@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">
					Complete el formulario
				</h2>
			</div>
			<form id="form-new-request">
				<div class="box-body">
					<!--- TIPO DE SOLICITUD -->
					<div class="form-group">
						<label for="grupo">Seleccione hacia quien va dirigida su solicitud</label>
						@include('common.select-sector-solicitud')
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">
					Listado de solicitudes ingresadas
				</h2>
			</div>
			<div class="box-body">
				
			</div>
		</div>
	</div>
</div>
@endsection