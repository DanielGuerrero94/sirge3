<div class="row">
	<form id="new-pass-form">
	    <div class="col-sm-8 col-sm-offset-2">
			<div class="box box-info">
				<div class="box-header">
					<h2 class="box-title">Ingrese una nueva contraseña</h2>
				</div>
				<div class="box-body">
				    <div class="form-group">
				    	<label>Contraseña</label>
				        <input type="password" name="pass" class="form-control" id="pass">
				        <div id="messages"></div>
			    	</div>
			    </div>
			    <div class="box-footer">
					<button class="change btn btn-danger">Cambiar contraseña</button>
			    </div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		
		$('#pass').pwstrength();

		$('.change').click(function(){
			/*
			$.post('new-password' , $('#new-pas-form') , function(data){
				$('#moda-text').html(data);
				$('.modal').modal();
			});
			*/
			$('#new-pass-form').validate({
				rules : {
					pass : {
						required : true
					}
				},
				submitHandler : function(form){
					$.post('new-password' , $('#new-pass-form').serialize() , function(data){
						$('#modal-text').html(data);
						$('.modal').modal();
					});
				}
			});
		});

	});
</script>
