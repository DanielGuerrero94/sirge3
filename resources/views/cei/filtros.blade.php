@extends('content')
@section('content')
<div class="row">
	<form>
		<div class="col-md-4">
			@foreach ($periodos as $periodo)
			<div class="info-box {{$periodo->css}}">
        	<span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

            <div class="info-box-content">
        		<span class="info-box-text">Período: {{$periodo->periodo}}</span>
             	<span class="info-box-number">{{$periodo->r}}%</span>

              	<div class="progress">
                	<div class="progress-bar" style="width: {{$periodo->r}}%"></div>
              	</div>
                <span class="progress-description">
                	@if ($periodo->r != 100)
                		Calculando período ...
                	@else
                		Período completo
                	@endif
                </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          @endforeach
          
		</div>
		<div class="col-md-8">
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
						<button class="ver btn btn-info">Ver resumen</button>
						<button class="download btn btn-info">Descargar Información</button>
					</div>
				</div>
			</div>
		</div>
	</form>
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
					html += '<option value="' + value.id + '">';
					html += value.nombre;
					html += '</option>';
				});
				$('#linea_cuidado').html(html);
			});
		});

	});

	$('.ver').click(function(event){
		// event.preventDefault();


		$('form').validate({
			rules: {
				periodo: {
					required : true,
					minlength : 7,
					maxlength : 7
				},
				grupo_etario: {
					required: true
				},
				linea_cuidado: {
					required: true
				}
			},
			submitHandler : function(form){
				var periodo = $('#periodo').val();
				var linea = $('#linea_cuidado').val();
				$('#cei-container').load('cei-resumen/' + periodo + '/' + linea);
			}
		});



	})
</script>

@endsection