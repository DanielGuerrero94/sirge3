<div class="row">

	@foreach ($data as $subindicador)

	<div class="col-md-6">
		<form class="form-horizontal">		
			<div class="form-group">
				<div class="col-md-1">
				</div>
				<div class="col-md-10">
					<h4 class="form-control-static">{{ Control Prenatal en embarazadas; //$subindicador['titulo'] }}</h4>				
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-7 control-label">Entidad</label>
				<div class="col-md-5">
					<p class="form-control-static">{{ Pa&iacute; //$subindicador['entidad'] }}</p>
				</div>
			</div>

			

			<div class="form-group">
				<label class="col-md-7 control-label">% Observado Actual</label>
				<div class="col-md-5">
					<p class="form-control-static">{{ $subindicador['beneficiarios_activos'] }}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-7 control-label">% Meta Anual</label>
				<div class="col-md-5">
					<p class="form-control-static">{{ $subindicador['beneficiarios_ceb'] }}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-7 control-label">Planificado Abril 2016</label>
				<div class="col-md-5">
					<p class="form-control-static">{{ $subindicador['porcentaje_actual'] }}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-7 control-label">Planificado Agosto 2016</label>
				<div class="col-md-5">
					<p class="form-control-static">{{ $subindicador['periodo'] }}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-7 control-label">Estado a&ntilde;o anterior</label>
				<div class="btn-group col-md-5" data-toggle="tooltip" title="Desde esta opción podrá ver el estado del último año del O.D.P 2 a nivel nacional y regional" role="group">
					<button type="button" href="componentes-odp2-evolucion/2" class="detalle btn btn-info">Ver detalles</button>
				</div>		
			</div>
		</form>
	</div>

	@endforeach

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
