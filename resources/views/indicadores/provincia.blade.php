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
	      				<label for="periodo" class="col-sm-3 control-label">Período</label>
	  					<div class="col-sm-9">
	    					<input type="text" class="form-control" id="periodo" name="periodo">
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

	$('#periodo').inputmask({
		mask : '9999-99',
		placeholder : 'AAAA-MM'
	});

	$('.send').click(function(){
		$('form').validate({
			rules : {
				provincia : {
					required : true
				},
				periodo : {
					required : true,
					minlength : 7,
					maxlength : 7
				}
			},
			submitHandler : function(form){
				$.get('indicadores-medica/' + $('#provincia').val() + '/' + $('#periodo').val() + '/indicadores-medica', function(data){
					$('.content-wrapper').html(data);
				});
			}
		});
	});
</script>
@endsection