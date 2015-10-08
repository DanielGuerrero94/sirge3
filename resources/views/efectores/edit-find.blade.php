@extends('content')
@section('content')
<style type="text/css">
.navi li{
    text-align: center;
    padding: 2px;
    width: 150px;
    display:inline-block;
}
</style>
<div class="row">
	<form id="baja-efector">
		<div class="col-md-10 col-md-offset-1">
			<div class="box box-warning">
				<div class="box-header">
					<h2 class="box-title">Ingrese el CUIE del efector a editar</h2>
				</div>
				<div class="box-body">
					<div class="alert alert-danger" id="errores-div">
				    </div>
					<div class="form-group">
          				<label for="cuie" class="col-sm-3 control-label">CUIE</label>
      					<div class="col-sm-9">
        					<input type="text" class="form-control" id="cuie" name="cuie" placeholder="999999">
      					</div>
        			</div>
				</div>
				<div class="box-footer">
					<div class="btn-group " role="group">
						<button class="search btn btn-warning">Editar</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
$(document).ready(function() {

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

	$('#errores-div').hide();

	$('.search').click(function(){
		$('#baja-efector').validate({
			rules : {
				cuie : {
					required : true,
					minlength : 6
				}
			},
			submitHandler : function(form){
				$.ajax({
					url : 'efectores-modificacion/' + $('#cuie').val(),
					success : function(data){
						$('.content-wrapper').html(data);
					},
					error : function(data){
						$('#errores-div').html(data.responseText);
						$('#errores-div').show();
					}
				});
			}
		})
	});
});
</script>
@endsection