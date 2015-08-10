<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Nuevo Menú</h2>
			</div>
			<div class="box-body">
				<form id="form-new-menu">
					{!! csrf_field() !!}
					<!-- NOMBRE -->
					<div class="form-group">
						<label for="nombre">Nombre</label>
						<input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre...">
					</div>
				</div>
				<div class="box-footer">
					<div class="btn-group " role="group">
					 	<button type="button" class="back btn btn-info">Atrás</button>
						<button type="button" class="save btn btn-info">Guardar</button>
					</div>
				</div>
			</form>
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
			$.get('menues' , function(data){
				$('.content-wrapper').html(data);
			});
		});

		$('.save').click(function(){
			$.post('new-menu' , $('#form-new-menu').serialize() , function(data){
				$('#modal-text').html(data);
				$('.modal').modal();
				$('.modal').on('hidden.bs.modal' , function(e){
					$.get('menues' , function(data){
						$('.content-wrapper').html(data);
					});	
				});
			});
		});
	});
</script>