@extends('content')
@section('content')
<!--
	ATRIBUTOS
		ANEXO
		CATASTROFICO
		PRIORIZADO
		HOMBRE
		CCC
		ESTRATEGICO

	GRUPOS ETARIOS

	LINEAS DE CUIDADO
	
	MUJER
		EMBARAZO RIESGO
		EMBARAZO NORMAL

	CEB
		GRUPOS ETARIOS

	ODP
		Nº ODP

	TRAZADORA
		Nº TRAZADORA

-->

<div class="row">
	<form class="form-horizontal">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header">
					<h2 class="box-title">Detalle de prestación</h2>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-5">Descripción:</label>
								<div class="col-md-7">
									<p class="form-control-static">
										Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras quis dui elit.
									</p>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-5">C.E.B.:</label>
								<div class="col-md-7">
									<p class="form-control-static">
										<ul>
											<li>Enanos</li>
											<li>Mujeres</li>
											<li>Hombres topo</li>
										</ul>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

@endsection