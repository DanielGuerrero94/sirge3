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
				        	<span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

				            <div class="info-box-content">
				        		<span class="info-box-text">Período: {{$resultado->periodo}} </span>
				             	<span class="info-box-number">{{$resultado->valor}}%</span>

				              	<div class="progress">
				                	<div class="progress-bar" style="width: {{$resultado->valor}}%"></div>
				              	</div>
				                <span class="progress-description">
				                	
				                </span>
				            </div>
				          </div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>
	@endforeach
</div>
<script type="text/javascript">
	$(document).ready(function(){

	})
</script>
@endsection