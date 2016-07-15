<div class="row">	
	<div class="col-md-12">
		<form class="form-horizontal">		
			<div class="form-group">
				<div class="col-md-1">
				</div>
				<div class="col-md-10">
					<h4 class="form-control-static">{{ $data['titulo'] }}</h4>				
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-6 control-label">Entidad</label>
				<div class="col-md-6">
					<p class="form-control-static">{{ $data['entidad'] }}</p>
				</div>
			</div>			

			<div class="form-group">
				<label class="col-md-6 control-label">Beneficarios poblaci&oacute;n objetiva</label>
				<div class="col-md-6">
					<p class="form-control-static">{{ $data['beneficiarios_activos'] }}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-6 control-label">Beneficarios que cumplen</label>
				<div class="col-md-6">
					<p class="form-control-static">{{ $data['beneficiarios_ceb'] }}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-6 control-label">% Control prenatal cumplido</label>
				<div class="col-md-6">
					<p class="form-control-static">{{ $data['porcentaje_actual'] }}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-6 control-label">Periodo</label>
				<div class="col-md-6">
					<p class="form-control-static">{{ $data['periodo'] }}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-6 control-label">Evolución </label>
				<div class="btn-group col-md-6" data-toggle="tooltip" title="Desde esta opción podrá ver la evolución del último trimestre del O.D.P {{$data['indicador']}} a nivel nacional y regional" role="group">
					<button type="button" href="componentes-odp1-evolucion/{{$data['tipo']}}" class="detalle btn btn-info">Ver detalles</button>
				</div>		
			</div>
		</form>
	</div>	
</div>

<script type="text/javascript">
	$(document).ready(function(){

		$('.detalle').click(function(event){
		        event.preventDefault();
		        var modulo = $(this).attr('href');
		        $.get(modulo, function(data){
					$('.content-wrapper').html(data);
				});						
	    	});
	});
</script>
