<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<form id="form-cierre-request">
			<div class="box box-danger">
				<div class="box-header">
					<h2 class="box-title"> Ingrese la solución al requerimiento Nº: <b>{{ $s->id }}</b></h2>
				</div>
				<div class="box-body">
					<div class="alert alert-danger" id="errores-div">
				        <ul id="errores-form">
				        </ul>
				    </div>
					<h3>Solicitud usuario</h3>
					<textarea style="width:100%;height:80px" readonly="readonly">{{ $s->descripcion_solicitud }}</textarea>
					<h3>Solución</h3>
					<textarea style="width:100%;height:80px" name="solucion"></textarea>
					<h3>Adjuntar archivo</h3>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">								
								<br>
								<span class="btn btn-success fileinput-button">
								<i class="glyphicon glyphicon-plus"></i>
								<span>Seleccionar archivo...</span>
									<!-- The file input field used as target for the file upload widget -->
									<input id="fileupload" type="file" name="file" multiple>
								</span>
								<br>
								<br>
								<!-- The global progress bar -->
								<div id="progress" class="progress">
									<div class="progress-bar progress-bar-success"></div>
								</div>
								<!-- The container for the uploaded files -->
								<div id="files" class="files"></div>
							</div>
						</div>
					</div>
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

	$('#errores-div').hide();
	
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
					$('.modal').on('hidden.bs.modal', function (e) {
						$.get('solicitudes-pendientes' , function(data){
				            $('.content-wrapper').html(data);
				        });
					});
				});
			}
		});
	});

	$('#fileupload').bind('fileuploadsubmit', function (e, data) {
		data.formData = {id_solicitud : {{ $s->id }} }		
	});

    $('#fileupload').fileupload({
        url: 'attach-document-cierre',
        dataType: 'json',
        maxChunkSize: 800000000, 
        add: function(e, data) {
        	$('#errores-div').hide();
            var uploadErrors = [];
            var notAcceptedFileTypes = /(dll)|(bin)|(bat)|(exe)|(deb)$/i;
        	
            if(data.originalFiles[0]['size'] > 1024 * 1024 * 1024 * 80) {
				uploadErrors.push('Tamaño de archivo demasiado grande. Máximo : 25mb');
            }

            if(data.originalFiles[0]['type'].length && notAcceptedFileTypes.test(data.originalFiles[0]['type'])) {
                uploadErrors.push('Tipo de archivo no aceptado.');
            }

            if(uploadErrors.length > 0) {
            	var html = '';
				$.each(uploadErrors , function (key , value){
					html += '<li>' + value + '</li>';
				});
				$('#errores-form').html(html);
				$('#errores-div').show();
            } else {
                data.submit();
            }
        },
        done: function (e, data) {        	
        	if(data.result.success == 'true'){
        		$('<p/>').text('Se ha subido el archivo : ' + data.result.file).appendTo('#files');
        	}
        	else if(data.result.success == 'false'){
        		$('#errores-form').html(data.result.errors);
				$('#errores-div').show();
        	}        	        	        	            
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }, 
        fail : function (e, data){        	
			var html = '<li>Ha ocurrido un error al subir el archivo</li>';
			$('#errores-form').html(html);
			$('#errores-div').show();
        }

    }).prop('disabled', !$.support.fileInput)
	        .parent().addClass($.support.fileInput ? undefined : 'disabled');
})
</script>