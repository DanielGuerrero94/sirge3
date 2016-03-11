@extends('content')
@section('content')
<div class="row">
	<!-- <pre>{{print_r($objetos)}}</pre> -->
	@foreach ($objetos as $objeto)
		<div class="col-md-4">
			<div class="box box-info">
				<div class="box-header">
					<h2 class="box-title">C.E.I. {{$objeto->tipo}}</h2>
				</div>
				<div class="box-body">
					@foreach ($objeto->resultados as $resultado)
					<div class="row">
						<div class="col-md-12">
							<div class="info-box bg-{{$objeto->css}}">
				        	<span class="info-box-icon"><i class="fa {{$objeto->icon}}"></i></span>

				            <div class="info-box-content">
				        		<span class="info-box-text">Período: {{$resultado->periodo}} </span>
				             	<span class="info-box-number">{{$resultado->valor}}%</span>

				              	<div class="progress">
				                	<div class="progress-bar" style="width: {{$resultado->valor}}%"></div>
				              	</div>
				                <span style="text-align: right;" class="progress-description">
				                	<span><a style="color: white !important;" href="cei-reportes-download/{{$objeto->indicador}}/{{$resultado->periodo}}/{{$objeto->id_tipo}}"><i class="fa fa-cloud-download"></i></a></span>
				                </span>
				            </div>
				          </div>
						</div>
					</div>
					@endforeach
				</div>
				<div class="box-footer">
					<div class="btn-group" role="group">
						<button class="back btn btn-info">Atrás</button>
					</div>
				</div>
			</div>
		</div>
	@endforeach
</div>
<script type="text/javascript">
	$(document).ready(function(){
		
		$('.back').click(function(){
			$.get('cei-reportes' , function(data){
				$('.content-wrapper').html(data);
			})
		});

	})
</script>
@endsection