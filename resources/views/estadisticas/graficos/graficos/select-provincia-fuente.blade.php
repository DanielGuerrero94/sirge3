@extends('content')
@section('content')
<div class="row">
	<form>
		<div class="col-md-10 col-md-offset-1">
			<div class="box box-info">
				<div class="box-header">
					<h2 class="box-title">Ingrese los filtros necesarios</h2>
				</div>
				<div class="box-body">
					<div class="form-group">
	      				<label for="periodo" class="col-sm-3 control-label">Provincia</label>
	  					<div class="col-sm-9">
	    					<select name="provincia" id="provincia" class="form-control">
	    						@foreach ($provincias as $provincia)
	    						<option value="{{$provincia->id_provincia}}">{{$provincia->descripcion}}</option>
	    						@endforeach
	    					</select>
	  					</div>
	    			</div>
	    			<br />
	    			<div class="form-group">
	      				<label for="periodo" class="col-sm-3 control-label">Fuente de datos</label>
	  					<div class="col-sm-9">
	    					<select name="padron" id="padron" class="form-control">
	    						@foreach ($padrones as $padron)
	    						<option value="{{$padron->id_padron}}">{{$padron->descripcion}}</option>
	    						@endforeach
	    					</select>
	  					</div>
	    			</div>
				</div>
				<div class="box-footer">
					<div class="btn-group" role="group">
						<button type="button" class="back btn btn-info">Atrás</button>
						<button class="graficar btn btn-info">Graficar</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">

	$('#periodo').inputmask({
		mask : '9999-99',
		placeholder : 'AAAA-MM'
	});

	$('.back').click(function(){
		$.get('estadisticas-graficos' , function(data){
			$('.content-wrapper').html(data);
		});
	});

	$('.graficar').click(function(){

		var provincia = $('#provincia').val();
		var padron = $('#padron').val();

		$('form').validate({
			rules : {
				periodo : {
					required : true,
					minlength : 7,
					maxlength : 7
				}
			},
			submitHandler : function(form){
				$.get('estadisticas-graficos-pp/{{ $data->id }}/' + provincia + '/' + padron , function(data){
					$('.content-wrapper').html(data);
				});
			}
		});
	});
</script>
@endsection