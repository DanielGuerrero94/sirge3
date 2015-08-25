@extends('content')
@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">
					Complete el formulario
				</h2>
			</div>
			<form id="form-new-request">
				<div class="box-body">
					<div class="row">
						<div class="col-md-6">
							<!--- SECTOR PARA SOLICITUD -->
							<div class="form-group">
								<label for="grupo">Seleccione hacia quien va dirigido su requrimiento</label>
								@include('common.select-sector-solicitud')
							</div>
						</div>
						<div class="col-md-6">
							<!--- TIPO DE SOLICITUD -->
							<div class="form-group" id="tipo-container">
								
							</div>
						</div>
					</div>
					<div class="row">
						
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">
					Listado de solicitudes ingresadas
				</h2>
			</div>
			<div class="box-body">
				
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){

		$('#grupo').change(function(){
			var g = $(this).val();
			if (g != 0){
				$.get('tipo-solicitud/' + g , function(data){
					$('#tipo-container').html(data);
				})
			} else {
				var html = '<div class="alert alert-warning">';
                    html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                    html += '<h4><i class="icon fa fa-warning"></i> Cuidado!</h4>';
                    html += 'Seleccione hacia quien va dirigido.';
                  	html += '</div>';
                $('#tipo-container').html(html);
			}
		});

	});
</script>
@endsection