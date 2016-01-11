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
	      				<label for="periodo" class="col-sm-3 control-label">Período</label>
	  					<div class="col-sm-9">
	    					<input type="text" class="form-control" id="periodo" name="periodo">
	  					</div>
	    			</div>
				</div>
				<div class="box-footer">
					<div class="btn-group" role="group">
						<button class="go btn btn-info">Ver resumen</button>
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

	$('.go').click(function(){
		$('form').validate({
			rules : {
				periodo : {
					required : true,
					minlength : 7,
					maxlength : 7
				}
			},
			submitHandler : function(form){
				$.get('prestaciones-resumen/' + $('#periodo').val() , function(data){
					$('.content-wrapper').html(data);
				});
			}
		});
	});
</script>
@endsection