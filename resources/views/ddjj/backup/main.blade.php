@extends('content')
@section('content')
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<form id="form-backup">
			<div class="box box-info">
				<div class="box-header">
					<h2 class="box-title">Ingrese los valores</h2>
				</div>
				<div class="box-body">
					<div class="alert alert-danger" id="errores-div">
				        <ul id="errores-form">
				        </ul>
				    </div>
					<div class="form-group">
		  				<label for="fecha" class="col-sm-7 control-label">Fecha en que se realizó el backup:</label>
						<div class="col-sm-5">
							<input type="text" class="form-control fecha" name="fecha">
						</div>
					</div>

					<div class="form-group">
						<label for="file" class="col-sm-7 control-label">Nombre del archivo que contiene el backup:</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="file">
						</div>
					</div>

				</div>
				<div class="box-footer">
					<div class="btn-group" role="group">
						<button type="button" class="back btn btn-primary">Atrás</button>
						<button class="action btn btn-warning">Generar DDJJ</button>
					</div>
				</div>
			</div>
		</form>
	</div>
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

		$('#errores-div').hide();

		$('.back').click(function(){
			$.get('{{$ruta_back}}' , function(data){
				$('.content-wrapper').html(data);
			});
		});

		$('.fecha').inputmask({
			mask : '99/99/9999',
			placeholder : 'dd/mm/aaaa'
		});

		$('.action').click(function(){

			$('#form-backup').validate({
				rules : {
					fecha : {
						required : true
					},
					file : {
						required : true
					}
				},
				submitHandler : function(form) {
					$.ajax({
						method : 'post',
						url : 'backup',
						data : $(form).serialize() + '&motivo={{ $motivo or '' }}&periodo={{ $periodo }}&version={{ $version }}',
						success : function(data){
							$('#modal-text').html(data);
							$('.modal').modal();
							$('form').trigger('reset');
						},
						error : function(data){
							var html = '';
							var e = JSON.parse(data.responseText);
							$.each(e , function (key , value){
								html += '<li>' + value[0] + '</li>';
							});
							$('#errores-form').html(html);
							$('#errores-div').show();
						}
					});
				}
			});
		});
	});
</script>
@endsection