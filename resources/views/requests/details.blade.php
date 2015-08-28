<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Requerimiento Nº : <b>{{ $solicitud->id }}</b></h2>
			</div>
			<div class="box-body">
				<form class="form-horizontal">
					<div class="form-group">
						<!-- ESTADO -->
						<label class="col-md-5 control-label">Estado de la solicitud : </label>
						<div class="col-md-7">
							<p class="form-control-static"><span class="label label-{{$solicitud->estados->css}}">{{ $solicitud->estados->descripcion }}</span></p>
						</div>

						<!-- SECTOR -->
						<label class="col-md-5 control-label">Sector responsable de resolución : </label>
						<div class="col-md-7">
							<p class="form-control-static">{{ $solicitud->tipos->grupos->descripcion }}</span></p>
						</div>

						<!-- TIPO -->
						<label class="col-md-5 control-label">Tipo de solicitud : </label>
						<div class="col-md-7">
							<p class="form-control-static">
								{{ $solicitud->tipos->descripcion }}
							</p>
						</div>

						<!-- OPERADOR -->
						<label class="col-md-5 control-label">Operador responsable : </label>
						<div class="col-md-7">
							<p class="form-control-static">{!! $solicitud->operador->nombre or '<span class="label label-warning">NO ASIGNADO</span>' !!}</p>
						</div>

						<!-- PRIORIDAD -->
						<label class="col-md-5 control-label">Prioridad : </label>
						<div class="col-md-7">
							<p class="form-control-static">
								<span class="label label-{{$solicitud->prioridades->css}}">{{ $solicitud->prioridades->descripcion }}</span>
							</p>
						</div>

						<!-- FECHA ESTIMADA -->
						<label class="col-md-5 control-label">Fecha estimada de solución : </label>
						<div class="col-md-7">
							<p class="form-control-static">{{ date ('d M Y', strtotime($solicitud->fecha_solicitud)) }}</p>
						</div>

						<!-- DETALLE PROBLEMA -->
						<label class="col-md-5 control-label">Detalle requerimiento : </label>
						<div class="col-md-7">
							<p class="form-control-static">
								{{ $solicitud->descripcion_solicitud }}
							</p>
						</div>

						<!-- FECHA ASIGNACION -->
						<label class="col-md-5 control-label">Fecha de inicio de solución : </label>
						<div class="col-md-7">
							@if (is_null($solicitud->fecha_asignacion))
							<p class="form-control-static">
								<span class="label label-warning">ASIGNACIÓN PENDIENTE</span>
							</p>
							@else	
							<p class="form-control-static">{{ date ('d M Y', strtotime($solicitud->fecha_asignacion)) }}</p>
							@endif
						</div>

						<!-- FECHA SOLUCION -->
						<label class="col-md-5 control-label">Fecha de solución : </label>
						<div class="col-md-7">
							@if (is_null($solicitud->fecha_solucion))
							<p class="form-control-static">
								<span class="label label-danger">SOLUCIÓN PENDIENTE</span>
							</p>
							@else	
							<p class="form-control-static">{{ date ('d M Y', strtotime($solicitud->fecha_solucion)) }}</p>
							@endif
						</div>

						<!-- DETALLE SOLUCION -->
						<label class="col-md-5 control-label">Detalle solución : </label>
						<div class="col-md-7">
							<p class="form-control-static">
								{{ $solicitud->descripcion_solucion or 'REQUERIMIENTO PENDIENTE DE SOLUCIÓN' }}
							</p>
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
<script type="text/javascript">
	$(document).ready(function(){
		$('.back').click(function(){
			$.get('{{ $back }}' , function(data){
				$('.content-wrapper').html(data);
			});
		});
	});
</script>
