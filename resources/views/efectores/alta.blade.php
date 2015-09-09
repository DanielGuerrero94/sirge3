@extends('content')
@section('content')
<style type="text/css">
.navi li{
    text-align: center;
    padding: 2px;
    width: 150px;
    display:inline-block;
}
</style>
<div class="row">
	<form id="alta-efector">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header">
					<h2 class="box-title">Complete todos los campos</h2>
				</div>
				<div class="box-body">
					<div id="rootwizard">
						<div class="navbar navbar-static-top">
							<div class="navbar-inner">
						    	<div class="container navi">
									<ul>
						  				<li><a href="#generales" data-toggle="tab">Generales</a></li>
										<li><a href="#domicilio" data-toggle="tab">Domicilio</a></li>
										<li><a href="#gestion" data-toggle="tab">Gestión</a></li>
										<li><a href="#convenio" data-toggle="tab">Convenio</a></li>
										<li><a href="#telefono" data-toggle="tab">Teléfono</a></li>
										<li><a href="#email" data-toggle="tab">Email</a></li>
										<li><a href="#referente" data-toggle="tab">Referente</a></li>
									</ul>
						 		</div>
						  	</div>
						</div>
						<div class="progress progress-xxs">
							<div class="progress-bar progress-bar-red" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<div class="tab-content">
						    <div class="tab-pane" id="generales">
						    	<div class="row">
						    		<div class="col-md-4">
										<div class="form-group">
		                      				<label for="cuie" class="col-sm-3 control-label">CUIE</label>
		                  					<div class="col-sm-9">
		                    					<input type="text" class="form-control" id="cuie" name="cuie" placeholder="999999">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="siisa" class="col-sm-3 control-label"><a href="efector-siisa" data-toggle="tooltip" data-placement="bottom" title="Haga click aquí si desea generar un código SIISA interno" ><u>SIISA</u></a></label>
		                  					<div class="col-sm-9">
		                    					<input type="text" class="form-control" id="siisa" name="siisa" placeholder="99999999999999">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="tipo" class="col-sm-2 control-label">Tipo</label>
		                  					<div class="col-sm-10">
		                    					<select class="form-control" id="tipo" name="tipo">
		                    						<option value="">Seleccione ...</option>
		                    						@foreach ($tipos as $tipo)
		                    						<option value="{{ $tipo->id_tipo_efector }}"> {{$tipo->descripcion}} </option>
		                    						@endforeach
		                    					</select>
		                  					</div>
		                    			</div>
						    		</div>
						    	</div>
						    	<br />
						    	<div class="row">
						    		<div class="col-md-6">
						    			<div class="form-group">
		                      				<label for="nombre" class="col-sm-2 control-label">Nombre</label>
		                  					<div class="col-sm-10">
		                    					<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre del efector ...">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-6">
						    			<div class="form-group">
		                      				<label for="legal" class="col-sm-4 control-label">Denominación legal</label>
		                  					<div class="col-sm-8">
		                    					<input type="text" class="form-control" id="legal" name="legal" placeholder="Denominación legal del efector ...">
		                  					</div>
		                    			</div>
						    		</div>
						    	</div>
						    	<br />
						    	<div class="row">
						    		<div class="col-md-6">
						    			<div class="form-group">
		                      				<label for="dep_adm" class="col-sm-5 control-label">Dependencia administrativa</label>
		                  					<div class="col-sm-7">
		                    					<select name="dep_adm" id="dep_adm" class="form-control">
		                    						<option value="">Seleccione ...</option>
		                    						@foreach($dependencias as $dependencia)
		                    						<option value="{{ $dependencia->id_dependencia_administrativa }}"> {{ $dependencia->descripcion }} </option>
		                    						@endforeach
		                    					</select>
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-6">
						    			<div class="form-group">
		                      				<label for="dep_san" class="col-sm-4 control-label">Dependencia sanitaria</label>
		                  					<div class="col-sm-8">
		                    					<input type="text" class="form-control" id="dep_san" name="dep_san" placeholder="Ingrese la dependencia sanitaria">
		                  					</div>
		                    			</div>
						    		</div>
						    	</div>
						    	<br />
						    	<div class="row">
						    		<div class="col-md-4">
						    			<div class="form-group">
							    			<label for="cics" class="col-sm-4 control-label">CICS</label>
							    			<div class="col-sm-8">
								    			<select id="cics" name="cics" class="form-control">
								    				<option value="">Seleccione...</option>
								    				<option value="S">SI</option>
								    				<option value="N">NO</option>
								    			</select>
							    			</div>
						    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
							    			<label for="rural" class="col-sm-4 control-label">Rural</label>
							    			<div class="col-sm-8">
								    			<select id="rural" name="rural" class="form-control">
								    				<option value="">Seleccione...</option>
								    				<option value="S">SI</option>
								    				<option value="N">NO</option>
								    			</select>
							    			</div>
						    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="categoria" class="col-sm-4 control-label">Categoría</label>
		                  					<div class="col-sm-8">
		                    					<select class="form-control" id="categoria" name="categoria">
		                    						<option value="">Seleccione ...</option>
		                    						@foreach($categorias as $categoria)
		                    						<option value="{{ $categoria->id_categorizacion }}"> {{ $categoria->descripcion }} </option>
		                    						@endforeach
		                    					</select>
		                  					</div>
		                    			</div>
						    		</div>
						    	</div>
						    	<br />
						    	<div class="row">
						    		<div class="col-md-4">
						    			<div class="form-group">
							    			<label for="integrante" class="col-sm-4 control-label">Integrante</label>
							    			<div class="col-sm-8">
								    			<select id="integrante" name="integrante" class="form-control">
								    				<option value="">Seleccione...</option>
								    				<option value="S">SI</option>
								    				<option value="N">NO</option>
								    			</select>
							    			</div>
						    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
							    			<label for="priorizado" class="col-sm-4 control-label">Priorizado</label>
							    			<div class="col-sm-8">
								    			<select id="priorizado" name="priorizado" class="form-control">
								    				<option value="">Seleccione...</option>
								    				<option value="S">SI</option>
								    				<option value="N">NO</option>
								    			</select>
							    			</div>
						    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
							    			<label for="compromiso" class="col-sm-7 control-label">Compromiso de gestión</label>
							    			<div class="col-sm-5">
								    			<select id="compromiso" name="compromiso" class="form-control">
								    				<option value="">Seleccione...</option>
								    				<option value="S">SI</option>
								    				<option value="N">NO</option>
								    			</select>
							    			</div>
						    			</div>
						    		</div>
						    	</div>
						    </div>
						    <div class="tab-pane" id="domicilio">
						    	<div class="row">
						    		<div class="col-md-12">
						    			<div class="form-group">
		                      				<label for="direccion" class="col-sm-1 control-label">Dirección</label>
		                  					<div class="col-sm-11">
		                    					<input type="text" class="form-control" id="direccion" name="direccion" placeholder="999999">
		                  					</div>
		                    			</div>
						    		</div>
						    	</div>
						    	<br />
						    	<div class="row">
						    		<div class="col-md-4">
						    			<div class="form-group">
							    			<label for="provincia" class="col-sm-3 control-label">Provincia</label>
							    			<div class="col-sm-9">
								    			<select id="provincia" name="provincia" class="form-control">
								    				<option value="">Seleccione ...</option>
								    				@foreach($provincias as $provincia)
								    				<option value=" {{ $provincia->id_provincia }} ">{{ $provincia->descripcion }}</option>
								    				@endforeach
								    			</select>
							    			</div>
						    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
							    			<label for="departamento" class="col-sm-4 control-label">Departamento</label>
							    			<div class="col-sm-8">
								    			<select name="departamento" id="departamento" class="form-control">
								    				<option value="">Seleccione ...</option>
								    			</select>
							    			</div>
						    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
							    			<label for="" class="col-sm-4 control-label">Localidad</label>
							    			<div class="col-sm-8">
								    			<select name="integrante" class="form-control">
								    				<option value="S">SI</option>
								    				<option value="N">NO</option>
								    			</select>
							    			</div>
						    			</div>
						    		</div>
						    	</div>
						    	<br />
						    	<div class="row">
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="" class="col-sm-3 control-label">C.P.</label>
		                  					<div class="col-sm-9">
		                    					<input type="text" class="form-control" id="" name="" placeholder="999999">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-8">
						    			<div class="form-group">
		                      				<label for="" class="col-sm-2 control-label">Ciudad</label>
		                  					<div class="col-sm-10">
		                    					<input type="text" class="form-control" id="" name="" placeholder="999999">
		                  					</div>
		                    			</div>
						    		</div>
						    	</div>
						    </div>
							<div class="tab-pane" id="gestion">
								<div class="row">
									<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="" class="col-sm-3 control-label">Número</label>
		                  					<div class="col-sm-9">
		                    					<input type="text" class="form-control" id="" name="" placeholder="999999">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="" class="col-sm-3 control-label">Firmante</label>
		                  					<div class="col-sm-9">
		                    					<input type="text" class="form-control" id="" name="" placeholder="999999">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
							    			<label for="" class="col-sm-6 control-label">Pago indirecto</label>
							    			<div class="col-sm-6">
								    			<select name="integrante" class="form-control">
								    				<option value="S">SI</option>
								    				<option value="N">NO</option>
								    			</select>
							    			</div>
						    			</div>
						    		</div>
								</div>
								<br />
						    	<div class="row">
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="" class="col-sm-3 control-label">Suscripción</label>
		                  					<div class="col-sm-9">
		                    					<input type="text" class="form-control" id="" name="" placeholder="999999">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="" class="col-sm-3 control-label">Inicio</label>
		                  					<div class="col-sm-9">
		                    					<input type="text" class="form-control" id="" name="" placeholder="999999">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="" class="col-sm-3 control-label">Fin</label>
		                  					<div class="col-sm-9">
		                    					<input type="text" class="form-control" id="" name="" placeholder="999999">
		                  					</div>
		                    			</div>
						    		</div>
						    	</div>
						    </div>
							<div class="tab-pane" id="convenio">
								<div class="row">
									<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="" class="col-sm-3 control-label">Número</label>
		                  					<div class="col-sm-9">
		                    					<input type="text" class="form-control" id="" name="" placeholder="999999">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="" class="col-sm-3 control-label">Firmante</label>
		                  					<div class="col-sm-9">
		                    					<input type="text" class="form-control" id="" name="" placeholder="999999">
		                  					</div>
		                    			</div>
						    		</div>
								</div>
								<br />
						    	<div class="row">
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="" class="col-sm-3 control-label">Suscripción</label>
		                  					<div class="col-sm-9">
		                    					<input type="text" class="form-control" id="" name="" placeholder="999999">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="" class="col-sm-3 control-label">Inicio</label>
		                  					<div class="col-sm-9">
		                    					<input type="text" class="form-control" id="" name="" placeholder="999999">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="" class="col-sm-3 control-label">Fin</label>
		                  					<div class="col-sm-9">
		                    					<input type="text" class="form-control" id="" name="" placeholder="999999">
		                  					</div>
		                    			</div>
						    		</div>
						    	</div>
						    	<br />
						    	<div class="row">
						    		<div class="col-md-6">
						    			<div class="form-group">
		                      				<label for="" class="col-sm-5 control-label">Código 3er. administrador</label>
		                  					<div class="col-sm-7">
		                    					<input type="text" class="form-control" id="" name="" placeholder="999999">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-6">
						    			<div class="form-group">
		                      				<label for="" class="col-sm-5 control-label">Nombre 3er. administrador</label>
		                  					<div class="col-sm-7">
		                    					<input type="text" class="form-control" id="" name="" placeholder="999999">
		                  					</div>
		                    			</div>
						    		</div>
						    	</div>
						    </div>
							<div class="tab-pane" id="telefono">
								<div class="row">
									<div class="col-md-6">
						    			<div class="form-group">
		                      				<label for="" class="col-sm-5 control-label">Teléfono</label>
		                  					<div class="col-sm-7">
		                    					<input type="text" class="form-control" id="" name="" placeholder="999999">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-6">
						    			<div class="form-group">
		                      				<label for="" class="col-sm-5 control-label">Observaciones</label>
		                  					<div class="col-sm-7">
		                    					<input type="text" class="form-control" id="" name="" placeholder="999999">
		                  					</div>
		                    			</div>
						    		</div>
								</div>
						    </div>
							<div class="tab-pane" id="email">
						    	<div class="row">
						    		<div class="col-md-6">
						    			<div class="form-group">
		                      				<label for="" class="col-sm-5 control-label">Email</label>
		                  					<div class="col-sm-7">
		                    					<input type="text" class="form-control" id="" name="" placeholder="999999">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-6">
						    			<div class="form-group">
		                      				<label for="" class="col-sm-5 control-label">Observaciones</label>
		                  					<div class="col-sm-7">
		                    					<input type="text" class="form-control" id="" name="" placeholder="999999">
		                  					</div>
		                    			</div>
						    		</div>
						    	</div>
						    </div>
							<div class="tab-pane" id="referente">
								<div class="row">
									<div class="col-md-12">
						    			<div class="form-group">
		                      				<label for="" class="col-sm-5 control-label">Referente</label>
		                  					<div class="col-sm-7">
		                    					<input type="text" class="form-control" id="" name="" placeholder="999999">
		                  					</div>
		                    			</div>
						    		</div>
								</div>
						    </div>
							<ul class="pager wizard">
								<li class="previous"><a href="javascript:;">Anterior</a></li>
							  	<li class="next"><a href="javascript:;">Siguiente</a></li>
							</ul>
						</div>	
					</div>
				</div>
				<div class="box-footer">
					<div class="btn-group " role="group">
					 	<button class="back btn btn-info">Cancelar alta</button>
					 	<button class="finish btn btn-warning">Solicitar alta</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$('.finish').hide();

	
	var $validator = $('form').validate({
		rules : {
			cuie : {
				required : true,
				minlength : 6,
				maxlength : 6
			},
			siisa : {
				required : true,
				digits : true,
				minlength : 14,
				maxlength : 14
			},
			tipo : {
				required : true
			},
			nombre : {
				required : true,
				minlength : 10,
				maxlength : 200
			},
			dep_adm : {
				required : true
			},
			cics : {
				required : true
			},
			rural : {
				required : true
			},
			categoria : {
				required : true
			},
			integrante : {
				required : true
			},
			priorizado : {
				required : true
			},
			compromiso : {
				required : true
			},
			direccion : {
				required : true,
				minlength : 15,
				maxlength : 500
			},
			provincia : {
				required : true
			},
			departamento : {
				required : true
			}

		}
	});
	

	$('.back').click(function(){
		$('form').trigger('reset');
	});

	$('#provincia').change(function(){
		var provincia = $(this).val();
		$.get('departamentos')
	});

  	$('#rootwizard').bootstrapWizard({
  		onTabShow: function(tab, navigation, index) {
			var $total = navigation.find('li').length;
			var $current = index+1;
			var $percent = ($current/$total) * 100;
			$('.progress-bar').css({width:$percent+'%'});

			if($current >= $total) {
				$('.finish').show()
			} else {
				$('.finish').hide()
			}

		},
		onTabClick : function(tab, navigation, index){
			return false;
		},
		onNext : function(tab, navigation, index){
			var $valid = $('form').valid();
  			if(!$valid) {
  				$validator.focusInvalid();
  				return false;
  			}
		}
	});
});
</script>
@endsection