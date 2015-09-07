<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Nuevo Módulo</h2>
			</div>
			<div class="box-body">
				<form id="form-new-modulo">
					{!! csrf_field() !!}
					<!-- NOMBRE -->
					<div class="form-group">
						<label for="nombre">Nombre</label>
						<input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre...">
					</div>
					<!-- RUTA -->
					<div class="form-group">
						<label for="ruta">Ruta</label>
						<input type="text" id="ruta" name="ruta" class="form-control" placeholder="Ruta...">
					</div>
					<div class="row">
						<div class="col-md-6">
							<!-- ICONO -->
							<div class="form-group">
								<label for="icono">Icono</label>
								<input type="text" id="icono" name="icono" class="form-control" placeholder="Icono...">
							</div>
						</div>
						<div class="col-md-6">
							<!-- ARBOL -->
							<div class="form-group">
								<label for="arbol">Árbol</label>
								<select id="arbol" name="arbol" class="form-control">
									<option value="N">NO</option>
									<option value="S">SI</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<!-- ID PADRE -->
							<label for="id-padre">ID Padre</label>
							<input type="text" id="id-padre" name="id_padre" class="form-control" placeholder="ID padre...">
						</div>						
						<div class="col-md-4">
							<!-- NIVEL 1 -->
							<label for="nivel-i">Nivel 1</label>
							<input type="text" id="nivel-i" name="nivel_1" class="form-control" placeholder="Nivel 1...">
						</div>						
						<div class="col-md-4">
							<!-- NIVEL 2 -->
							<label for="nivel-ii">Nivel 2</label>
							<input type="text" id="nivel-ii" name="nivel_2" class="form-control" placeholder="Nivel 2...">
						</div>						
					</div>
					<div class="box-footer">
						<div class="btn-group" role="group">
						 	<button type="button" class="back btn btn-info">Atrás</button>
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
		$('.back').click(function(){
			$.get('modulos' , function(data){
				$('.content-wrapper').html(data);
			});
		});

		$('.save').click(function(){
			$('#form-new-modulo').validate({
				rules : {
					nombre : {
						required : true
					},
					icono : {
						required : {
							depends : function(element){
								return ($('#nivel-ii').val() == 0);
							}
						}
					},
					nivel_1 : {
						required : true,
						digits : true
					},
					nivel_2 : {
						required : true,
						digits : true
					},
					id_padre : {
						required : {
							depends : function(element){
								return ($('#nivel-ii').val() != 0);
							}
						}	
					}
				},
				submitHandler : function(form){
					$.post('new-modulo' , $(form).serialize() , function(data){
						$('#modal-text').html(data);
						$('.modal').modal();
						$('.modal').on('hidden.bs.modal' , function(e){
							$.get('modulos' , function(data){
								$('.content-wrapper').html(data);
							});	
						});
					});
				}
			})
		})
	});
</script>