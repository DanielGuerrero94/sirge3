<div class="row">	

	<div class="col-md-12">
		<form class="form-horizontal">					

			<div class="form-group">
				<label class="col-md-3 control-label">Titulo</label>
				<div class="col-md-9">					
					<p class="form-control-static">{{ $descripcion->titulo }}</p>					
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">Desafio</label>
				<div class="col-md-9">					
					<p class="form-control-static"> {!! $descripcion->desafio !!} 
					</p>					
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">{{ 'Propuesta de abordaje' }}</label>
				<div class="col-md-9">
					{!! $descripcion->propuesta !!}
				</div>
			</div>
			
		</form>
	</div>	

</div>
