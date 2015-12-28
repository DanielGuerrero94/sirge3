@extends('content')
@section('content')
<div class="row">
	<form>
		<div class="col-md-10 col-md-offset-1">
			<div class="box box-info">
				<div class="box-header">
					<h2 class="box-title">Ingrese motivo de reimpresión de DDJJ</h2>
				</div>
				<div class="box-body">
					<div class="alert alert-danger" id="errores-div">
				        <ul id="errores-form">
				        	<li>La DDJJ ya fue presentada en el período seleccionado. Si desea generarla nuevamente, ingrese el motivo. Gracias.</li>
				        </ul>
				    </div>
					<div class="form-group">
		  				<label for="motivo" class="col-sm-3 control-label">Motivo</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="motivo" name="motivo">
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

		$('.back').click(function(){
			$.get('{{ $ruta_back }}' , function(data){
				$('.content-wrapper').html(data);
			});
		});

		$('.action').click(function(){
			$('form').validate({
				rules : {
					motivo : {
						required : true,
						minlength : 7,
					}
				},
				submitHandler : function(form){
					$.post('ddjj-reimpresion/{{ $tipodj }}/{{ $periodo }}/{{ $version }}' , $(form).serialize() , function(data){
						$('.content-wrapper').html(data);
					});
				}
			});
		});
	});
</script>

@endsection