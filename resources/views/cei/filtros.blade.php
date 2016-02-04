@extends('content')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Ingrese los filtros necesarios</h2>
			</div>
			<div class="box-body">

				<div class="form-group">
      				<label for="periodo" class="col-sm-3 control-label">Período</label>
  					<div class="col-sm-9">
    					<input type="text" class="form-control" id="periodo" name="periodo">
  					</div>
    			</div>
    			<br />

    			<div class="form-group">
      				<label for="grupo_etario" class="col-sm-3 control-label">Grupo Etario</label>
  					<div class="col-sm-9">
    					<select id="grupo_etario" name="grupo_etario" class="form-control">
    						<option value="">Seleccione ...</option>
						@foreach ($grupos as $grupo)
							<option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
						@endforeach
						</select>
  					</div>
    			</div>
    			<br />

    			<div class="form-group">
      				<label for="linea_cuidado" class="col-sm-3 control-label">Línea de cuidado</label>
  					<div class="col-sm-9">
    					<select id="linea_cuidado" name="linea_cuidado" class="form-control">
    						<option value="">Seleccione ...</option>
    					</select>
  					</div>
    			</div>
    			<br />
    			
    			<!--
    			<div class="form-group">
      				<label for="provincia" class="col-sm-3 control-label">Jurisdicción</label>
  					<div class="col-sm-9">
    					<select id="provincia" name="provincia" class="form-control">
    						<option value="99">TODO EL PAÍS</option>
						@foreach ($provincias as $provincia)
							<option value="{{ $provincia->id_provincia }}">{{ $provincia->descripcion }}</option>
						@endforeach
						</select>
  					</div>
    			</div>
				-->

			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button class="submit btn btn-info">Ver resumen</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div id="cei-container"></div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){

		$('#periodo').inputmask({
			mask : '9999-99',
			placeholder : 'AAAA-MM'
		});


		$('#grupo_etario').change(function(){
			$.get('cei-lineas-cuidado/' + $(this).val() , function(data){
				var html = '';
				$.each(data , function(key , value){
					html += '<option indicador="' + value.id + '">';
					html += value.nombre;
					html += '</option>';
				});
				$('#linea_cuidado').html(html);
			});
		});

	});

	$('.submit').click(function(event){
		event.preventDefault();

		$('#cei-container').load('cei-resumen/2014-03/1');

	})
</script>

@endsection