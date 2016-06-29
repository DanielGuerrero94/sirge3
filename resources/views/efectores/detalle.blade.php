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
					<h4>Información general</h4>
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
					<h4>Información geográfica</h4>
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

					@if ($efector->compromiso_gestion == 'N')
						<div class="callout callout-danger">
	                		<h4>Atención!</h4>
	                		<p>Este efector no posee compromiso de gestión firmado</p>
	              		</div>
					@else
						<h4>Compromiso de gestión</h4>
						<div class="row">
							<div class="col-md-4">
								<!-- NUMERO -->
								<div class="form-group">
									<label class="col-md-6 control-label">Número</label>
									<div class="col-md-6">
										<p class="form-control-static">{{ $efector->compromiso->numero_compromiso }}</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<!-- NUMERO -->
								<div class="form-group">
									<label class="col-md-6 control-label">Firmante</label>
									<div class="col-md-6">
										<p class="form-control-static">{{ $efector->compromiso->firmante }}</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<!-- NUMERO -->
								<div class="form-group">
									<label class="col-md-6 control-label">Pago indirecto</label>
									<div class="col-md-6">
										<p class="form-control-static">
										@if ($efector->compromiso->pago_indirecto == 'S')
										<span class="label label-success">SI</span>
										@else
										<span class="label label-warning">NO</span>
										@endif
										</p>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<!-- FECHA SUSCRIPCION -->
								<div class="form-group">
									<label class="col-md-6 control-label">Suscripción</label>
									<div class="col-md-6">
										<p class="form-control-static">{{ $efector->compromiso->fecha_suscripcion }}</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<!-- FECHA INICIO -->
								<div class="form-group">
									<label class="col-md-6 control-label">Inicio</label>
									<div class="col-md-6">
										<p class="form-control-static">{{ $efector->compromiso->fecha_inicio }}</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<!-- FECHA FIN -->
								<div class="form-group">
									<label class="col-md-6 control-label">Fin</label>
									<div class="col-md-6">
										<p class="form-control-static">{{ $efector->compromiso->fecha_fin }}</p>
									</div>
								</div>
							</div>
						</div>
					@endif
					@if (count($efector->emails))
					<h4>Direcciónes de correo electrónico</h4>
						<div class="row">
							<div class="col-md-6">
								<!-- EMAIL -->
								<div class="form-group">
									<label class="col-md-3 control-label">Correo</label>
									<div class="col-md-6">
										<p class="form-control-static">{{ $efector->emails->email }}</p>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<!-- EMAIL -->
								<div class="form-group">
									<label class="col-md-3 control-label">Observaciones</label>
									<div class="col-md-6">
										<p class="form-control-static">{{ $efector->emails->observaciones }}</p>
									</div>
								</div>
							</div>
						</div>
					@endif
					@if (count($efector->telefonos))
					<h4>Números de teléfono</h4>
						<div class="row">
							<div class="col-md-6">
								<!-- EMAIL -->
								<div class="form-group">
									<label class="col-md-3 control-label">Número</label>
									<div class="col-md-6">
										<p class="form-control-static">{{ $efector->telefonos->numero_telefono }}</p>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<!-- EMAIL -->
								<div class="form-group">
									<label class="col-md-3 control-label">Observaciones</label>
									<div class="col-md-6">
										<p class="form-control-static">{{ $efector->telefonos->observaciones }}</p>
									</div>
								</div>
							</div>
						</div>
					@else
					<div class="callout callout-warning">
                		<h4>Atención!</h4>
                		<p>No hay información de contacto telefónico de este esfector</p>
              		</div>
					@endif
					@if (count($efector->referente))
					<h4>Referente</h4>						
							<div class="row">
								<div class="col-md-12">
									<!-- NOMBRE -->
									<div class="form-group">
										<label class="col-md-1 control-label">Nombre</label>
										<div class="col-md-11">
											<p class="form-control-static">{{ $efector->referente->nombre }}</p>
										</div>
									</div>
								</div>
							</div>						
					@else
					<div class="callout callout-warning">
                		<h4>Atención!</h4>
                		<p>No hay referentes asociados a este esfector</p>
              		</div>
					@endif
					@if (count($efector->internet))
					<h4>Descentralización</h4>
						<div class="row">
							<div class="col-md-4">
								<!-- INTERNET -->
								<div class="form-group">
									<label class="col-md-3 control-label">Internet</label>
									<div class="col-md-6">
										<p class="form-control-static">{{ $efector->internet->internet }}</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<!-- FC -->
								<div class="form-group">
									<label class="col-md-4 control-label">Descentralizado</label>
									<div class="col-md-5">
										<p class="form-control-static">{{ $efector->internet->factura_descentralizada }}</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<!-- INTERNET -->
								<div class="form-group">
									<label class="col-md-3 control-label">On Line</label>
									<div class="col-md-6">
										<p class="form-control-static">{{ $efector->internet->factura_on_line }}</p>
									</div>
								</div>
							</div>
						</div>
					@else
					<div class="callout callout-danger">
                		<h4>Atención!</h4>
                		<p>No hay información de descentralización sobre este esfector</p>
              		</div>
					@endif
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