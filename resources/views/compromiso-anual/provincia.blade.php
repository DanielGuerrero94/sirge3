@extends('content')
@section('content')
<div class="row">
	<form>
		<div class="col-md-12">
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
				</div>
				<div class="box-footer">
					<div class="btn-group" role="group">
						<button type="button" class="back btn btn-info">Atrás</button>
						<button class="send btn btn-info">Enviar</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">


	$('.back').click(function(){
		$.get('{{$back}}' , function(data){
			$('.content-wrapper').html(data);
		});
	});

	$('.send').click(function(){
		$('form').validate({
			rules : {
				provincia : {
					required : true
				}
			},
			submitHandler : function(form){
				$.get('{{$modulo}}/' + $('#provincia').val() , function(data){
					$('.content-wrapper').html(data);
				});
			}
		});
	});
</script>
@endsection