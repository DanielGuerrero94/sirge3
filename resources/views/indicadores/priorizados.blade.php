@extends('content')
@section('content')
<div class="row">
	<form>
		<div class="col-md-8 col-md-offset-2">
			<div class="box box-info">
				<div class="box-header">
					<h2 class="box-title">Ingrese parámetros</h2>
				</div>
				<div class="box-body">
					<div class="form-group">
	      				<label for="provincia" class="col-sm-3 control-label">Provincia</label>
	  					<div class="col-sm-9">
	    					<select name="provincia" class="form-control" id="provincia">
	    						@foreach ($provincias as $provincia)
	    							<option value="{{$provincia->id_provincia}}">{{$provincia->descripcion}}</option>
	    						@endforeach
	    					</select>
	  					</div>
	    			</div>
	    			<br />
	    			<div class="form-group">
	      				<label for="provincia" class="col-sm-3 control-label">Indicador</label>
	  					<div class="col-sm-9">
	    					<select name="indicador" class="form-control" id="indicador">
	    						@foreach ($indicadores as $indicador)
	    							<option value="{{$indicador->indicador}}">{{$indicador->indicador . ' - ' . $indicador->descripcion}}</option>
	    						@endforeach
	    					</select>
	  					</div>
	    			</div>
	    			<div class="form-group">
	      				<label for="provincia" class="col-sm-3 control-label">{{htmlentities('Año')}}</label>
	  					<div class="col-sm-9">
	    					<select name="anio" class="form-control" id="anio">
	    						@foreach ($anios as $anio)
	    							<option value="{{$anio}}">{{$anio}}</option>
	    						@endforeach
	    					</select>
	  					</div>
	    			</div>
				</div>
				<div class="box-footer">
					<div class="btn-group" role="group">
						<button class="send btn btn-info">Ver</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">

	$('.send').click(function(){
		$('form').validate({
			rules : {
				provincia : {
					required : true
				},
				indicador : {
					required : true					
				},
				anio : {
					required : true					
				}
			},
			submitHandler : function(form){
				$.get('indicadores-efectores/' + $('#provincia').val() + '/' + $('#indicador').val() + '/' + $('#anio').val() + '/indicadores-efectores', function(data){
					$('.content-wrapper').html(data);
				});
			}
		});
	});
</script>
@endsection