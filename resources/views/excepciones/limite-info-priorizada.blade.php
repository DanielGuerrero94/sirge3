@extends('content')
@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div id="action-container">
			<div class="box box-info">
				<div class="box-header">
					<h2 class="box-title">Estado de límite de declaración de ddjj de info priorizada</h2>
				</div>
				<form id="form-edit-limit">
					<div class="box-body">
					    <div class="alert alert-danger" id="errores-div">
					        <ul id="errores-form">
					        </ul>
					    </div>
						<!--- NOMBRE -->
						<div class="form-group">
							<label for="dia">Dia límite actual</label>
							<select id="dia" name="dia" class="form-control">
							@for ($i = 1; $i < 31; $i++)
								@if (isset($day) & $day == $i)
								<option value="{{ $day }}" selected>{{ $day }}</option>
								@else
								<option value="{{ $i }}">{{ $i }}</option>
								@endif
							@endfor							
							</select>														
						</div>

						<!--- EMAIL -->
						<div class="form-group">
							<label for="nombre">Fecha de hoy</label>
							<input class="form-control" type="text" name="fecha_actual" value="{{ date('Y-m-d') }}">
						</div>						
					</div>
					<div class="box-footer">
						<div class="btn-group" role="group">
							<button class="save btn btn-info">Guardar</button>							
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-info">
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
        <button type="button" class="btn btn-outline" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
	$(document).ready(function(){
		
		$('#errores-div').hide();

		$('.save').click(function(){
			$('#form-edit-limit').validate({
				rules : {
		            dia : {
		                required: true,
		                number: true		                
		            }
		        },
				submitHandler : function(form){
					
					console.log($(form).serialize());

					$.ajax({
						method : 'post',
						data : $(form).serialize(),
						url  : 'limite-info-priorizada',
						success : function(data){

							console.log(data);

							$('#errores-div').hide();
							
							if(data == 'ok'){
								$('#modal-text').html('Se han modificado los datos');
							}
							else{$('#modal-text').html('Ha habido un error en la modificacion de la fecha');}
							
							$('.modal').modal();

							$('.modal .modal-dialog button').on('click', function(){
								$.get('{{ $back }}' , function(data){
									$('.content-wrapper').html(data);
								});	
							})						
							
						}
					});
				}
			});
		});
	});
</script>
@endsection