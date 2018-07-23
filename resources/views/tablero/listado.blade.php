@extends('content')
@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Listado completo de indicadores</h2>
				@if(in_array($user->id_menu,array(1,2,5,11,15)) && $user->id_entidad == 1)
					<div class="box-tools pull-right">
                        <div data-toggle="aceptar-tooltip" data-placement="left" style="display:inline-block;">
						  <a class="aceptar-indicador btn btn-success" href="indicadores-aceptar"><i class="fa fa-thumbs-up" style="margin-right: 5px;"></i> Aceptar indicadores</a>
                        </div>
                        <div data-toggle="rechazar-tooltip" data-placement="top" style="display:inline-block;">
						  <a class="rechazar-indicador btn btn-danger" href="indicadores-rechazar"><i class="fa fa-pencil-square-o"></i> Rechazar</a>
                        </div>
                        <div data-toggle="descargar-tooltip" data-placement="bottom" style="display:inline-block;">
                            <a class="descargar-indicador btn btn-warning" href="listado-descargar-tabla"><i class="fa fa-download"></i> Descargar tabla</a>
                        </div>
                    </div>
				@endif

			<div class="box-body" style="margin-top: 10px">
				<table class="table table-hover" id="tablero-table">
				    <thead>
				        <tr>
				            <th>Periodo</th>
				            <th>Provincia</th>
				            <th>Indicador</th>
				            <th>Numerador</th>
				            <th>Denominador</th>
				            <th>Estado</th>
				            <th>Accion</th>
				        </tr>
				    </thead>
				</table>
			</div>
            <div class="box-footer">
                    <div class="btn-group" role="group">
                        <button type="button" class="back btn btn-primary">Atrás</button>
                    </div>
                </div>
		</div>
	</div>
</div>
</div>
<div class="modal modal-success">
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
<style type="text/css">
    .moveright { text-align: right; margin-right: 10px; }
    .movecenter { text-align: center; }
</style>
<script>
$(function() {

	var table;
	var url = '';

	$('[data-toggle="aceptar-tooltip"]').tooltip();
    $('[data-toggle="rechazar-tooltip"]').tooltip();
    $('[data-toggle="descargar-tooltip"]').tooltip();

	$('.aceptar-indicador, .rechazar-indicador').hide();

	if({{ $user->id_area }} == 19 && {{ $user->id_entidad }}  == 1 && ('{{ $indicadores_full }}' != 'completed' && '{{ $indicadores_full }}' != 'rejected')){
		$('.aceptar-indicador, .rechazar-indicador').show();
	}

	//url = 'tablero-listado-table/{{$periodo}}/{{$provincia}}';

    table = $('#tablero-table').DataTable({
        type: 'get',
        processing: true,
        serverSide: true,
        sortable: true,
        pageLength: 17,
        dataType: 'json',
        ajax : {
                url: '{{url("/tablero-listado-table")}}/'+ '{{$periodo}}' + '/' + '{{$provincia}}'
        },
        columns: [
            { data: 'periodo'},
            { data: 'provincias.descripcion'},
            { data: 'indicador_real',"sClass": "movecenter" },
            { data: 'numerador_format',"sClass": "moveright" },
            { data: 'denominador_format',"sClass": "moveright"},
            { data: 'estado',"sClass": "movecenter" },
            { data: 'action',"sClass": "movecenter" }
        ],
        "initComplete": function(){
            if($("#tablero-table tbody tr .dataTables_empty").length > 0){
                $('.aceptar-indicador, .rechazar-indicador, .descargar-indicador').attr('disabled', true);
                $('.aceptar-indicador').parent().attr('data-original-title', "No hay indicadores cargados");
                $('.rechazar-indicador').parent().attr('data-original-title', "No hay indicadores que rechazar");
                $('.descargar-indicador').parent().attr('data-original-title', "No hay nada que descargar");
            }
            else if($('#tablero-table .incompleto').length > 0){
                    $('.aceptar-indicador').attr('disabled', true);
                    $('.aceptar-indicador').parent().attr('data-original-title', "Existen indicadores incompletos");
                    $('.rechazar-indicador').parent().attr('data-original-title', "Rechazar hay indicadores existentes");
                    $('.descargar-indicador').parent().attr('data-original-title', "Descargar excel de indicadores");
            }
            else if('{{ $indicadores_full }}' == 'false'){
                    $('.aceptar-indicador').attr('disabled', true);
                    $('.aceptar-indicador').parent().attr('data-original-title', "No se han ingresado todos los indicadores");
                    $('.rechazar-indicador').parent().attr('data-original-title', "Rechazar indicadores existentes");
                    $('.descargar-indicador').parent().attr('data-original-title', "Descargar excel de indicadores");
            }
        }
    });

    $('.back').click(function(){
        $.get('tablero' , function(data){
            $('.content-wrapper').html(data);
        });
    });



    $('#tablero-table').on('click' , '.modificar-indicador' , function(){
    	console.log($(this).attr('id'));

    	var id = $(this).attr('id');
        	$.get('tablero-modificar-indicador/' + id , function(data){
        		$('.content-wrapper').html(data);
        	});
    });

    $('#tablero-table').on('click' , '.observar-indicador' , function(){
    	console.log($(this).attr('id'));

    	var id = $(this).attr('id');
    	$.get('tablero-observar-indicador/' + id , function(data){
    		$('.content-wrapper').html(data);
    	});
    });

    $('.aceptar-indicador').on('click', function(event){

        event.preventDefault();

        if($('#tablero-table .incompleto').length == 0 && '{{ $indicadores_full }}' == 'true'){

            $.ajax({
                    method : 'post',
                    data : { 'periodo' : '{{ $periodo }}', 'provincia' : '{{ $provincia }}' },
                    url  : 'aceptar-indicadores',
                    success : function(data){

                        if($('.modal').hasClass('modal-danger')){
                                $('.modal').removeClass('modal-danger').addClass('modal-success');
                        }
                        $('#modal-text').html('Se han aceptado los indicadores del periodo <b>' + '{{ $periodo }}' + ' </b>');
                        $('.modal').modal();

                        $('.modal .modal-dialog button').on('click', function(){
                            $.get('main-tablero/' + '{{ $periodo  }}' + '/' + '{{ $provincia }}', function(data){
                                $('.content-wrapper').html(data);
                            });
                        })

                    },
                    error : function(data){
                        $('.modal').removeClass('modal-success').addClass('modal-danger');
                        $('#modal-text').html('Ha ocurrido un error en el envio de datos');
                        $('.modal').modal();
                        $('.modal .modal-dialog button').on('click', function(){
                            $.get('main-tablero/' + '{{ $periodo  }}' + '/' + '{{$provincia}}', function(data){
                                $('.content-wrapper').html(data);
                            });
                        })
                    }
                });
        }
    });

    $('.rechazar-indicador').on('click', function(event){
        event.preventDefault();

            $.ajax({
                    method : 'post',
                    data : { 'periodo' : '{{ $periodo }}', 'provincia' : '{{ $provincia }}' },
                    url  : 'rechazar-indicadores',
                    success : function(data){

                        if($('.modal').hasClass('modal-danger')){
                                $('.modal').removeClass('modal-danger').addClass('modal-success');
                        }
                        $('#modal-text').html('Se han rechazado los indicadores del periodo <b>' + '{{ $periodo }}' + '</b>');
                        $('.modal').modal();

                        $('.modal .modal-dialog button').on('click', function(){
                            $.get('main-tablero/' + '{{$periodo}}' + '/' + '{{$provincia}}', function(data){
                                $('.content-wrapper').html(data);
                            });
                        })

                    },
                    error : function(data){
                        $('.modal').removeClass('modal-success').addClass('modal-danger');
                        $('#modal-text').html('Ha ocurrido un error en el envio de datos');
                        $('.modal').modal();
                        $('.modal .modal-dialog button').on('click', function(){
                            $.get('main-tablero/' + '{{$periodo}}' + '/' + '{{$provincia}}', function(data){
                                $('.content-wrapper').html(data);
                            });
                        })
                    }
                });
    });

    $('.descargar-indicador').click(function(event){
        event.preventDefault();

        var url = $(this).attr('href') + '/' + '{{$periodo}}' + '/' + '{{$provincia}}';

        location.href = url;
    });

});
</script>
@endsection

