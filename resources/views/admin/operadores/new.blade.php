<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Nuevo operador</h2>
			</div>
			<form id="form-new-operador">
				<div class="box-body">
					<!-- GRUPO -->
					<div class="form-group">
						<label for="grupo">Grupo</label>
						<select class="form-control" name="grupo">
							<option value="">Seleccione ...</option>
							<option value="1">SISTEMAS DE INFORMACIÓN</option>
							<option value="2">SOPORTE TÉCNICO E INFRAESTRUCTURA</option>
						</select>
					</div>

					<!-- OPERADOR -->
					<div class="form-group">
						<label for="operador">Usuario</label>
						<select class="form-control" name="operador">
							<option value="">Seleccione ...</option>
						@foreach ($usuarios as $u)
							<option value="{{ $u->id_usuario }}"> {{ $u->nombre }} </option>
						@endforeach
						</select>
					</div>
				</div>
				<div class="box-footer">
					<div class="btn-group " role="group">
					 	<button type="button" class="back btn btn-info">Atrás</button>
						<button class="save btn btn-info">Guardar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){

		$('.back').click(function(){
			$.get('operadores' , function(data){
				$('.content-wrapper').html(data);
			});
		});

		$('.save').click(function(){
			console.log('ok');
			$('#form-new-operador').validate({
				rules : {
					grupo : {
						required: true
					},
					operador : {
						required: true
					}
				},
				submitHandler : function(form){
					$.post('new-operador' , $(form).serialize() , function(data){
						$('#modal-text').html(data);
						$('.modal').modal();
						$('.modal').on('hidden.bs.modal' , function(e){
							$.get('operadores' , function(data){
								$('.content-wrapper').html(data);
							});
						});
						
					});
				}
			})

		});
	});
</script>