@extends('content')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Historia Cl&iacute;nica del beneficiario: {{ $beneficiario->nombre . ' ' . $beneficiario->apellido}}</h2>
			</div>
			<div class="box-body">
				<form class="form-horizontal">
					<h4>Información general</h4>
					<div class="row">
						<div class="col-md-6">
							<!-- NOMBRE -->
							<div class="form-group">
								<label class="col-md-2 control-label">Nombre</label>
								<div class="col-md-10">
									<p class="form-control-static">{{ $beneficiario->nombre }}</p>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<!-- APELLIDO -->
							<div class="form-group">
								<label class="col-md-2 control-label">Apellido</label>
								<div class="col-md-10">
									<p class="form-control-static">{{ $beneficiario->apellido }}</p>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<!-- DNI -->
							<div class="form-group">
								<label class="col-md-6 control-label">D.N.I</label>
								<div class="col-md-6">
									<p class="form-control-static">{{ $beneficiario->numero_documento }}</p>
								</div>
							</div>	
						</div>
						<div class="col-md-2">
							<!-- FECHA DE NACIMIENTO -->
							<div class="form-group">
								<label class="col-md-6 control-label">Fecha de nacimiento</label>
								<div class="col-md-6">
									<p class="form-control-static">{{ $beneficiario->fecha_nacimiento }}</p>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<!-- FECHA DE INSCRIPCION -->
							<div class="form-group">
								<label class="col-md-6 control-label">Fecha de Inscripcion</label>
								<div class="col-md-6">
									<p class="form-control-static">{{ $beneficiario->fecha_inscripcion }}</p>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<!-- ESTADO -->
							<div class="form-group">
								<label class="col-md-6 control-label">Edad</label>
								<div class="col-md-6">
									<p class="form-control-static">{{ $beneficiario->edad }}</p>
								</div>
							</div>
						</div>
					</div>						
					<div class="row">
						<div class="col-md-2">
							<!-- ACTIVO -->
							<div class="form-group">
								<label class="col-md-6 control-label">Activo</label>
								<div class="col-md-6">
									<p class="form-control-static">
									@if ($beneficiario->activo == 'S')
										<span class="label label-success">SI</span>
									@else 
										<span class="label label-danger">NO</span>
									@endif
									</p>
								</div>
							</div>
						</div>												
					</div>
					<h4>Domicilio</h4>
					<div class="row">
						<div class="col-md-12">
							<!-- PROVINCIA -->
							<div class="form-group">
								<label class="col-md-1 control-label">Provincia</label>
								<div class="col-md-11">
									<p class="form-control-static">{{ $beneficiario->geo->provincia->descripcion }}</p>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<!-- DEPARTAMENTO -->
							<div class="form-group">
								<label class="col-md-3 control-label">Departamento</label>
								<div class="col-md-6">
									<p class="form-control-static">{{ $beneficiario->geo->departamento->nombre_departamento }}</p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<!-- LOCALIDAD -->
							<div class="form-group">
								<label class="col-md-6 control-label">Localidad</label>
								<div class="col-md-6">
									<p class="form-control-static">{{ $beneficiario->geo->localidad->nombre_localidad }}</p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<!-- CALLE -->
							<div class="form-group">
								<label class="col-md-6 control-label">Localidad</label>
								<div class="col-md-6">
									<p class="form-control-static">{{ $beneficiario->geo->calle }}</p>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="box-footer">
				<div class="btn-group " role="group">
				 	<button type="button" class="back btn btn-info">Atrás</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
<script type="text/javascript">
	$(document).ready(function(){

		$('.back').click(function(){
			$.get('{{ $back }}' , function(data){
				$('.content-wrapper').html(data);
			});
		});

	});
</script>