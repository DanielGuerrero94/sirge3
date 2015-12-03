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
				<div class="box-header with-border">
					<h2 class="box-title">Detalle de prestación</h2>
				</div>
				<div class="box-body">
					<div class="row">

						<div class="col-md-12">
							<div class="form-group">
								<label class="col-md-2">Descripción:</label>
								<div class="col-md-10">
									<p class="form-control-static">{{$codigo->descripcion_grupal}}</p>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-3">Grupos:</label>
								<div class="col-md-9">
									<p class="form-control-static">
										<ul class="list-unstyled">
											@foreach ($informacion['grupos'] as $grupo)
											<li><i class="fa fa-calendar text-info"></i> {{$grupo}}</li>
											@endforeach
										</ul>
									</p>
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-3">Atributos:</label>
								<div class="col-md-9">
									<p class="form-control-static">
										<ul class="list-unstyled">
											@if (isset($informacion['atributos']))
												@foreach($informacion['atributos'] as $grupo)
												<li><i class="fa fa-check text-info"></i> {{$grupo}}</li>
												@endforeach
											@endif
										</ul>
									</p>
								</div>
							</div>
						</div>

					</div>
					
					<div class="row">
						
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-3">Líneas:</label>
								<div class="col-md-9">
									<p class="form-control-static">
										<ul class="list-unstyled">
											@if (isset($informacion['lineas']))
												@foreach ($informacion['lineas'] as $grupo)
												<li><i class="fa fa-medkit text-info"></i> {{$grupo}}</li>
												@endforeach
											@endif
										</ul>
									</p>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-3">C.E.B.:</label>
								<div class="col-md-9">
									<p class="form-control-static">
										<ul class="list-unstyled">
											@if (isset($informacion['ceb']))
												@foreach ($informacion['ceb'] as $grupo)
												<li><i class="fa fa-users text-info"></i> {{$grupo}}</li>
												@endforeach
											@endif
										</ul>
									</p>
								</div>
							</div>
						</div>

					</div>
						
					<div class="row">

						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-3">O.D.P.:</label>
								<div class="col-md-9">
									<p class="form-control-static">
										<ul class="list-unstyled">
											@if (isset($informacion['odp']))
												@foreach ($informacion['odp'] as $key => $grupos)
													<li><i class="fa fa-tasks text-info"></i> {{$key}}</li>
													<ul style="list-style-type: none;">
														@foreach ($grupos as $grupo)
														<li><i class="fa fa-calendar text-primary"></i> {{$grupo}}</li>
														@endforeach
													</ul>
												@endforeach
											@endif
										</ul>
									</p>
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-3">Trazadoras:</label>
								<div class="col-md-9">
									<p class="form-control-static">
										<ul class="list-unstyled">
											@if (isset($informacion['trazadora']))
												@foreach ($informacion['trazadora'] as $key => $grupos)
													<li><i class="fa fa-line-chart text-info"></i> {{$key}}</li>
													<ul style="list-style-type: none;">
														@foreach ($grupos as $grupo)
														<li><i class="fa fa-calendar text-primary"></i> {{$grupo}}</li>
														@endforeach
													</ul>
												@endforeach
											@endif
										</ul>
									</p>
								</div>
							</div>
						</div>
					</div>
					<hr />
					<div class="row">
						<div class="col-md-6">
							<div class="g1" style="height: 300px;"></div>
						</div>
						<div class="col-md-6">
							<div class="g2" style="height: 300px;"></div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function(){

		$('.g1').highcharts({
			title: {
	            text: 'Evolución facturación',
	        },
	        xAxis: {
	            categories: {!! $meses !!}
	        },
	        yAxis: {
	            title: {
	                text: ''
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }],
	            labels : {
	            	enabled : true
	            }
	        },
	        legend: {
	            layout: 'horizontal',
	            align: 'center',
	            verticalAlign: 'bottom',
	            borderWidth: 0
	        },
	        series: {!! $series !!}
		});

		$('.g2').highcharts({
            series: [{
                type: "treemap",
                layoutAlgorithm: 'squarified',
                allowDrillToNode: true,
                dataLabels: {
                    enabled: false
                },
                levelIsConstant: false,
                levels: [{
                    level: 1,
                    dataLabels: {
                        enabled: true
                    },
                    borderWidth: 3
                }],
                data : {!! $distribucion !!},
                tooltip: {
                    pointFormatter : function(){
                        if (this.codigo_prestacion){
                            return this.texto_prestacion + ' : ' + Highcharts.numberFormat(this.value , '0');
                        } else {
                            return Highcharts.numberFormat(this.value , '0');
                        }
                    }
                },
                turboThreshold : 5000
            }],
            title : {
            	text : 'Distribución facturación'
            }
        });

	});
</script>
@endsection