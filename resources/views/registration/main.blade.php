<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SIRGe Web</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Form CSS -->
    <link href="{{ asset("/dist/css/gsdk-base.css") }}" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="image-container set-full-height">
    <!--   Big container   -->
    <div class="container">
        <div class="row">
	    <div class="col-sm-8 col-sm-offset-2">
            <!-- Wizard container -->   
            <div class="wizard-container"> 
                <form action="registrar" method="post" id="my-form">
                <div class="card wizard-card ct-wizard-blue" id="wizard">
                <!-- You can switch "ct-wizard-orange"  with one of the next bright colors: "ct-wizard-blue", "ct-wizard-green", "ct-wizard-orange", "ct-wizard-red"             -->
                	<div class="wizard-header">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                            Por favor solucione los siguientes errores
                                <ol>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ol>
                            </div>
                        @endif
                    	<h3>
                    	   <b>CREA</b> TU PERFIL <br>
                    	   <small>Esta información será utilizada para registrarte al SIRGe Web.</small>
                    	</h3>
                	</div>
                	<ul>
                    	<li><a href="#about" data-toggle="tab">Acerca</a></li>
                        <li><a href="#account" data-toggle="tab">Sede</a></li>
                        <li><a href="#address" data-toggle="tab">Provincia</a></li>
                        <li><a href="#areas" data-toggle="tab">Área</a></li>
                        <li><a href="#more-about" data-toggle="tab">Más</a></li>
                        <li><a href="#password" data-toggle="tab">Contraseña</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane" id="areas">
                            <h4 class="info-text"> En qué área?</h4>
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <label>Área</label><br>
                                    <select name="area" class="form-control">
                                        <option value="16">Coordinación</option>
                                        <option value="5">Legal</option>
                                        <option value="17">Comunicación</option>
                                        <option value="2">Planificación estratégica</option>
                                        <option value="19">Supervisión</option>
                                        <option value="3">Cobertura prestacional</option>
                                        <option value="20">Asistencia técnica y capacitación</option>
                                        <option value="4">Cápitas</option>
                                        <option value="18">Administración</option>
                                        <option value="6">Planes especiales</option>
                                        <option value="1">Sistemas informáticos</option>
                                        <option value="21">Externo</option>
                                    </select>
                                </div>
                            </div>    
                        </div>
                        <div class="tab-pane" id="password">
                            <div class="row">
                                <h4 class="info-text"> Para terminar ingrese una contraseña</h4>  
                                <div class="col-sm-2"></div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                      <label>Contraseña</label>
                                      <input type="password" name="pass" class="form-control" id="pass">
                                      <div id="messages"></div>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="about">
                          <div class="row">
                              <h4 class="info-text"> Empezemos con información básica</h4>
                              <div class="col-sm-4 col-sm-offset-1">
                                 <div class="picture-container">
                                      <div class="picture">
                                          <img src="{{ asset ("/dist/img/usuarios/default-avatar.png")}}" class="picture-src" id="wizardPicturePreview" title=""/>
                                          <input type="file" name="picture">
                                      </div>
                                      <h6>Elija una foto</h6>
                                  </div>
                              </div>
                              <div class="col-sm-6">
                                  <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre ...">
                                  </div>
                                  <div class="form-group">
                                    <label for="apellido">Apellido</label>
                                    <input type="text" class="form-control" name="apellido" id="apellido" placeholder="Apellido ...">
                                  </div>
                              </div>
                              <div class="col-sm-10 col-sm-offset-1">
                                  <div class="form-group">
                                      <label>Email</label>
                                      <input type="email" class="form-control" name="email" placeholder="Email ...">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <div class="tab-pane" id="account">
                            <h4 class="info-text"> Dónde trabajás? </h4>
                            <div class="row">
                                <div class="col-sm-10 col-sm-offset-1">
                                    <div class="col-sm-4">
                                        <div class="choice" data-toggle="wizard-radio">
                                            <input type="radio" name="sede" value="1">
                                            <div class="icon">
                                                <i class="fa fa-building-o"></i>
                                            </div>
                                            <h6>UEC</h6>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="choice" data-toggle="wizard-radio">
                                            <input type="radio" name="sede" value="2">
                                            <div class="icon">
                                                <i class="fa fa-university"></i>
                                            </div>
                                            <h6>UGSP</h6>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="choice"  data-toggle="wizard-radio">
                                            <input type="radio" name="sede" value="3">
                                            <div class="icon">
                                                <i class="fa fa-hospital-o"></i>
                                            </div>
                                            <h6>Externo</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="more-about">
                            <h4 class="info-text"> Un poco más sobre vos </h4>
                            <div class="row">
                                <div class="col-sm-4">
                                	<div class="form-group">
                                		<label>Fecha de nacimiento</label>
                                		<input class="form-control" type="text" name="fecha_nacimiento" id="fecha-nacimiento">
                                	</div>
                                </div>
                                <div class="col-sm-4">
                                	<div class="form-group">
                                		<label>Teléfono</label>
                                		<input class="form-control" type="text" name="telefono" id="telefono">
                                	</div>
                                </div>
                                <div class="col-sm-4">
                                	<div class="form-group">
                                		<label>Ocupación</label>
                                		<input class="form-control" type="text" name="ocupacion">
                                	</div>
                                </div>
                            </div>
                            <div class="row">
                            	<div class="col-sm-12">
	                            	<div class="form-group">
                                		<label>Mensaje personal</label>
                                		<input class="form-control" type="text" name="mensaje_personal" placeholder="SUMAR es más Salud Pública ...">
                                	</div>
                            	</div>
                            </div>
                            <div class="row">
                            	<div class="col-sm-4">
	                            	<div class="form-group">
	                            		<div class="input-group">
										 	<span class="input-group-addon" id="fb"><i class="fa fa-facebook"></i></span>
										 	<input type="text" class="form-control" name="fb" placeholder="Facebook" aria-describedby="fb">
										</div>
	                            	</div>
                            	</div>
                            	<div class="col-sm-4">
	                            	<div class="form-group">
	                            		<div class="input-group">
										 	<span class="input-group-addon" id="tw"><i class="fa fa-twitter"></i></span>
										 	<input type="text" class="form-control" name="tw" placeholder="Twitter" aria-describedby="tw">
										</div>
	                            	</div>
                            	</div>
                            	<div class="col-sm-4">
	                            	<div class="form-group">
	                            		<div class="input-group">
										 	<span class="input-group-addon" id="g+"><i class="fa fa-google-plus"></i></span>
										 	<input type="text" class="form-control" name="gp" placeholder="Google +" aria-describedby="g+">
										</div>
	                            	</div>
                            	</div>
                            </div>
                            <div class="row">
                            	<div class="col-sm-4">
	                            	<div class="form-group">
	                            		<div class="input-group">
										 	<span class="input-group-addon" id="skype"><i class="fa fa-skype"></i></span>
										 	<input type="text" class="form-control" name="skype" placeholder="Skype" aria-describedby="skype">
										</div>
	                            	</div>
                            	</div>
                            	<div class="col-sm-4">
	                            	<div class="form-group">
	                            		<div class="input-group">
										 	<span class="input-group-addon" id="ln"><i class="fa fa-linkedin"></i></span>
										 	<input type="text" class="form-control" name="ln" placeholder="LinkedIn" aria-describedby="ln">
										</div>
	                            	</div>
                            	</div>
                            </div>
                        </div>
                        <div class="tab-pane" id="address">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="info-text"> Ubicado en? </h4>
                                </div>
                                <div class="col-sm-2">
                                </div>
                                <div class="col-sm-8">
                                	<div class="form-group">
									    <label>Provincia</label><br>
									     <select name="provincia" class="form-control">
									        <option value="01">Ciudad Autónoma de Buenos Aires</option>
									        <option value="02">Buenos Aires</option>
									        <option value="03">Catamarca</option>
									        <option value="04">Córdoba</option>
									        <option value="05">Corrientes</option>
									        <option value="06">Entre Ríos</option>
									        <option value="07">Jujuy</option>
									        <option value="08">La Rioja</option>
									        <option value="09">Mendoza</option>
									        <option value="10">Salta</option>
									        <option value="11">San Juan</option>
									        <option value="12">San Luis</option>
									        <option value="13">Santa Fe</option>
									        <option value="14">Santiago del Estero</option>
									        <option value="15">Tucumán</option>
									        <option value="16">Chaco</option>
									        <option value="17">Chubut</option>
									        <option value="18">Formosa</option>
									        <option value="19">La Pampa</option>
									        <option value="20">Misiones</option>
									        <option value="21">Nequén</option>
									        <option value="22">Rio Negro</option>
									        <option value="23">Santa Cruz</option>
									        <option value="24">Tierra del Fuego</option>
									    </select>
									  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wizard-footer">
                    	<div class="pull-right">
                            <input type='button' class='btn btn-next btn-fill btn-primary btn-wd btn-sm' name='next' value='Siguiente' />
                            <input type='submit' class='btn btn-finish btn-fill btn-primary btn-wd btn-sm' name='finish' value='Solicitar usuario' />
                        </div>
                        <div class="pull-left">
                            <input type='button' class='btn btn-previous btn-fill btn-default btn-wd btn-sm' name='previous' value='Anterior' />
                        </div>
                        <div class="clearfix"></div>
                    </div>	
                </div>
                {!! csrf_field() !!}
                </form>
            </div> <!-- wizard container -->
        </div>
        </div><!-- end row -->
    </div> <!--  big container -->
	<!-- jQuery 2.1.4 -->
	<script src="{{ asset ("/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
	<!-- Bootstrap 3.3.2 JS -->
	<script src="{{ asset ("/bower_components/admin-lte/bootstrap/js/bootstrap.min.js") }}"></script>
    <!-- jQuery validator -->
    <script src="{{ asset ("/dist/js/jquery.validate.min.js") }}"></script>
	<!-- jQuery Wizard -->
	<script src="{{ asset ("/dist/js/jquery.bootstrap.wizard.js") }}"></script>
	<!-- Wizard -->
	<script src="{{ asset ("/dist/js/wizard.js") }}"></script>
	<!-- Inputmask jQuery -->
	<script src="{{ asset ("/dist/js/jquery.inputmask.js") }}"></script>
	<!-- Inputmask -->
	<script src="{{ asset ("/dist/js/inputmask.js") }}"></script>
    <!-- Password Strength -->
    <script src="{{ asset ("/dist/js/pwstrength-bootstrap.js") }}"></script>
	<!-- Backstrech -->
    <script src="{{ asset ("/bower_components/admin-lte/plugins/backstrech/jquery.backstretch.min.js") }}"></script>
	<script type="text/javascript">
	$(document).ready(function(){

		$('#fecha-nacimiento').inputmask('99/99/9999');
		$('#telefono').inputmask('(999) 9999 - 9999')

        $('#pass').pwstrength();

		$.backstretch([
			"http://dl.dropbox.com/u/515046/www/outside.jpg"
			, "http://dl.dropbox.com/u/515046/www/garfield-interior.jpg"
			, "http://dl.dropbox.com/u/515046/www/cheers.jpg"
			, "https://scontent-gru1-1.xx.fbcdn.net/hphotos-xfa1/v/t1.0-9/538669_3912335528347_530471242_n.jpg?oh=fe9fa224ed1b7a8ca0588914fff76098&oe=565437DF"
		], {duration: 3000, fade: 750});
   	});
	</script>
</body>