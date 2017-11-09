@extends('content')
@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Seleccione el archivo desde su ordenador</h2>
			</div>
			<div class="box-body">
				<div class="alert alert-danger" id="errores-div">
			        <ul id="errores-form">
			        </ul>
			    </div>
			    @if ($id_padron == 4)
			    <div class="form-group">
			    	<label for="codigos" class="col-sm-2 control-label">Obra Social</label>
			    	<div class="col-md-10">
				    	<select name="codigos" id="codigo_osp" class="form-control">
				    		<option value="0">Seleccione ...</option>
				    		@foreach ($obras as $obra)
				    			@if ($obra->id_provincia == Auth::user()->id_provincia || Auth::user()->id_entidad == 1)
				    				<option value="{{ $obra->codigo_osp }}">{{ $obra->descripcion->nombre }}</option>
				    			@else
				    				<option value="{{ $obra->codigo_osp }}" disabled="disabled">{{ $obra->descripcion->nombre }}</option>
				    			@endif
				    		@endforeach
				    	</select>
			    	</div>
			    </div>
			    @elseif ($id_padron == 6)
			    <div class="form-group">
			    	<label for="id_sss" class="col-sm-2 control-label">Nº</label>
			    	<div class="col-sm-10">
			    		<select name="id_sss" id="id_sss" class="form-control">
			    			<option value="0">Seleccione...</option>
			    			<option value="1">Archivo #1</option>
			    			<option value="2">Archivo #2</option>
			    			<option value="3">Archivo #3</option>
			    			<option value="4">Archivo #4</option>
			    			<option value="5">Archivo #5</option>
			    		</select>
			    	</div>
			    </div>
			    @endif
			    <br />
			    <br />
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
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button class="back btn btn-info">Atrás</button>
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
	$('.back').click(function(){
		$.get('padron/{{ $id_padron }}' , function(data){
			$('.content-wrapper').html(data);
		})
	});

	var modal_data = new Array();
    var modal_data_errors = new Array();
    var count = 0;
    var count_processed = 0;
    var count_errors = 0;
    var qt_files = 0;

	if({{$id_padron}} == 4){
		if({{Auth::user()->id_entidad}} != 1){
			$('#codigo_osp option:enabled').each(function (){
				$("#codigo_osp option[value='"+$(this).val()+"']").attr('selected', 'selected');
				$("#codigo_osp").trigger('change');
			});		
		}	
	}
	

	$('#codigo_osp').change(function(){
		$('#fileupload').removeAttr('disabled');
		$.get('check-periodo/' + $(this).val() , function(data){
			if (parseInt(data) == 1){
				$('#fileupload').attr('disabled' , 'disabled');
				$('#modal-text').html('Usted ya reportó el padrón para este mes.');
				$('.modal').modal();
			} else {
				$('#fileupload').removeAttr('disabled');
			}
		});
	});

	$('#id_sss').change(function(){
		$('#fileupload').removeAttr('disabled');
		$.get('check-sss/' + $(this).val() , function(data){
			if (parseInt(data) == 1){
				$('#fileupload').attr('disabled' , 'disabled');
				$('#modal-text').html('Usted ya reportó el padrón para este mes.');
				$('.modal').modal();
			} else {
				$('#fileupload').removeAttr('disabled');
			}
		});
	});

	$(function () {
    'use strict';
    $('#errores-div').hide();

    $('#fileupload').bind('fileuploadsubmit', function (e, data) {
		data.formData = {codigo_osp : $('#codigo_osp').val() , id_padron : {{ $id_padron }} , id_sss : $('#id_sss').val() }		
	});	

    $('#fileupload').fileupload({
        url: 'subir-padron',
        dataType: 'json',
        maxChunkSize: 800000000, 
        add: function(e, data) {
        	$('#errores-div').hide();
        	var uploadErrors = [];
            var acceptFileTypes = /^text\/plain$/i;            
            qt_files = data.originalFiles.length;

            if( ({{ $id_padron }} <= 3) && qt_files > 1){
            	uploadErrors.push('No se puede cargar múltiples archivos en este padron');
        	    var html = '';
				$.each(uploadErrors , function (key , value){
					html += '<li>' + value + '</li>';
				});
				$('#errores-form').html(html);
				$('#errores-div').show();
            }
            else{   
            	console.log("CANTIDAD DE ARCHIVOS: " + qt_files);         	
	        	for (var i = 0; i < qt_files; i++) {   
	        		console.log("ARCHIVO A PROCESAR: ");
	        		console.log(data.originalFiles[i]);
	        		if(data.originalFiles[i]['size'] > 1024 * 1024 * 1024 * 80) {
						uploadErrors.push('Tamaño de archivo demasiado grande. Máximo : 25mb');
		            }

		            if(data.originalFiles[i]['type'].length && !acceptFileTypes.test(data.originalFiles[i]['type'])) {
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
	        	}
        	}                    	           
        },
        done: function (e, data) {
        		console.log("DONE - DATA RESPUESTA EN ARCHIVO: ");         	           	
        		if(data.result.success == 'true'){
	        		$('<p/>').text('Se ha subido el archivo : ' + data.result.file).appendTo('#files');		        							
	        		$.ajax({
	        			method : 'post',
						url : 'nuevo-lote-' + data.result.nombre_padron + '/' + data.result.id_subida,					
						success : function(data){	
							console.log("NUEVO LOTE: " + data);							
							if(data){
								if(qt_files == 1){
									$('#modal-text').html(data);
							        $('#modal-text').html("Procesando lote(s) <b>" + data + "</b>. Presione CERRAR para ser redirigido a la sección Administracion de Lotes. El procesamiento finalizará cuando pase del estado PROCESANDO a PENDIENTE. <br /><br />Puede continuar utilizando SIRGe Web.");
							        $('.modal').modal();
							        $('.modal').on('hidden.bs.modal', function (e) {
							        	qt_files = 0;
										$.get('listar-lotes/{{ $id_padron }}' , function(data){
											$('.content-wrapper').html(data);
										});
							        });	

								}								
								else{
									modal_data.push(data);
									count_processed++;													        	
								}								
						    }
						    else{						    	
						    	modal_data_errors.push(data.errors);
						    	count_errors++;        						    	
						    }
						    

						    if(qt_files == (count_processed + count_errors)){

						    		console.log("VALORES:");
						    		console.log("SUBIDOS: " + count_processed + " EXITOS: " + count_processed + " ERRORES: " + count_errors);
						    		
						    		if(modal_data_errors.length > 0){
										console.log("ERRORES:");										
										$.each(modal_data_errors, function (index, error) {
											$('#errores-form').append('<p>' + error + '</p>');		
										});        			
										$('#errores-div').show();				
									}

									if(count_processed > 0 && count_errors == 0){
										console.log("NO EXISTEN ERRORES");								    		
								        $('#modal-text').html("Procesando lote(s) <b>" + modal_data.toString() + "</b>. Presione CERRAR para ser redirigido a la sección Administracion de Lotes. El procesamiento finalizará cuando pase del estado PROCESANDO a PENDIENTE. <br /><br />Puede continuar utilizando SIRGe Web.");
								        $('.modal').modal();
								        $('.modal').on('hidden.bs.modal', function (e) {
								        	modal_data_errors = [];
								        	modal_data = [];
								        	count_processed = 0;
								        	count_errors = 0;				            
											$.get('listar-lotes/{{ $id_padron }}' , function(data){
												$('.content-wrapper').html(data);
											});
								        });	
									}
									else if(count_processed > 0 && count_processed > 0){
										console.log("HAY PROCESADOS PERO TAMBIEN RECHAZOS");
							    		$('#modal-text').html(modal_data);
								        $('#modal-text').html("Procesando lote(s) <b>" + modal_data.toString() + "</b>.  Existen archivos rechazados. <br /><br />Puede continuar utilizando SIRGe Web.");
								        modal_data_errors = [];
								        modal_data = [];
								        count_processed = 0;
								        count_errors = 0;
								        $('.modal').modal();
									}
							}																				
						},
						error : function(data){
							$('#errores-form').html('<li>No se pudo abrir el archivo</li>');
							$('#errores-div').show();
							count_errors++;
						}
					});
					count++;      		        				            
	        	}
	        	else if(data.result.success == 'false'){
	        		console.log("SUCCESS: FALSE  " + data.result.errors);
	        		count_errors++;
			    	modal_data_errors.push(data.result.errors);	        		
	        	} 
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );                       
        },
        stop: function (data) {
        	if( count = count_processed +  count_errors){

        		console.log("STOP: NO HAGA NADA");							    		
	        	if(modal_data_errors.length == qt_files){
					console.log(modal_data_errors);
					$.each(modal_data_errors, function (index, error) {
						$('#errores-form').append('<p>' + error + '</p>');		
					});        			
					$('#errores-div').show();				
				}
				
				if(count_processed > 0 && count_errors == 0){
					console.log("STOP: NO HAY RECHAZOS");							    		
			        $('#modal-text').html("Procesando lote(s) <b>" + modal_data.toString() + "</b>. Presione CERRAR para ser redirigido a la sección Administracion de Lotes. El procesamiento finalizará cuando pase del estado PROCESANDO a PENDIENTE. <br /><br />Puede continuar utilizando SIRGe Web.");
			        $('.modal').modal();
			        $('.modal').on('hidden.bs.modal', function (e) {
			        	modal_data_errors = [];
			        	modal_data = [];
			        	count_processed = 0;
			        	count_errors = 0;				            
						$.get('listar-lotes/{{ $id_padron }}' , function(data){
							$('.content-wrapper').html(data);
						});
			        });	
				}
				else if(count_processed > 0 && count_processed > 0){
					console.log("STOP: HAY RECHAZOS");		    		
			        $('#modal-text').html("Procesando lote(s) <b>" + modal_data.toString() + "</b>.  Existen archivos rechazados. Por favor revise los errores detallados a continuación. <br /><br />Puede continuar utilizando SIRGe Web.");
			        modal_data_errors = [];
			        modal_data = [];
			        count_processed = 0;
			        count_errors = 0;
			        $('.modal').modal();
				}								
			}
        }
        , 
        fail : function (e, data){        	
			var html = '<li>Ha ocurrido un error al subir el archivo</li> <br />';
			$('#errores-form').html(html);
			$('#errores-div').show();
        }

    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>
@endsection