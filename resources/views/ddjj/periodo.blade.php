@extends('content')
@section('content')
<div class="row">
	<form>
		<div class="col-md-10 col-md-offset-1">
			<div class="box box-info">
				<div class="box-header">
					<h2 class="box-title">Formulario DDJJ Información Priorizada</h2>
				</div>
				<div class="box-body">
					<div class="alert alert-danger" id="errores-div">
				        <ul id="errores-form">
				        </ul>
				    </div>
					<div class="form-group">
		  				<label for="periodo" class="col-sm-3 control-label">Período</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="periodo" name="periodo">
						</div>
					</div>
				</div>
				<div class="box-footer">
					<div class="btn-group" role="group">
						<button type="button" class="back btn btn-primary">Atrás</button>
						<button class="action btn btn-success">Ir a DDJJ</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function(){

		$('#errores-div').hide();

		$('#periodo').inputmask({
			mask : '9999-99',
			placeholder : 'AAAA-MM'
		});

		$('.back').click(function(){
			$.get('{{ $ruta_back }}' , function(data){
				$('.content-wrapper').html(data);
			});
		});

		$('.action').click(function(){
			$('form').validate({
				rules : {
					periodo : {
						required : true,
						minlength : 7,
						maxlength : 7
					}
				},
				submitHandler : function(form){
					$.ajax({
						url : 'check-periodo/{{ $tipodj }}/' + $('#periodo').val(),
						success : function(data){
							$('.content-wrapper').html(data);	
						},
						error : function(data){
							var html = '';
							var e = data.responseText;
							html += '<li>' + e + '</li>';
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