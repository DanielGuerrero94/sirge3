@extends('content')
@section('content')
<style type="text/css">
.navi li{
    text-align: center;
    font-size: 10px;
    padding: 2px;
    width: 108px;
    display:inline-block;
}
.error {
	color:red;
}
</style>
<div class="row">
	<form id="alta-efector">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-header">
					<h2 class="box-title">Edite los campos que desea modificar</h2>
				</div>
				<div class="box-body">
					<div class="alert alert-danger" id="errores-div">
				        <ul id="errores-form">
				        </ul>
				    </div>
					<div id="rootwizard">
						<div class="navbar navbar-static-top">
							<div class="navbar-inner">
						    	<div class="container navi">
									<ul>
						  				<li><a href="#generales" data-toggle="tab">Generales</a></li>
										<li><a href="#domicilio" data-toggle="tab">Domicilio</a></li>
										<li><a href="#gestion" data-toggle="tab">Compromiso</a></li>
										<li><a href="#convenio" data-toggle="tab">Convenio</a></li>
										<li><a href="#telefono" data-toggle="tab">Teléfono</a></li>
										<li><a href="#email" data-toggle="tab">Email</a></li>
										<li><a href="#referente" data-toggle="tab">Referente</a></li>
										<li><a href="#internet" data-toggle="tab">Descentralización</a></li>
										<li><a href="#ppac" data-toggle="tab">PPAC</a></li>
										<li><a href="#addendas" data-toggle="tab">Addendas</a></li>
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
		                    					<input type="text" readonly="readonly" class="form-control" id="cuie" name="cuie" value="{{ $efector->cuie }}" >
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="siisa" class="col-sm-3 control-label"><a class="siisa" href="siisa-nuevo" data-toggle="tooltip" data-placement="bottom" title="Haga click aquí si desea generar un código SIISA interno" ><u>SIISA</u></a></label>
		                  					<div class="col-sm-9">
		                    					<input type="text" class="form-control" id="siisa" name="siisa" value="{{ $efector->siisa }}">
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
		                    							@if ($efector->id_tipo_efector == $tipo->id_tipo_efector)
		                    								<option selected="selected" value="{{ $tipo->id_tipo_efector }}"> {{ $tipo->descripcion }} </option>
		                    							@else
		                    								<option value="{{ $tipo->id_tipo_efector }}"> {{ $tipo->descripcion }} </option>
		                    							@endif
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
		                    					<input type="text" class="form-control" id="nombre" name="nombre" value="{{ $efector->nombre }}">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-6">
						    			<div class="form-group">
		                      				<label for="legal" class="col-sm-4 control-label">Denominación legal</label>
		                  					<div class="col-sm-8">
		                    					<input type="text" class="form-control" id="legal" name="legal" value="{{ $efector->denominacion_legal }}">
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
		                    							@if ($efector->id_dependencia_administrativa == $dependencia->id_dependencia_administrativa)
		                    								<option selected="selected" value="{{ $dependencia->id_dependencia_administrativa }}"> {{ $dependencia->descripcion }} </option>
		                    							@else
		                    								<option value="{{ $dependencia->id_dependencia_administrativa }}"> {{ $dependencia->descripcion }} </option>
		                    							@endif
		                    						@endforeach
		                    					</select>
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-6">
						    			<div class="form-group">
		                      				<label for="dep_san" class="col-sm-4 control-label">Dependencia sanitaria</label>
		                  					<div class="col-sm-8">
		                    					<input type="text" class="form-control" id="dep_san" name="dep_san" value="{{ $efector->dependencia_sanitaria }}">
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
								    				@if ($efector->cics == 'S')
								    					<option selected="selected" value="S">SI</option>
								    					<option value="N">NO</option>
								    				@else
								    					<option value="S">SI</option>
								    					<option selected="selected" value="N">NO</option>
								    				@endif
								    			</select>
							    			</div>
						    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
							    			<label for="rural" class="col-sm-4 control-label">Rural</label>
							    			<div class="col-sm-8">
								    			<select id="rural" name="rural" class="form-control">
								    				@if ($efector->rural == 'S')
								    					<option selected="selected" value="S">SI</option>
								    					<option value="N">NO</option>
								    				@else
								    					<option value="S">SI</option>
								    					<option selected="selected" value="N">NO</option>
								    				@endif
								    			</select>
							    			</div>
						    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="categoria" class="col-sm-4 control-label">Categoría</label>
		                  					<div class="col-sm-8">
		                    					<select class="form-control" id="categoria" name="categoria">
		                    						<option value="">Seleccione...</option>
		                    						@foreach($categorias as $unaCategoria)
		                    							@if ($efector->id_categorizacion == $unaCategoria->id_categorizacion)
		                    								<option selected="selected" value="{{ $unaCategoria->id_categorizacion }}"> {{ $unaCategoria->descripcion }} </option>
		                    							@else
		                    								<option value="{{ $unaCategoria->id_categorizacion }}"> {{ $unaCategoria->descripcion }} </option>
		                    							@endif
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
								    			<select id="integrante" name="integrante" class="form-control" readonly>
								    				@if ($efector->integrante == 'S')
								    					<option selected="selected" value="S">SI</option>
								    					<option value="N">NO</option>
								    				@else
								    					<option value="S">SI</option>
								    					<option selected="selected" value="N">NO</option>
								    				@endif
								    			</select>
							    			</div>
						    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
							    			<label for="priorizado" class="col-sm-4 control-label">Priorizado</label>
							    			<div class="col-sm-8">
								    			<select id="priorizado" name="priorizado" class="form-control">
								    				@if ($efector->priorizado == 'S')
								    					<option selected="selected" value="S">SI</option>
								    					<option value="N">NO</option>
								    				@else
								    					<option value="S">SI</option>
								    					<option selected="selected" value="N">NO</option>
								    				@endif
								    			</select>
							    			</div>
						    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
							    			<label for="compromiso" class="col-sm-4 control-label">Compromiso</label>
							    			<div class="col-sm-8">
								    			<select id="compromiso" name="compromiso" class="form-control">
								    				<option value="">Seleccione ...</option>
								    				@if ($efector->compromiso_gestion == 'S')
								    					<option selected="selected" value="S">SI</option>
								    					<option value="N">NO</option>
								    				@else
								    					<option value="S">SI</option>
								    					<option selected="selected" value="N">NO</option>
								    				@endif
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
		                    					<input type="text" class="form-control" id="direccion" name="direccion" value="{{ $efector->domicilio }}">
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
							    					<option value="{{ $efector->geo->provincia->id_provincia }}">{{ $efector->geo->provincia->descripcion }}</option>
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
							    			<label for="localidad" class="col-sm-4 control-label">Localidad</label>
							    			<div class="col-sm-8">
								    			<select name="localidad" id="localidad" class="form-control">
								    				<option value="">Seleccione ...</option>
								    			</select>
							    			</div>
						    			</div>
						    		</div>
						    	</div>
						    	<br />
						    	<div class="row">
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="codigo_postal" class="col-sm-3 control-label">C.P.</label>
		                  					<div class="col-sm-9">
		                    					<input type="text" class="form-control" id="codigo_postal" name="codigo_postal" placeholder="XXX9999X" value="{{ $efector->codigo_postal or '' }}">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-8">
						    			<div class="form-group">
		                      				<label for="ciudad" class="col-sm-2 control-label">Ciudad</label>
		                  					<div class="col-sm-10">
		                    					<input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="..." value="{{ $efector->geo->ciudad or ''}}">
		                  					</div>
		                    			</div>
						    		</div>
						    	</div>
						    </div>
							<div class="tab-pane" id="gestion">
					    		<div class="row">
									<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="numero_compromiso" class="col-sm-3 control-label">Número</label>
		                  					<div class="col-sm-9">
		                    					<input type="text" class="form-control" id="numero_compromiso" name="numero_compromiso" value="{{ $efector->compromiso->numero_compromiso or ''}}" placeholder="999999">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="firmante_compromiso" class="col-sm-3 control-label">Firmante</label>
		                  					<div class="col-sm-9">
		                    					<input type="text" class="form-control" id="firmante_compromiso" name="firmante_compromiso" value="{{ $efector->compromiso->firmante or ''}}" placeholder="Ingrese firmante ...">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
							    			<label for="indirecto" class="col-sm-6 control-label">Pago indirecto</label>
							    			<div class="col-sm-6">
								    			<select id="indirecto" name="indirecto" class="form-control">
								    				<option value="">Seleccione...</option>
									    			@if (isset($efector->compromiso))
									    				@if($efector->compromiso->pago_indirecto == 'S')
										    				<option selected="selected" value="S">SI</option>
										    				<option value="N">NO</option>
										    			@else
										    				<option value="S">SI</option>
										    				<option selected="selected" value="N">NO</option>
										    			@endif
										    		@else
										    			<option value="S">SI</option>
										    			<option value="N">NO</option>
										    		@endif
								    			</select>
							    			</div>
						    			</div>
						    		</div>
								</div>
								<br />
						    	<div class="row">
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="compromiso_fsus" class="col-sm-3 control-label">Suscripción</label>
		                  					<div class="col-sm-9">
		                    					<input class="form-control" id="compromiso_fsus" name="compromiso_fsus" value="{{ $efector->compromiso->fecha_suscripcion or ''}}" placeholder="dd/mm/aaaa">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="compromiso_fini" class="col-sm-3 control-label">Inicio</label>
		                  					<div class="col-sm-9">
		                    					<input class="form-control" id="compromiso_fini" name="compromiso_fini" value="{{ $efector->compromiso->fecha_inicio or '' }}" placeholder="dd/mm/aaaa">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="compromiso_ffin" class="col-sm-3 control-label">Fin</label>
		                  					<div class="col-sm-9">
		                    					<input class="form-control" id="compromiso_ffin" name="compromiso_ffin" value="{{ $efector->compromiso->fecha_fin or '' }}" placeholder="dd/mm/aaaa">
		                  					</div>
		                    			</div>
						    		</div>
						    	</div>
						    </div>
							<div class="tab-pane" id="convenio">
								<div class="row">
									<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="convenio_numero" class="col-sm-3 control-label">Número</label>
		                  					<div class="col-sm-9">
		                    					<input type="text" class="form-control" id="convenio_numero" name="convenio_numero" placeholder="999999" value="{{ $efector->convenio->numero_compromiso or ''}}">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="convenio_firmante" class="col-sm-3 control-label">Firmante</label>
		                  					<div class="col-sm-9">
		                    					<input type="text" class="form-control" id="convenio_firmante" name="convenio_firmante" placeholder="Ingrese firmante ..." value="{{ $efector->convenio->firmante or ''}}">
		                  					</div>
		                    			</div>
						    		</div>
								</div>
								<br />
						    	<div class="row">
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="convenio_fsus" class="col-sm-3 control-label">Suscripción</label>
		                  					<div class="col-sm-9">
		                    					<input class="form-control" id="convenio_fsus" name="convenio_fsus" placeholder="dd/mm/aaaa" value="{{ $efector->convenio->fecha_suscripcion or ''}}">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="convenio_fini" class="col-sm-3 control-label">Inicio</label>
		                  					<div class="col-sm-9">
		                    					<input class="form-control" id="convenio_fini" name="convenio_fini" placeholder="dd/mm/aaaa" value="{{ $efector->convenio->fecha_inicio or ''}}">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="convenio_ffin" class="col-sm-3 control-label">Fin</label>
		                  					<div class="col-sm-9">
		                    					<input class="form-control" id="convenio_ffin" name="convenio_ffin" placeholder="dd/mm/aaaa" value="{{ $efector->convenio->fecha_fin or ''}}">
		                  					</div>
		                    			</div>
						    		</div>
						    	</div>
						    	<br />
						    	<div class="row">
						    		<div class="col-md-6">
						    			<div class="form-group">
		                      				<label for="cuie_admin" class="col-sm-5 control-label">Código 3er. administrador</label>
		                  					<div class="col-sm-7">
		                    					<input type="text" class="form-control" id="cuie_admin" name="cuie_admin" placeholder="999999" value="{{ $efector->convenio->codigo_tercer_administrador or ''}}">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-6">
						    			<div class="form-group">
		                      				<label for="nombre_admin" class="col-sm-5 control-label">Nombre 3er. administrador</label>
		                  					<div class="col-sm-7">
		                    					<input type="text" class="form-control" id="nombre_admin" name="nombre_admin" placeholder="..." value="{{ $efector->convenio->nombre_tercer_administrador or ''}}">
		                  					</div>
		                    			</div>
						    		</div>
						    	</div>
						    </div>
							<div class="tab-pane" id="telefono">
								<div class="row">
									<div class="col-md-6">
						    			<div class="form-group">
		                      				<label for="tel" class="col-sm-5 control-label">Teléfono</label>
		                  					<div class="col-sm-7">
		                    					<input type="text" class="form-control" id="tel" name="tel" value="{{ $efector->telefonos->numero_telefono or '' }}" >
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-6">
						    			<div class="form-group">
		                      				<label for="obs_tel" class="col-sm-5 control-label">Observaciones</label>
		                  					<div class="col-sm-7">
		                    					<input type="text" class="form-control" id="obs_tel" name="obs_tel" value="{{ $efector->telefonos->observaciones or '' }}" placeholder="Observaciones ...">
		                  					</div>
		                    			</div>
						    		</div>
								</div>
						    </div>
							<div class="tab-pane" id="email">
						    	<div class="row">
						    		<div class="col-md-6">
						    			<div class="form-group">
		                      				<label for="correo" class="col-sm-5 control-label">Email</label>
		                  					<div class="col-sm-7">
		                    					<input type="email" class="form-control" id="correo" name="correo" placeholder="efector@sirgeweb.com.ar" value="{{ $efector->emails->email or '' }}">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-6">
						    			<div class="form-group">
		                      				<label for="obs_correo" class="col-sm-5 control-label">Observaciones</label>
		                  					<div class="col-sm-7">
		                    					<input type="text" class="form-control" id="obs_correo" name="obs_correo" placeholder="Observaciones ..." value="{{ $efector->emails->observaciones or '' }}" >
		                  					</div>
		                    			</div>
						    		</div>
						    	</div>
						    </div>
							<div class="tab-pane" id="referente">
								<div class="row">
									<div class="col-md-12">
						    			<div class="form-group">
		                      				<label for="refer" class="col-sm-5 control-label">Referente</label>
		                  					<div class="col-sm-7">
		                    					<input type="text" class="form-control" id="refer" name="refer" placeholder="Ingrese un contacto con el efector ..." value="{{ $efector->referente->nombre or ''}}">
		                  					</div>
		                    			</div>
						    		</div>
								</div>
						    </div>
						    <div class="tab-pane" id="internet">
						    	<div class="row">
						    		<div class="col-md-4">
						    			<label for="internet-efector" class="col-sm-6 control-label">Internet</label>
						    			<div class="col-sm-6">
							    			<select id="internet-efector" name="internet_efector" class="form-control">
							    			@if (isset($efector->internet))
							    				@if($efector->internet->internet == 'S')
								    				<option selected="selected" value="S">SI</option>
								    				<option value="N">NO</option>
								    			@else
								    				<option value="S">SI</option>
								    				<option selected="selected" value="N">NO</option>
								    			@endif								    		
								    		@else 
								    			<option name="internet_efector" value="S">SI</option>
							    				<option name="internet_efector" value="N">NO</option>
								    		@endif
							    			</select>
						    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<label for="factura_descentralizada" class="col-sm-7 control-label">Factura descentralizada</label>
						    			<div class="col-sm-5">
							    			<select id="factura_descentralizada" name="factura_descentralizada" class="form-control">
							    			@if (isset($efector->internet))
							    				@if($efector->internet->factura_descentralizada == 'S')
								    				<option selected="selected" value="S">SI</option>
								    				<option value="N">NO</option>
								    			@else
								    				<option value="S">SI</option>
								    				<option selected="selected" value="N">NO</option>
								    			@endif								    		
								    		@else 
								    			<option name="factura_descentralizada" value="S">SI</option>
							    				<option name="factura_descentralizada" value="N">NO</option>
								    		@endif
							    			</select>
						    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<label for="factura_on_line" class="col-sm-6 control-label">Factura Online</label>
						    			<div class="col-sm-6">
							    			<select id="factura_on_line" name="factura_on_line" class="form-control">
							    			@if (isset($efector->internet))
							    				@if($efector->internet->factura_on_line == 'S')
								    				<option selected="selected" value="S">SI</option>
								    				<option value="N">NO</option>
								    			@else
								    				<option value="S">SI</option>
								    				<option selected="selected" value="N">NO</option>
								    			@endif								    		
								    		@else 
								    			<option name="factura_on_line" value="S">SI</option>
							    				<option name="factura_on_line" value="N">NO</option>
								    		@endif
							    			</select>
						    			</div>
						    		</div>
						    	</div>
						    </div>
						    <div class="tab-pane" id="ppac">
						    @if(isset($efector->perinatal))
						    	<div class="row">
						    		<div class="col-md-4">
						    			<label for="addenda_perinatal" class="col-sm-6 control-label">Addenda Perinatal</label>
						    			<div class="col-sm-6">
							    			<select id="addenda_perinatal" name="addenda_perinatal" class="form-control">
						    				@if($efector->perinatal->addenda_perinatal == 'S')
							    				<option selected="selected" value="S">SI</option>
							    				<option value="N">NO</option>
							    			@else
							    				<option value="S">SI</option>
							    				<option selected="selected" value="N">NO</option>
							    			@endif
							    			</select>
						    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="fecha_addenda_perinatal" class="col-sm-5 control-label">Fecha Addenda Perinatal</label>
		                  					<div class="col-sm-7">
		                    					<input class="form-control" id="fecha_addenda_perinatal" name="fecha_addenda_perinatal" value="{{ $efector->perinatal->fecha_addenda_perinatal or ''}}" placeholder="dd/mm/aaaa">
		                  					</div>
		                    			</div>		                    			
						    		</div>
						    		<div class="col-md-4">
						    			<label for="internet-efector" class="col-sm-6 control-label">Perinatal AC</label>
						    			<div class="col-sm-6">
							    			<select id="internet-efector" name="internet-efector" class="form-control">
						    				@if($efector->perinatal->perinatal_ac == 'S')
							    				<option selected="selected" value="S">SI</option>
							    				<option value="N">NO</option>
							    			@else
							    				<option value="S">SI</option>
							    				<option selected="selected" value="N">NO</option>
							    			@endif
							    			</select>
						    			</div>
						    		</div>
						    	</div>
						    @else
						    	<div class="row">
						    		<div class="col-md-4">
						    			<label for="addenda_perinatal" class="col-sm-6 control-label">Addenda Perinatal</label>
						    			<div class="col-sm-6">
							    			<select id="addenda_perinatal" name="addenda_perinatal" class="form-control">
							    				<option value="">Seleccione...</option>
							    				<option value="S">SI</option>
							    				<option value="N">NO</option>
							    			</select>
						    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<div class="form-group">
		                      				<label for="fecha_addenda_perinatal" class="col-sm-5 control-label">Fecha Addenda Perinatal</label>
		                  					<div class="col-sm-7">
		                    					<input class="form-control" id="fecha_addenda_perinatal" name="fecha_addenda_perinatal" placeholder="dd/mm/aaaa">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-4">
						    			<label for="perinatal_ac" class="col-sm-6 control-label">Perinatal AC</label>
						    			<div class="col-sm-6">
							    			<select id="perinatal_ac" name="perinatal_ac" class="form-control">
							    				<option value="">Seleccione...</option>
							    				<option value="S">SI</option>
							    				<option value="N">NO</option>
							    			</select>
						    			</div>
						    		</div>
						    	</div>
						    @endif
						    </div>
						    <div class="tab-pane" id="addendas">
					    	@if (count($efector->addendas))
					    		@foreach ($efector->addendas as $add)
					    		<div class="row">
					    			<div class="col-md-6">
						    			<div class="form-group">
		                      				<label for="nombre_add" class="col-sm-5 control-label">Addenda</label>
		                  					<div class="col-sm-7">
		                    					<input readonly="readonly" type="text" class="form-control" value="{{ $add->tipo->nombre }}">
		                  					</div>
		                    			</div>
						    		</div>
						    		<div class="col-md-6">
						    			<div class="form-group">
		                      				<label for="fecha_addenda" class="col-sm-5 control-label">Fecha firma</label>
		                  					<div class="col-sm-7">
		                    					<input readonly="readonly" type="text" class="form-control" value="{{ $add->fecha_addenda }}">
		                  					</div>
		                    			</div>
						    		</div>
						    	</div>
						    	<br />
					    		@endforeach
					    	@endif
					    	@if (count($addendas))
					    		<div class="row">
					    			<div class="col-md-6">
					    				<label for="tipo_addenda" class="col-sm-5 control-label">Tipo Addenda</label>
						    			<div class="col-sm-7">
							    			<select id="tipo_addenda" name="tipo_addenda" class="form-control">
							    				<option value="">Seleccione...</option>
									    		@foreach ($addendas as $a)
									    		<option value="{{ $a->id }}">{{ $a->nombre }}</option>
									    		@endforeach
							    			</select>
						    			</div>
					    			</div>
					    			<div class="col-md-6">
						    			<div class="form-group">
		                      				<label for="fecha_firma" class="col-sm-5 control-label">Fecha firma</label>
		                  					<div class="col-sm-7">
		                    					<input type="text" id="fecha_firma" name="fecha_firma" type="text" class="form-control fecha_firma" placeholder="dd/mm/aaaa">
		                  					</div>
		                    			</div>
						    		</div>
					    		</div>
					    	@endif
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
					 	<button type="button" class="back btn btn-info">Volver a inicio</button>
					 	<button type="submit" class="finish btn btn-warning">Modificar</button>
					</div>
				</div>
			</div>
		</div>
	</form>
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
$(document).ready(function() {
	
	$('.finish').hide();
	$('#errores-div').hide();

	/*var d = new Date();

	var month = d.getMonth()+1;
	var day = d.getDate();

	var fechaActual = d.getFullYear() + '/' +
	    (month<10 ? '0' : '') + month + '/' +
	    (day<10 ? '0' : '') + day;*/
	
	$('#tel').inputmask({
		mask : '9999 9999 9999',
		placeholder : ''
	});

		
	$('#compromiso_ffin , #compromiso_fini , #compromiso_fsus , #convenio_fsus , #convenio_fini, #convenio_ffin , #fecha_addenda_perinatal , .fecha_firma').inputmask('99/99/9999');

	function checkCompromiso(integrante , compromiso){
		if(integrante == 'S'){
			if(compromiso == 'N'){
				$('#compromiso').removeAttr('disabled');
				$('#firmante_compromiso , #numero_compromiso , #compromiso_fini , #compromiso_fsus , #compromiso_ffin , #indirecto').attr('disabled' , 'disabled');
				$('#convenio_firmante , #convenio_numero , #convenio_fsus , #convenio_fini , #convenio_ffin , #cuie_admin , #nombre_admin').attr('disabled' ,'disabled');
			}
		}
		else if(integrante == 'N' || compromiso == 'N'){
			$('#compromiso').val('N').attr('disabled' , 'disabled');
			$('#firmante_compromiso , #numero_compromiso , #compromiso_fini , #compromiso_fsus , #compromiso_ffin , #indirecto').attr('disabled' , 'disabled');
			$('#convenio_firmante , #convenio_numero , #convenio_fsus , #convenio_fini , #convenio_ffin , #cuie_admin , #nombre_admin').attr('disabled' , 'disabled');
		}		
	}

	function checkConvenio(integrante , compromiso , convenio){
		if (integrante == 'N' || compromiso == 'N' || convenio == 'N'){
			$('#convenio_firmante , #convenio_numero , #convenio_fsus , #convenio_fini , #convenio_ffin , #cuie_admin , #nombre_admin').attr('disabled' , 'disabled');	
		}
	}

	checkCompromiso($('#integrante').val() , $('#compromiso').val());
	checkConvenio($('#integrante').val() , $('#compromiso').val() , $('#indirecto').val());

	$('#integrante').change(function(){
		var estado = $(this).val();
		if (estado == 'N'){
			$('#compromiso').val('N').attr('disabled' , 'disabled');
			$('#firmante_compromiso , #numero_compromiso , #compromiso_fini , #compromiso_fsus , #compromiso_ffin , #indirecto').attr('disabled' , 'disabled');
			$('#convenio_firmante , #convenio_numero , #convenio_fsus , #convenio_fini , #convenio_ffin , #cuie_admin , #nombre_admin').attr('disabled' , 'disabled');
		} else {
			$('#compromiso').val('').removeAttr('disabled');
			$('#firmante_compromiso , #numero_compromiso , #compromiso_fini , #compromiso_fsus , #compromiso_ffin , #indirecto').removeAttr('disabled');
			$('#convenio_firmante , #convenio_numero , #convenio_fsus , #convenio_fini , #convenio_ffin , #cuie_admin , #nombre_admin').removeAttr('disabled');
		}
	});

	$('#compromiso').change(function(){
		var estado = $(this).val();
		if (estado == 'N') {
			$('#firmante_compromiso , #numero_compromiso , #compromiso_fini , #compromiso_fsus , #compromiso_ffin , #indirecto').attr('disabled' , 'disabled');
			$('#convenio_firmante , #convenio_numero , #convenio_fsus , #convenio_fini , #convenio_ffin , #cuie_admin , #nombre_admin').attr('disabled' , 'disabled');
		} else {
			$('#firmante_compromiso , #numero_compromiso , #compromiso_fini , #compromiso_fsus , #compromiso_ffin , #indirecto').removeAttr('disabled');
			$('#convenio_firmante , #convenio_numero , #convenio_fsus , #convenio_fini , #convenio_ffin , #cuie_admin , #nombre_admin').removeAttr('disabled');
		}
	});

	$('#indirecto').change(function(){
		var estado = $(this).val();
		if (estado == 'N'){
			$('#convenio_firmante , #convenio_numero , #convenio_fsus , #convenio_fini , #convenio_ffin , #cuie_admin , #nombre_admin').attr('disabled' , 'disabled');
		} else {
			$('#convenio_firmante , #convenio_numero , #convenio_fsus , #convenio_fini , #convenio_ffin , #cuie_admin , #nombre_admin').removeAttr('disabled');	
		}
	});

	var $validator = $('form').validate({
		rules : {
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
				minlength : 5,
				maxlength : 500
			},
			provincia : {
				required : true
			},
			departamento : {
				required : true
			},
			localidad : {
				required : true
			},
			codigo_postal : {
				minlength : 4,
				maxlength : 8
			},
			numero_compromiso : {
				//required : true,
				minlength : 2
			},
			firmante_compromiso : {
				//required : true,
				minlength : 8
			},
			indirecto : {
				required : true
			},
			compromiso_fsus : {
				required : true
			},
			compromiso_fini : {
				required : true
			},
			compromiso_ffin : {
				required : true
			},
			convenio_firmante : {
				//required : true,
				minlength : 8
			},
			convenio_numero : {
				//required : true,
				minlength : 3
			},
			convenio_fsus : {
				required : true
			},
			convenio_fini : {
				required : true
			},
			convenio_ffin : {
				required : true
			},
			refer : {
				required : true
			},
			correo : {
				email : true
			}/*,
			fecha_firma: {
				date: fechaActual
			}*/
		},
		messages : {
			fecha_firma: {
				lessThan: 'El valor ingresado es una fecha mayor a la actual'
			}
		},
		submitHandler : function(form){
			$('#compromiso').removeAttr('disabled');
			$.ajax({
				method : 'post',
				url : 'efectores-modificacion',
				data : $(form).serialize(),
				success : function(data){
					$('#modal-text').html(data);
					$('.modal').modal();
					$('.modal').on('hidden.bs.modal', function (e) {
						$.get('efectores-modificacion' , function(data){
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
	

	$('.back').click(function(){
		$.get('efectores-modificacion' , function(data){
			$('.content-wrapper').html(data);
		})
	});

	$('.siisa').click(function(event){
		event.preventDefault();
		$.get('siisa-nuevo/{{ Auth::user()->id_provincia }}' , function(data){
			$('#siisa').val(data);
		});
	});


	function fillDepartamentos(provincia){
		var html = '';
		$.get('departamentos/' + provincia , function(data){
			$.each(data , function(key , value){
				if ('{{ $efector->geo->departamento->id_departamento }}' == value.id_departamento)
					html += '<option selected="selected" id-dto="' + value.id_departamento + '"  value="' + value.id + '">';
				else
					html += '<option id-dto="' + value.id_departamento + '"  value="' + value.id + '">';
				html += value.nombre_departamento;
				html += '</option>';
			});
			$('#departamento').html(html);
		});
	}

	function fillLocalidades(provincia , departamento){
		var html = '';
		$.get('localidades/' + provincia + '/' + departamento , function(data){
			$.each(data , function(key , value){
				if ('{{ $efector->geo->localidad->id_localidad }}' == value.id_localidad)
					html += '<option selected="selected" value="' + value.id + '">';
				else
					html += '<option value="' + value.id + '">';
				html += value.nombre_localidad;
				html += '</option>';
			});
			$('#localidad').html(html);
		});
	}

	fillDepartamentos('{{ $efector->geo->provincia->id_provincia }}');
	fillLocalidades('{{ $efector->geo->provincia->id_provincia }}' , '{{ $efector->geo->departamento->id_departamento }}');

	$('#provincia').change(function(){
		fillDepartamentos($(this).val())
	});

	$('#departamento').change(function(){
		fillLocalidades( $('#provincia').val() , $('option:selected' , this).attr('id-dto'))
	})

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