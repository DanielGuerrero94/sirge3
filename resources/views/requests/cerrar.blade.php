<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<form id="form-cierre-request">
			<div class="box box-danger">
				<div class="box-header">
					<h2 class="box-title"> Ingrese la solución al requerimiento Nº: <b>{{ $s->id }}</b></h2>
				</div>
				<div class="box-body">
					<h3>Solicitud usuario</h3>
					<textarea style="width:100%;height:80px" readonly="readonly">{{ $s->descripcion_solicitud }}</textarea>
					<h3>Solución</h3>
					<textarea style="width:100%;height:80px" name="solucion"></textarea>
				</div>
				<div class="box-footer">
					<div class="btn-group " role="group">
					 	<button type="button" class="back btn btn-info">Atrás</button>
						<button id-solicitud="{{ $s->id }}" class="save btn btn-danger">Cerrar</button>
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

	$('.back').click(function(){
		$.get('solicitudes-pendientes' , function(data){
            $('.content-wrapper').html(data);
        });
	})

	$('.save').click(function(){
		$('#form-cierre-request').validate({
			rules : {
				solucion : {
					required : true
				}
			},
			submitHandler : function(form){
				$.post('cerrar-solicitud/{{ $s->id }}' , $(form).serialize() , function(data){
					$('#modal-text').html(data);
					$('.modal').modal();
				});
			}
		});
	});
})
</script>