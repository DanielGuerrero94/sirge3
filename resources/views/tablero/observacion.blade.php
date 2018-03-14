@extends('content')
@section('content')
<div class="row">	
	<div class="col-md-10">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Observaciones:</h2>
				<div class="row">
                <div class="col-sm-2 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-icon text-grey"><i class="fa fa-tag"></i></span>
                    <h5 class="description-header">INDICADOR</h5>
                    <span class="description-text">{{ $indicador->indicador }}</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-2 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-icon text-grey"><i class="fa fa-image"></i></span>
                    <h5 class="description-header">PROVINCIA</h5>
                    <span class="description-text">{{ $indicador->provincia }}</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-2 col-xs-6">
                  <div class="description-block border-right">
                    <span class="description-icon text-grey"><i class="fa  fa-calendar"></i></span>
                    <h5 class="description-header">PERIODO</h5>
                    <span class="description-text">{{ $indicador->periodo }}</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-2 col-xs-6">
                  <div class="description-block">
                    <span class="description-percentage text-grey"><i class="fa fa-circle-o"></i></span>
                    <h5 class="description-header">NUMERADOR</h5>
                    <span class="description-text">{{ $indicador->numerador }}</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-2 col-xs-6">
                  <div class="description-block">
                    <span class="description-icon text-grey"><i class="fa fa-circle-o"></i></span>
                    <h5 class="description-header">DENOMINADOR</h5>
                    <span class="description-text">{{ $indicador->denominador }}</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-2 col-xs-6">
                  <div class="description-block">
                    <span class="description-icon text-black"><i class="fa fa-eye"></i></span>
                    <h5 class="description-header">ESTADO</h5>
                    @if ($estado->color == 'success')
                      <span class="description-percentage text-{{ $estado->color }}"><i class="fa fa-caret-up"></i>
                    @elseif ($estado->color == 'danger')
                      <span class="description-percentage text-{{ $estado->color }}"><i class="fa fa-caret-down"></i>                    
                    @endif

                     <b>{{ $estado->value }}</b></span> 
                  </div>
                  <!-- /.description-block -->
                </div>
              </div>
				




			</div>
			<div class="box-body">				
					<div id="scroll-historial-div">												
						<h4>Historial de observaciones realizadas</h4>
						@if (count($indicador->observaciones))
						<ul class="timeline">
              <!-- timeline time label -->
              <?php $fecha_anterior = ''; ?>
              @foreach (json_decode($indicador->observaciones) as $unaObservacion)
              @if ($fecha_anterior != date('Y-m-d',strtotime($unaObservacion->fecha)))
              <li class="time-label">
                <span class="bg-red">
                  {{ date('Y-m-d',strtotime($unaObservacion->fecha)) }}
                </span>
              </li>
              @endif
              <!-- /.timeline-label -->
              <!-- timeline item -->
              <li>
                <!-- timeline icon -->
                <i class="fa fa-user bg-{{ ($user->id_usuario == $unaObservacion->id_usuario) || ($user->id_entidad == App\Models\Usuario::find($unaObservacion->id_usuario)->id_entidad && $user->id_provincia == App\Models\Usuario::find($unaObservacion->id_usuario)->id_provincia) ? 'green' : 'navy' }}"></i>
                <div class="timeline-item">
                  <span class="time"><i class="fa fa-tag"></i> {{ App\Models\Usuario::find($unaObservacion->id_usuario)->entidad->descripcion }} </span>
                  <h3 class="timeline-header"><a href="#">{{ (App\Models\Usuario::find($unaObservacion->id_usuario)->nombre) . ' - ' }} <i> {{ date('H:i',strtotime($unaObservacion->fecha))}} </i></a></h3>
                  <div class="timeline-body">
                    <b><i>{{ mb_strtoupper(App\Models\Usuario::find($unaObservacion->id_usuario)->area->nombre) }} </i></b> <br> {{ ucfirst(mb_strtolower($unaObservacion->mensaje)) }}
                  </div>
                </div>
              </li>
              <!-- END timeline item -->
              <?php $fecha_anterior =  date('Y-m-d',strtotime($unaObservacion->fecha)); ?>
              @endforeach
            </ul>
						@else
						<div class="callout callout-warning">
							<h4>Sin observaciones!</h4>
							<p>No hay observaciones asociadas al indicador</p>
						</div>
						@endif
					</div>				
			</div>
    <div class="box-footer">      
      <form id="form-observacion">
        <div class="alert alert-danger" id="errores-div">
            <ul id="errores-form"></ul>
        </div>
        <div class="input-group">
          <input type="text" name="observacion" placeholder="Escribir mensaje ..." class="form-control" autocomplete="off">
          <input type="hidden" name="id" value="{{ $indicador->id }}" class="form-control">
          <span class="input-group-btn">
            <button class="enviar btn btn-warning btn-flat">Enviar</button>
          </span>
        </div>              
      </form>
      <br>
      <div class="btn-group " role="group">
          <button type="button" class="back btn btn-info">Atrás</button>
      </div>
    </div>	
		</div>
	</div>
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

		$('.back').click(function(){
			$.get('{{ $ruta_back }}' , function(data){
				$('.content-wrapper').html(data);
			});
		});

    $('#errores-div').hide();

    $('.enviar').click(function(){

      $('#form-observacion').validate({
        rules : {
                observacion : {
                    required: true                                        
                }                
            },
        submitHandler : function(form){
          
          console.log($(form).serialize());

          $.ajax({
            method : 'post',
            data : $(form).serialize(),
            url  : 'nueva-observacion',
            success : function(data){
              $('#errores-div').hide();              
              $('#modal-text').html('Se ha enviado la observacion');
              $('.modal').modal();
              $('.modal .modal-dialog button').on('click', function(){
                $.get('{{ $reload }}' , function(data){
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
          });
        }
      });
    });

		/*$('#scroll-historial-div').slimScroll({
	        height: '450px'
	    });*/

	});
</script>
@endsection