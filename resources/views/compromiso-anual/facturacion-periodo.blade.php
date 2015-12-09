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
	      				<label for="periodo" class="col-sm-3 control-label">Período</label>
	  					<div class="col-sm-9">
	    					<input type="text" class="form-control" id="periodo" name="periodo">
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

	$('#periodo').inputmask({
		mask : '9999-99',
		placeholder : 'AAAA-MM'
	});

	$('.back').click(function(){
		$.get('compromiso-anual-16-descentralizacion' , function(data){
			$('.content-wrapper').html(data);
		});
	});

	$('.send').click(function(){
		$('form').validate({
			rules : {
				periodo : {
					required : true,
					minlength : 7,
					maxlength : 7
				}
			},
			submitHandler : function(form){
				
			}
		});
	});
</script>
@endsection