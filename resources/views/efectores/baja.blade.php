@extends('content')
@section('content')
<div class="row">
	<form id="baja-efector">
		<div class="col-md-10 col-md-offset-1">
			<div class="box box-danger">
				<div class="box-header">
					<h2 class="box-title">Ingrese el CUIE del efector a dar de baja</h2>
				</div>
				<div class="box-body">
					<div class="form-group">
          				<label for="cuie" class="col-sm-3 control-label">CUIE</label>
      					<div class="col-sm-9">
        					<input type="text" class="form-control" id="cuie" name="cuie" placeholder="999999">
      					</div>
        			</div>
				</div>
				<div class="box-footer">
					<div class="btn-group " role="group">
						<button class="baja btn btn-danger">Solicitar baja</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="modal fade modal-info">
	<div class="modal-dialog">
		<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    			<h4 class="modal-title">Atención!</h4>
      		</div>
  			<div class="modal-body">
  				<p id="modal-text"></p>
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
      		</div>
    	</div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
	$(document).ready(function(){

		$('#cuie').typeahead({
	  		source : function (query , process) {
	  			$.get('cuie-busqueda/' + query , function(data){
					process (data);
	  			})
			} ,
			minLength : 2
		});

		$('#cuie').inputmask({
			mask : 'a99999',
			placeholder : ''
		});

		$('.baja').click(function(){
			$('form').validate({
				rules : {
					cuie : {
						required : true,
						minlength : 6,
						maxlength : 6
					}
				},
				submitHandler : function(form){
					$.post('efectores-baja' , $(form).serialize() , function(data){
						$('#modal-text').html(data);
						$('.modal').modal();
						$('form').trigger('reset');
					});
				}
			});
		});
	});
</script>
@endsection