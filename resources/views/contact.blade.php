@extends('content')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-body">
				<div id="google_map" style="width:100%;height:380px; max-width: none; "></div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-body">
				<div class="row">
					<div class="col-md-6">
						<address>
							<strong>Programa SUMAR</strong><br>
							Av. 9 de Julio 1925<br>
							Ciudad Autónoma de Buenos Aires, CP C1073ACA <br>
							<abbr title="Tel"></abbr> (011) 4344-4300
						</address>
						
						<address>
							<strong>Email</strong><br>
							<a href="#">sirgeweb@gmail.com</a>
						</address>						
					</div>
					<div class="col-md-6">
						<form>
							<div class="form-group">
								<label for="nombre">Nombre</label>
								<input type="text" name="nombre" id="nombre" class="form-control" value="{{Auth::user()->nombre}}" readonly="readonly">
							</div>
							<div class="form-group">
								<label for="email">Email</label>
								<input type="text" name="email" id="email" class="form-control" value="{{Auth::user()->email}}" readonly="readonly">
							</div>
							<!-- <div class="form-group">
								<label for="cuerpo">Mensaje</label>
								<textarea class="form-control" name="cuerpo" id="cuerpo"></textarea>
							</div> -->
							<button class="submit btn btn-primary" style="margin-top: 3%;">Enviar una solicitud</button>
						</form>
					</div>
				</div>
			</div>
		</div>
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
		
		function initialize() {
	        var mapProp = {
	            scrollwheel: false,
	            center: new google.maps.LatLng(-34.612149, -58.381493),
	            zoom: 16,
	            mapTypeId: google.maps.MapTypeId.ROADMAP
	        };

	        var map = new google.maps.Map(document.getElementById("google_map"), mapProp);
	        var myLatlng = new google.maps.LatLng(-34.612149, -58.381493);

	        new google.maps.Marker({
	            map: map,
	            position: myLatlng,
	            title: 'Programa SUMAR'
	        });
	    }
    	initialize();

    	$('form').submit(function(e){
			
			e.preventDefault();

			$.get('nueva-solicitud' , function(data){
				$('.content-wrapper').html(data);
			});
	
    		/*$('form').validate({
    			rules : {
    				cuerpo : {
    					required : true,
    					minlength : 10
    				}
    			},
    			submitHandler : function(form){
    				$.post('contact' , $(form).serialize() , function(data){
    					$('#modal-text').html(data);
    					$('.modal').modal();
    					$('form').trigger('reset');
    				})
    			}
    		})*/

    	})

	});
</script>
@endsection