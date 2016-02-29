@extends('content')
@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Datos del beneficiario: {{ $beneficiario->nombre . ' ' . $beneficiario->apellido}}</h2>
			</div>
			<div class="box-body">
				<form class="form-horizontal">
					<h4>Información general</h4>
					<div class="row">
						<div class="col-md-12">
							<!-- NOMBRE -->
							<div class="form-group">
								<label class="col-md-2 control-label">Nombre</label>
								<div class="col-md-10">
									<p class="form-control-static">{{ $beneficiario->nombre }}</p>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
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
						<div class="col-md-4">
							<!-- DNI -->
							<div class="form-group">
								<label class="col-md-6 control-label">D.N.I</label>
								<div class="col-md-6">
									<p class="form-control-static">{{ $beneficiario->numero_documento }}</p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<!-- FECHA DE INSCRIPCION -->
							<div class="form-group">
								<label class="col-md-6 control-label">Inscripcion</label>
								<div class="col-md-6">
									<p class="form-control-static">{{ $beneficiario->fecha_inscripcion }}</p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<!-- EDAD INSCRIPCION -->
							<div class="form-group">
								<label class="col-md-8 control-label">Edad incripci&oacute;n</label>
								<div class="col-md-4">
									<p class="form-control-static">{{ ($beneficiario->edad_inscripcion == 1) ? $beneficiario->edad_inscripcion . ' año' : $beneficiario->edad_inscripcion . ' años' }}</p>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<!-- ACTIVO -->
							<div class="form-group">
								<label class="col-md-6 control-label">Activo</label>
								<div class="col-md-6">
									<p class="form-control-static">
										@if ($beneficiario->activo == 'S')
										<span class="label label-danger">NO</span>
										@else
										<span class="label label-success">SI</span>
										@endif
									</p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<!-- FECHA DE NACIMIENTO -->
							<div class="form-group">
								<label class="col-md-6 control-label">Nacimiento</label>
								<div class="col-md-6">
									<p class="form-control-static">{{ $beneficiario->fecha_nacimiento }}</p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<!-- EDAD -->
							<div class="form-group">
								<label class="col-md-8 control-label">Edad actual</label>
								<div class="col-md-4">
									<p class="form-control-static">{{ ($beneficiario->edad == 1) ? $beneficiario->edad . ' año' : $beneficiario->edad . ' años' }}</p>
								</div>
							</div>
						</div>
					</div>
					<h4>Domicilio</h4>
					<div class="row">
						<div class="col-md-12">						
							<!-- PROVINCIA -->
							<div class="form-group">
								<label class="col-md-2 control-label">Provincia</label>
								<div class="col-md-10">
									<p class="form-control-static">{{ $beneficiario->geo->provincia->descripcion or 'No se encontraron datos'}}</p>
								</div>
							</div>													
						</div>
					</div>
					<div class="row">						
						<div class="col-md-6">
							<!-- DEPARTAMENTO -->
							<div class="form-group">
								<label class="col-md-4 control-label">Departamento</label>
								<div class="col-md-8">
									<p class="form-control-static">{{ $beneficiario->geo->ndepartamento->nombre_departamento or 'No se encontraron datos'}}</p>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<!-- LOCALIDAD -->
							<div class="form-group">
								<label class="col-md-4 control-label">Localidad</label>
								<div class="col-md-8">
									<p class="form-control-static">{{ $beneficiario->geo->localidad->nombre_localidad or 'No se encontraron datos'}}</p>
								</div>
							</div>
						</div>
					</div>
					<div class="row">		
						<div class="col-md-12">
							<!-- CALLE -->
							<div class="form-group">
								<label class="col-md-2 control-label">Domicilio</label>
								<div class="col-md-10">
									<p class="form-control-static">{{ $beneficiario->geo->calle or 'No se encontraron datos'}}</p>
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
	<div class="col-md-4">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Historial: {{ $beneficiario->nombre . ' ' . $beneficiario->apellido}}</h2>
			</div>
			<div class="box-body">				
					<div id="scroll-historial-div">												
						<h4>Pr&aacute;cticas recibidas</h4>
						@if (count($beneficiario->susPrestaciones))
						<ul class="timeline">
							<!-- timeline time label -->
							<?php $fecha_anterior = ''; ?>
							@foreach ($beneficiario->susPrestaciones as $unaPrestacion)
							@if ($fecha_anterior != $unaPrestacion->fecha_prestacion)
							<li class="time-label">
								<span class="bg-red">
									{{ $unaPrestacion->fecha_prestacion }}<!--18/02/2007-->
								</span>
							</li>
							@endif
							<!-- /.timeline-label -->
							<!-- timeline item -->
							<li>
								<!-- timeline icon -->
								<i class="{{ (isset($unaPrestacion->datosPrestacion->TipoDePrestacion->icono) ? $unaPrestacion->datosPrestacion->TipoDePrestacion->icono : 'fa fa-minus-square-o bg-gray') }}"></i>
								<div class="timeline-item">
									<span class="time"><i class="fa fa-tag"></i> {{ $unaPrestacion->codigo_prestacion }} </span>
									<h3 class="timeline-header"><a href="#">{{ ($unaPrestacion->datosPrestacion->TipoDePrestacion != null ? $unaPrestacion->datosPrestacion->TipoDePrestacion->descripcion : 'PRESTACION ANTIGUA') }}</a></h3>
									<div class="timeline-body">
										<b><i>{{ mb_strtoupper($unaPrestacion->datosEfector->nombre) }} </i></b> <br> {{ ucfirst(mb_strtolower(($unaPrestacion->datosPrestacion->descripcion_grupal == null ? 'No hay datos' : $unaPrestacion->datosPrestacion->descripcion_grupal))) }}
									</div>
								</div>
							</li>
							<!-- END timeline item -->
							<?php $fecha_anterior =  $unaPrestacion->fecha_prestacion; ?>
							@endforeach
						</ul>
						@else
						<div class="callout callout-warning">
							<h4>Sin datos!</h4>
							<p>No hay prestaciones asociadas a este beneficiario</p>
						</div>
						@endif
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

		$('#scroll-historial-div').slimScroll({
	        height: '450px'
	    });

	});
</script>