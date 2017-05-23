@extends('content')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">
					Complete el formulario
				</h2>
			</div>
			<form id="form-new-request">
				<div class="box-body">
					<div class="alert alert-danger" id="errores-div">
				        <ul id="errores-form">
				        </ul>
				    </div>
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
						<div class="col-md-4">
							<div class="form-group">
								<label for="fecha">Fecha estimada de solución</label>
								<input class="form-control" type="text" name="fecha" id="fecha">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="prioridad">Prioridad</label>
								@include('common.select-prioridades')
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="ref">Reclamo asociado</label>
								<input class="form-control" type="number" name="ref" id="ref" data-toggle="tooltip" data-placement="left" title="Ingrese el número de reclamo anterior si la solución brindada no es satisfactoria">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="descripcion">Adjuntar documento </label> <small> (si se trata de más de un archivo comprimirlo en un .zip o .rar)</small>
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
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="descripcion">Descripción</label>
								<textarea style="height: 300px" class="form-control" name="descripcion" id="descripcion" data-toggle="tooltip" data-placement="top" title="Ingrese un detalle de su requerimiento. Por favor ser lo más específico posible."></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="box-footer">
					<div class="btn-group" role="group">
						<button class="save btn btn-info">Enviar requerimiento</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade modal-warning">
	<div class="modal-dialog">
		<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    			<h4 class="modal-title">Atención!!</h4>
      		</div>
  			<div class="modal-body">
        		<p>Recuerde aclarar los siguientes puntos</p>
        		<ul>
        			<li>Incluya fechas o períodos para realizar las búsquedas.</li>
        			<li>Sea claro en cuanto a la/s jurisdicciones a utilizar.</li>
        			<li>Si desea una búsqueda en base a códigos de prestacion, por favor sea claro, no ingrese códigos incompletos. Recuerde que sólo se aceptarán códigos y no los nombres de las prácticas.</li>
        			<li>Es de mucha ayuda para que nos de un ejemplo con los campos de salida que pretende.</li>
        			<li>No se aceptarán requerimientos que presenten ambigüedad en su descripción.</li>
        		</ul>
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
      		</div>
    	</div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
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


<!-- jQuery validator -->
<script src="{{ asset ("/dist/js/jquery.validate.min.js") }}"></script>
<!-- Inputmask jQuery -->
<script src="{{ asset ("/dist/js/jquery.inputmask.js") }}"></script>
<!-- Inputmask -->
<script src="{{ asset ("/dist/js/inputmask.js") }}"></script>
<!-- Datepicker -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
<!-- Locales -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/datepicker/locales/bootstrap-datepicker.es.js") }}"></script>
<script type="text/javascript">
	$(document).ready(function(){

		var id_adjunto = null;

		$('#errores-div').hide();
		$('#fecha').inputmask('99/99/9999');
		$('#fecha').datepicker({
			format: "dd/mm/yyyy",
			language: "es",
			daysOfWeekDisabled: "0,6",
			autoclose : true
		});

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

		$('#tipo-container').on('change' , '#tipo-solicitud' , function(){
			var s = $(this).val();
			if (s == 1){
				$('.modal-warning').modal();
			}
		})

		$('#fileupload').bind('fileuploadsubmit', function (e, data) {
			data.formData = {id_usuario : {{ $id_usuario }} }		
		});

	    $('#fileupload').fileupload({
	        url: 'attach-document',
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

	        		if(data.result.id_adjunto){
	        			id_adjunto = data.result.id_adjunto;
	        		}
	        		else{
	        			id_adjunto = null;	
	        		}
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

		$('.save').click(function(){
			$('#form-new-request').validate({
				rules : {
					grupo : {
						required : true
					},
					tipo_solicitud : {
						required : true
					},
					fecha : {
						required : true
					},
					prioridad : {
						required : true
					},
					descripcion : {
						required : true
					}

				},
				submitHandler : function(form){
					$.ajax({
						method : 'post',
						data : $(form).serialize() + '&id_adjunto='+id_adjunto,
						url : 'nueva-solicitud',
						success : function(data){
							$('#modal-text').html(data);
							$('.modal-info').modal();
							$('#form-new-request').trigger('reset');
							id_adjunto = null;																
						},
						error : function(data){
							var html = '';
							var e = JSON.parse(data.responseText);
							$.each(e , function (key , value){
								html += '<li>' + value[0] + '</li>';
							});
							id_adjunto = null;
							$('#errores-form').html(html);
							$('#errores-div').show();
						}
					})

					$.get('nueva-solicitud' , function(data){
			            $('.content-wrapper').html(data);
			        });
				}
			})
		});
	});
</script>
@endsection