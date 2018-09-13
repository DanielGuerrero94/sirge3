@extends('content')
@section('content')
<div class="row">
	<form id="form-modify-tablero">
		<div class="col-md-10 col-md-offset-1">
			<div class="box box-info">
				<div class="box-header">
					<h2 class="box-title">Edicion del indicador {{ $indicador->indicador }}</h2>
				</div>
				<div class="box-body">
					<div class="alert alert-danger" id="errores-div">
				        <ul id="errores-form">
				        </ul>
				    </div>

				    <div class="row" id="id">
			    		<div class="col-md-1">
							<div class="form-group">
				    			<div class="col-sm-9">
					    			<input type="text" name="id" class="form-control" id="id" value="{{ $indicador->id }}">
				    			</div>
			    			</div>
			    		</div>
			    	</div>
					<div class="row">
			    		<div class="col-md-4">
							<div class="form-group">
				    			<label for="provincia" class="col-sm-4 control-label">Provincia</label>
				    			<div class="col-sm-8">
					    			<select id="provincia" name="provincia" class="form-control">
					    				@foreach($provincias as $provincia)
					    						@if($provincia->id_provincia == $user->id_provincia)
					    						<option value="{{ $provincia->id_provincia }}" selected>{{ $provincia->descripcion }} </option>
					    						@else
					    						<option value="{{ $provincia->id_provincia }}" disabled>{{ $provincia->descripcion }} </option>
					    						@endif
					    				@endforeach
					    			</select>
				    			</div>
			    			</div>
			    		</div>
			    		<div class="col-md-3">
			    			<div class="form-group">
				    			<label for="indicador" class="col-sm-5 control-label">Indicador</label>
				    			<div class="col-sm-7">
					    			<input type="text" name="indicador" class="form-control" id="indicador" value="{{ $indicador->indicador}}" disabled>
				    			</div>
			    			</div>
			    		</div>
			    		<div class="col-md-4">
							<div class="form-group">
				    			<label for="periodo" class="col-sm-4 control-label">Periodo</label>
				    			<div class="col-sm-8">
					    			<input type="text" name="periodo" class="form-control" id="periodo" value="{{ $indicador->periodo }}" readonly>
				    			</div>
			    			</div>
			    		</div>

		    		</div>
			    	<br />
			    	<div class="row">
			    		<div class="col-md-4">
							<div class="form-group">
				    			<label for="numerador" class="col-sm-4 control-label">Numerador</label>
				    			<div class="col-sm-8">
					    			<input type="text" name="numerador" class="form-control" id="numerador" value="{{ $indicador->numerador }}">
				    			</div>
			    			</div>
			    		</div>
			    		<div class="col-md-4">
							<div class="form-group">
				    			<label for="denominador" class="col-sm-4 control-label">Denominador</label>
				    			<div class="col-sm-8">
					    			<input type="text" name="denominador" class="form-control" id="denominador" value="{{ $indicador->denominador }}">
				    			</div>
			    			</div>
			    		</div>
			    	</div>
				</div>
				<div class="box-footer">
					<div class="btn-group" role="group">
						<button type="button" class="back btn btn-primary">Atrás</button>
						<button class="action btn btn-success">Confirmar edicion</button>
					</div>
				</div>
			</div>
		</div>
	</form>
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

		function isValidDate(dateString) {
		  var regEx = /^\d{2}\/\d{2}\/\d{4}$/;
		  if(!dateString.match(regEx)) return false;  // Invalid format
		  var parts = dateString.split('/');
		  var correctDateString = parts[1].toString() + '/' + parts[0].toString() + '/' + parts[2].toString();
		  var d = new Date(correctDateString);
		  if(Number.isNaN(d.getTime())) return false; // Invalid date
		  var MyDateString = ('0' + d.getDate()).slice(-2) + '/'
             + ('0' + (d.getMonth()+1)).slice(-2) + '/'
             + d.getFullYear();
		  return MyDateString === dateString;
		}

		function hasNoWrongCharacters(value) {
		  var regEx = /^[0-9]+(\.[0-9]{1,3})?$/;
		  return value.match(regEx);
		}

		jQuery.validator.addMethod("valid_value", function(value, element) {
		  	if(  {{ in_array(str_replace(array("."), "|", $indicador->indicador),["5|1","5|3"]) ? "true" : "false" }} ){
		  		if( value ){
		  			return isValidDate(value.toString());
		  		}
		  		else{
			  		return true;
			  	}
		  	}
		  	else{
		  		if( value ){
		  			return hasNoWrongCharacters(value.toString());
		  		}
		  		else{
			  		return true;
			  	}
		  	}
		}, "Valor invalido");

		$('.back').click(function(){
			$.get('{{ $ruta_back }}' , function(data){
				$('.content-wrapper').html(data);
			});
		});

		$('#errores-div').hide();
		$('#id').hide();

		var $validator = $('form').validate({
			rules : {
				provincia : {
					required : true
				},
				indicador : {
					required : true
				},
				numerador: {
					valid_value : true
				},
				denominador: {
					valid_value : true
				}
			},
			messages : {
				provincia: {
					required: 'El campo provincia es obligatorio'
				},
				indicador: {
					required: 'El indicador es obligatorio'
				},
				numerador: {
					valid_date: 'Fecha invalida'
				},
				denominador: {
					valid_date: 'Fecha invalida'
				},
			},
			submitHandler : function(form){
				$('#compromiso').removeAttr('disabled');
				$.ajax({
					method : 'post',
					url : 'tablero-modificar-indicador',
					data : $(form).serialize(),
					success : function(data){
						$('#modal-text').html(data);
						$('.modal').modal();
						$('.modal').on('hidden.bs.modal', function (e) {
							$.get('tablero-modificar-indicador/{{$indicador->id}}' , function(data){
								$('.content-wrapper').html(data);
							});
						});
					},
					error : function(data){
						var html = '';
						var e = JSON.parse(data.responseText);
						$.each(e , function (key , value){
							html += '<li>' + value[0] + '</li>';
						});
						$('#errores-form').html(html);
						$('#errores-div').show();
					}
				})
			}
		});

		$('#action').click(function(){
			$('#form-modify-tablero').submit();
		});
	});
</script>

@endsection