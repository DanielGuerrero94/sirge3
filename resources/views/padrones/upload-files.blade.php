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

	/*$('#fileupload').bind('fileuploaddone', function (e, data) {					
		$.ajax({
				url : data.result.ruta_procesar + '/' + data.result.id_subida,
				dataType: 'json',
				success : function(data){					
					if(data.success == 'true'){
						var info = '';
						$.each(data.data , function (index , value){
							if(index != 'success'){
								info += 'REGISTROS ' + index.toUpperCase() + ' : ' + value + '<br />';	
							}							
						});
						$('body').removeClass("loading");
						$('#modal-text').html(info);
				        $('.modal').modal();
				        $('.modal').on('hidden.bs.modal', function (e) {				            
							$.get('listar-lotes/{{ $id_padron }}' , function(data){
								$('.content-wrapper').html(data);
							})							
				        });				        
				    }
				    else{
				    	$('#errores-form').html(data.errors);
						$('#errores-div').show();
				    }
				},
				error : function(data){
					$('#errores-form').html('<li>No se pudo abrir el archivo</li>');
					$('#errores-div').show();
				}
		});        						
	});*/

    $('#fileupload').fileupload({
        url: 'subir-padron',
        dataType: 'json',
        maxChunkSize: 800000000, 
        add: function(e, data) {
        	$('#errores-div').hide();
            var uploadErrors = [];
            var acceptFileTypes = /^text\/plain$/i;
        	
            if(data.originalFiles[0]['size'] > 1024 * 1024 * 1024 * 80) {
				uploadErrors.push('Tamaño de archivo demasiado grande. Máximo : 25mb');
            }

            if(data.originalFiles[0]['type'].length && !acceptFileTypes.test(data.originalFiles[0]['type'])) {
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

        		$.ajax({
        			method : 'post',
					url : 'nuevo-lote-' + data.result.nombre_padron + '/' + data.result.id_subida,					
					success : function(data){					
						if(data){							
							$('#modal-text').html(data.lote);
					        $('#modal-text').html("El número de lote asignado es " + data.lote + ". Presione CERRAR para ser redirigido a la sección Administracion De Lotes.");
					        $('.modal').modal();
					        $('.modal').on('hidden.bs.modal', function (e) {				            
								$.get('listar-lotes/{{ $id_padron }}' , function(data){
									$('.content-wrapper').html(data);
								})												
					        });					        
					    }
					    else{
					    	$('#errores-form').html(data.errors);
							$('#errores-div').show();
					    }
					},
					error : function(data){
						$('#errores-form').html('<li>No se pudo abrir el archivo</li>');
						$('#errores-div').show();
					}
				});      		        				            
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
});
</script>
@endsection