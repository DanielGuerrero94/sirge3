@extends('content')
@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<form id="form-doiu9" class="form-inline">
			<div class="box box-info">
				<div class="box-header">
					<h2 class="box-title">Conceptos adicionales</h2>
				</div>
				<div class="box-body">

					<div class="alert alert-danger" id="errores-div">
				        <ul id="errores-form">
				        </ul>
				    </div>
						<ul>
							<li>Cantidad de efectores integrantes : <b>{{$efectores_integrantes}}</b></li>
							<li>Cantidad de efectores con convenio : <b>{{$efectores_convenio}}</b></li>
						</ul>
						<br />
						<div class="row">
							<div class="col-md-10 col-md-offset-1">
								<p>
									1. Se encuentra cargado y autorizado el Tablero de Control del Programa SUMAR con los datos correspondientes al per&iacute;do
									<input type="text" name="periodo_tablero" id="periodo_tablero" class="periodo form-control"/>
								</p>
							</div>
						</div>
						<hr >
						<div class="row">
							<div class="col-md-10 col-md-offset-1">
								<p>
									2. Con fecha <input type="text" name="fecha_cuenta_capitas" id="fecha_cuenta_capitas" class="fecha form-control" /> se remiti&oacute; al &Aacute;rea de Supervisi&oacute;n y Auditor&iacute;a de la 
									Gesti&oacute;n Administrativa y Financiera de la UEC la Declaraci&oacute;n Jurada que incluye los ingresos y egresos de la 
									Cuenta C&aacute;pitas Provincial del SPS durante el mes de <input type="text" name="periodo_cuenta_capitas" id="periodo_cuenta_capitas" class="periodo form-control" /> 
									y la copia del extracto bancario de dicha cuenta correspondiente al mismo per&iacute;odo<br />
								</p>
							</div>
						</div>
						<hr >
						<div class="row">
							<div class="col-md-10 col-md-offset-1">
								<p>
									3. Con fecha <input type="text" name="fecha_sirge" id="fecha_sirge" class="fecha form-control" /> se remiti&oacute; al &Aacute;rea Sistemas Inform&aacute;ticos de la UEC
									la Declaraci&oacute;n Jurada de Prestaciones, Comprobantes y Uso de Fondos realizado por los efectores correspondientes al 
									Sistema de reportes de Gesti&oacute;n (SIRGE), actualizando con los datos correspondientes al per&iacute;odo <input type="text" name="periodo_sirge" id="periodo_sirge" class="periodo form-control" /><br />
								</p>
							</div>
						</div>
						<hr >
						<div class="row">
							<div class="col-md-10 col-md-offset-1">
								<p>
									4. Con fecha <input type="text" name="fecha_reporte_bimestral" id="fecha_reporte_bimestral" class="fecha form-control" /> se remti&oacute; al &Aacute;rea Planificaci&oacute;n Estrat&eacute;gica de la 
									UEC, el Reporte bimestral de Prestaciones del SPS del Programa SUMAR y el Reporte bimestral de Uso de Fondos del SPS del Programa
									SUMAR correspondientes al bimestre 
									<select name="bimestre" id="bimestre" class="form-control">
										<option value="">Seleccione bimestre</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
									</select> 
									del a&ntilde;o
									<select name="anio_bimestre" id="anio_bimestre" class="form-control">
										<option value="">Seleccione a&ntilde;o</option>
										<option value="2015">2015</option>
										<option value="2016">2016</option>
										<option value="2017">2017</option>
									</select>
								</p>
							</div>
						</div>

				</div>
					
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button type="button" class="back btn btn-primary">Atrás</button>
					<button class="action btn btn-warning">Generar</button>
				</div>
			</div>
		</form>
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
	$(document).ready(function(){
		
		$('#errores-div').hide();

		$('.back').click(function(){
			$.get('{{$ruta_back}}' , function(data){
				$('.content-wrapper').html(data);
			});
		});

		$('.fecha').inputmask({
			mask : '99/99/9999',
			placeholder : 'dd/mm/aaaa'
		});

		$('.periodo').inputmask({
			mask : '9999-99',
			placeholder : 'aaaa-mm'
		});

		$('.action').click(function(){

			$('#form-doiu9').validate({
				rules : {
					periodo_tablero : {
						required : true
					},
					fecha_cuenta_capitas : {
						required : true
					},
					periodo_cuenta_capitas : {
						required : true
					},
					fecha_sirge : {
						required : true
					},
					periodo_sirge : {
						required : true
					},
					fecha_reporte_bimestral : {
						required : true
					},
					bimestre : {
						required : true
					},
					anio_bimestre : {
						required : true
					}
				},
				submitHandler : function(form) {
					$.ajax({
						method : 'post',
						url : 'ddjj-doiu-9',
						data : $(form).serialize() + '&motivo={{ $motivo or '' }}&periodo={{ $periodo }}&version={{ $version }}',
						success : function(data){
							$('#modal-text').html(data);
							$('.modal').modal();
							$('form').trigger('reset');
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
					});
				}
			});
		});

	});
</script>
@endsection