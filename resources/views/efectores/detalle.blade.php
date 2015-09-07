@extends('content')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Detalle del efector: {{ $efector->nombre }}</h2>
			</div>
			<div class="box-body">
				<form class="form-horizontal">
					<div class="row">
						<div class="col-md-12">
							<!-- NOMBRE -->
							<div class="form-group">
								<label class="col-md-1 control-label">Nombre</label>
								<div class="col-md-11">
									<p class="form-control-static">{{ $efector->nombre }}</p>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<!-- CUIE -->
							<div class="form-group">
								<label class="col-md-6 control-label">CUIE</label>
								<div class="col-md-6">
									<p class="form-control-static">{{ $efector->cuie }}</p>
								</div>
							</div>	
						</div>
						<div class="col-md-2">
							<!-- SIISA -->
							<div class="form-group">
								<label class="col-md-6 control-label">SIISA</label>
								<div class="col-md-6">
									<p class="form-control-static">{{ $efector->siisa }}</p>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<!-- ESTADO -->
							<div class="form-group">
								<label class="col-md-6 control-label">Estado</label>
								<div class="col-md-6">
									<p class="form-control-static"><span class="label label-{{ $efector->estado->css }}">{{ $efector->estado->descripcion }}</span></p>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<!-- PRIORIZADO -->
							<div class="form-group">
								<label class="col-md-6 control-label">Priorizado</label>
								<div class="col-md-6">
									<p class="form-control-static">
									@if ($efector->priorizado == 'S')
										<span class="label label-success">SI</span>
									@else 
										<span class="label label-danger">NO</span>
									@endif
									</p>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<!-- INTEGRANTE -->
							<div class="form-group">
								<label class="col-md-6 control-label">Integrante</label>
								<div class="col-md-6">
									<p class="form-control-static">
									@if ($efector->integrante == 'S')
										<span class="label label-success">SI</span>
									@else 
										<span class="label label-danger">NO</span>
									@endif
									</p>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<!-- PPAC -->
							<div class="form-group">
								<label class="col-md-3 control-label">PPAC</label>
								<div class="col-md-6">
									<p class="form-control-static">
									@if ($efector->ppac == 'S')
										<span class="label label-success">SI</span>
									@else 
										<span class="label label-danger">NO</span>
									@endif
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<!-- TIPO -->
							<div class="form-group">
								<label class="col-md-3 control-label">Tipo</label>
								<div class="col-md-6">
									<p class="form-control-static">{{ $efector->tipo->descripcion }}</p>
								</div>
							</div>	
						</div>
						<div class="col-md-4">
							<!-- SIISA -->
							<div class="form-group">
								<label class="col-md-6 control-label">Cetegoría</label>
								<div class="col-md-6">
									<p class="form-control-static">{{ $efector->categoria->sigla }}</p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<!-- ESTADO -->
							<div class="form-group">
								<label class="col-md-6 control-label">Dependencia</label>
								<div class="col-md-6">
									<p class="form-control-static">{{ $efector->dependencia->descripcion }}</p>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<!-- ESTADO -->
							<div class="form-group">
								<label class="col-md-1 control-label">Domicilio</label>
								<div class="col-md-11">
									<p class="form-control-static">{{ $efector->domicilio }}</p>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<!-- PROVINCIA -->
							<div class="form-group">
								<label class="col-md-3 control-label">Provincia</label>
								<div class="col-md-6">
									<p class="form-control-static">{{ $efector->geo->provincia->descripcion }}</p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<!-- DEPARTAMENTO -->
							<div class="form-group">
								<label class="col-md-6 control-label">Departamento</label>
								<div class="col-md-6">
									<p class="form-control-static">{{ $efector->geo->departamento->nombre_departamento }}</p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<!-- LOCALIDAD -->
							<div class="form-group">
								<label class="col-md-6 control-label">Localidad</label>
								<div class="col-md-6">
									<p class="form-control-static">{{ $efector->geo->localidad->nombre_localidad }}</p>
								</div>
							</div>
						</div>
					</div>
						<h4>Compromiso</h4>
					<div class="row">
						<div class="col-md-4">
							<!-- PROVINCIA -->
							<div class="form-group">
								<label class="col-md-3 control-label">Provincia</label>
								<div class="col-md-6">
									<p class="form-control-static">{{ $efector->geo->provincia->descripcion }}</p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<!-- DEPARTAMENTO -->
							<div class="form-group">
								<label class="col-md-3 control-label">Departamento</label>
								<div class="col-md-6">
									<p class="form-control-static">{{ $efector->geo->departamento->nombre_departamento }}</p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<!-- LOCALIDAD -->
							<div class="form-group">
								<label class="col-md-3 control-label">Localidad</label>
								<div class="col-md-6">
									<p class="form-control-static">{{ $efector->geo->localidad->nombre_localidad }}</p>
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