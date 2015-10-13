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
<script type="text/javascript">
	$('.back').click(function(){
		$.get('padron/prestaciones/1' , function(data){
			$('.content-wrapper').html(data);
		})
	});

	$(function () {
    'use strict';
    $('#errores-div').hide();

    $('#fileupload').fileupload({
        url: 'subir-padron',
        formData : { id_padron : '1' },
        dataType: 'json',
        add: function(e, data) {
        	$('#errores-div').hide();
            var uploadErrors = [];
            var acceptFileTypes = /^text\/plain$/i;
        	
            if(data.originalFiles[0]['size'] > 25 * 1024 * 1024) {
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
        	console.log(data);
            $('<p/>').text('Se ha subido el archivo : ' + data.result.file).appendTo('#files');
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