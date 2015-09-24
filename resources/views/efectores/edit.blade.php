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
	<form id="baja-efector">
		<div class="col-md-10 col-md-offset-1">
			<div class="box box-warning">
				<div class="box-header">
					<h2 class="box-title">Ingrese el CUIE del efector a editar</h2>
				</div>
				<div class="box-body">
						<div class="form-group">
	          				<label for="cuie" class="col-sm-3 control-label">CUIE</label>
	      					<div class="col-sm-9">
	        					<input type="text" class="form-control" id="cuie" name="cuie" placeholder="999999">
	      					</div>
	        			</div>
				</div>
				<div class="box-footer">
					<div class="btn-group " role="group">
						<button class="search btn btn-warning">Buscar</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
$(document).ready(function() {

	$('#cuie').typeahead({
  		source : function (query , process) {
  			$.get('cuie-busqueda/' + query , function(data){
				process (data);
  			})
		} ,
		minLength : 2
	});
	
	$('#cuie').inputmask({
		mask : 'a99999',
		placeholder : ''
	});

	$('.search').click(function(){
		$('#baja-efector').validate({
			rules : {
				cuie : {
					required : true
				}
			},
			submitHandler : function(form){
				$.get('')
			}
		})
	});

	$('.finish').hide();
	$('#errores-div').hide();
	
	$('#tel').inputmask('(999) 9999 9999')

	$('#integrante').change(function(){
		var estado = $(this).val();
		if (estado == 'N'){
			$('#compromiso').val('N').attr('readonly' , 'readonly');
			$('#firmante_compromiso , #numero_compromiso , #compromiso_fini , #compromiso_fsus , #compromiso_ffin , #indirecto').attr('disabled' , 'disabled');
			$('#convenio_firmante , #convenio_numero , #convenio_fsus , #convenio_fini , #convenio_ffin , #cuie_admin , #nombre_admin').attr('disabled' , 'disabled');
		} else {
			$('#compromiso').val('').removeAttr('readonly');
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
	})

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
				minlength : 15,
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
				required : true,
				minlength : 3
			},
			firmante_compromiso : {
				required : true,
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
				required : true,
				minlength : 8
			},
			convenio_numero : {
				required : true,
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
			correo : {
				email : true
			}
		},
		submitHandler : function(form){
			$.ajax({
				method : 'post',
				url : 'efectores-alta',
				data : $(form).serialize(),
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
			})
		}
	});
	

	$('.back').click(function(){
		$('form').trigger('reset');
	});

	$('.siisa').click(function(event){
		event.preventDefault();
		$.get('siisa-nuevo/{{ Auth::user()->id_provincia }}' , function(data){
			$('#siisa').val(data);
		});
	});

	$('#provincia').change(function(){

		var provincia = $(this).val();
		var html = '';
			html += '<option value="">Seleccione ...</option>';

		$.get('departamentos/' + provincia , function(data){
			$.each(data , function(key , value){
				html += '<option id-dto="' + value.id_departamento + '"  value="' + value.id + '">';
				html += value.nombre_departamento;
				html += '</option>';
			});
			$('#departamento').html(html);
		});

		$.get('cuie-nuevo/' + provincia , function(data){
			$('#cuie').val(data);
			$('#modal-text').html('Se ha generado el CUIE ' + data + ' para dar de alta este efector.');
			$('.modal').modal();
		});
	});

	$('#departamento').change(function(){
		var provincia = $('#provincia').val();
		var departamento = $('option:selected' , this).attr('id-dto');
		var html = '';
			html += '<option value="">Seleccione ...</option>';
		$.get('localidades/' + provincia + '/' + departamento , function(data){
			$.each(data , function(key , value){
				html += '<option value="' + value.id + '">';
				html += value.nombre_localidad;
				html += '</option>';
			});
			$('#localidad').html(html);
		});
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