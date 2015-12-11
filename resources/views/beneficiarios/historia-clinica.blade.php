@extends('content')
@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Historia Cl&iacute;nica del beneficiario: {{ $beneficiario->nombre . ' ' . $beneficiario->apellido}}</h2>
			</div>
			<div class="box-body">
				<form class="form-horizontal">
					<h4>Información general</h4>
					<div class="row">
						<div class="col-md-5">
							<!-- NOMBRE -->
							<div class="form-group">
								<label class="col-md-3 control-label">Nombre</label>
								<div class="col-md-9">
									<p class="form-control-static">{{ $beneficiario->nombre }}</p>
								</div>
							</div>
						</div>
						<div class="col-md-5">
							<!-- APELLIDO -->
							<div class="form-group">
								<label class="col-md-3 control-label">Apellido</label>
								<div class="col-md-9">
									<p class="form-control-static">{{ $beneficiario->apellido }}</p>
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
							<!-- DNI -->
							<div class="form-group">
								<label class="col-md-4 control-label">D.N.I</label>
								<div class="col-md-8">
									<p class="form-control-static">{{ $beneficiario->numero_documento }}</p>
								</div>
							</div>
						</div>
						<div class="col-md-5">
							<!-- FECHA DE NACIMIENTO -->
							<div class="form-group">
								<label class="col-md-8 control-label">Fecha de nacimiento</label>
								<div class="col-md-4">
									<p class="form-control-static">{{ $beneficiario->fecha_nacimiento }}</p>
								</div>
							</div>
						</div>
						<div class="col-md-5">
							<!-- FECHA DE INSCRIPCION -->
							<div class="form-group">
								<label class="col-md-8 control-label">Fecha de Inscripcion</label>
								<div class="col-md-4">
									<p class="form-control-static">{{ $beneficiario->fecha_inscripcion }}</p>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<!-- ACTIVO -->
							<div class="form-group">
								<label class="col-md-1 control-label">Activo</label>
								<div class="col-md-11">
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
								<label class="col-md-1 control-label">Domicilio</label>
								<div class="col-md-11">
									<p class="form-control-static">{{ $beneficiario->geo->calle }}</p>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<!-- CALLE -->
							<div class="form-group">
								<label class="col-md-4 control-label">Provincia</label>
								<div class="col-md-8">
									<p class="form-control-static">{{ $beneficiario->geo->provincia->descripcion }}</p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<!-- DEPARTAMENTO -->
							<div class="form-group">
								<label class="col-md-5 control-label">Departamento</label>
								<div class="col-md-7">
									<p class="form-control-static">{{ $beneficiario->geo->ndepartamento->nombre_departamento }}</p>
								</div>
							</div>
						</div>
						<div class="col-md-5">
							<!-- LOCALIDAD -->
							<div class="form-group">
								<label class="col-md-5 control-label">Localidad</label>
								<div class="col-md-7">
									<p class="form-control-static">{{ $beneficiario->geo->localidad->nombre_localidad }}</p>
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
				<h4>Pr&aacute;cticas recibidas</h4>
				<ul class="timeline">
					<!-- timeline time label -->
					<li class="time-label">
						<span class="bg-red">
							18/02/2007
						</span>
					</li>
					<!-- /.timeline-label -->
					<!-- timeline item -->
					<li>
						<!-- timeline icon -->
						<i class="fa fa-envelope bg-blue"></i>
						<div class="timeline-item">
							<span class="time"><i class="fa fa-clock-o"></i> CODIGO PRESTACION</span>
							<h3 class="timeline-header"><a href="#">Consulta</a></h3>
							<div class="timeline-body">
								<b><i>{{ mb_strtoupper("Hospital Posadas") }} </i></b> <br> Amputación de mano izquierda
							</div>							
						</div>
					</li>
					<!-- END timeline item -->					
					<li class="time-label">
						<span class="bg-red">
							17/02/2007
						</span>
					</li>
					<!-- /.timeline-label -->
					<!-- timeline item -->
					<li>
						<!-- timeline icon -->
						<i class="fa fa-envelope bg-blue"></i>
						<div class="timeline-item">
							<span class="time"><i class="fa fa-clock-o"></i> CODIGO PRESTACION</span>
							<h3 class="timeline-header"><a href="#">Laboratorio</a></h3>
							<div class="timeline-body">
								Vacuna quintuple (va por el orto)
							</div>
							<div class="timeline-footer">
								<a class="btn btn-primary btn-xs">Hospital Posadas</a>
							</div>
						</div>
					</li>
					<!-- END timeline item -->					
				</ul>
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