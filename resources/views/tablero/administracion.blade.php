@extends('content')
@section('content')
<div class="row">
	<form class="parametros-tablero" method="get" action="tablero-administracion-table">
		<div class="col-md-8 col-md-offset-2">
			<div class="box box-info">
				<div class="box-header">
					<h2 class="box-title">Ingrese parámetros</h2>
					<div class="box-tools pull-right">
					<a class="tablero-historico btn btn-info" href="tablero-filtros-historico"><i class="fa fa-download"></i>  HISTORIAL TABLEROS ACEPTADOS</a>
					</div>
				</div>
				<div class="box-body">
					<div class="form-group">
	      				<label for="provincia" class="col-sm-3 control-label">Provincia</label>
	  					<div class="col-sm-9">
	    					<select name="provincia" id="provincia" class="form-control">
	    					<option value="99" selected>TODAS</option>
	    						@foreach ($provincias as $a_provincia)
	    						<option value="{{$a_provincia->id_provincia}}">{{$a_provincia->descripcion}}</option>
	    						@endforeach
	    					</select>
	  					</div>
	    			</div>
	    			<br />
					<div class="form-group">
	      				<label for="periodo" class="col-sm-3 control-label">Período</label>
	  					<div class="col-sm-9">
	    					<input type="text" class="form-control" id="periodo" name="periodo" value="{{ $periodo }}">
	  					</div>
	    			</div>
				</div>
				<div class="box-footer">
					<div class="btn-group" role="group">
						<button class="send btn btn-info">Ver</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Estado de cargas del tablero en periodo</h2>
				<div class="box-tools pull-right">
					<a class="descargar btn btn-warning" onclick="location.href='tablero-administracion-descargar/'+$('#provincia').val()+'/{{$periodo}}'"><i class="fa fa-download"></i> Descargar tabla</a>
				</div>
			</div>

			<div class="box-body">
				<table class="table table-hover" id="tablero-administracion-table">
				    <thead>
				        <tr>
				            <th>Periodo</th>
				            <th>Provincia</th>
				            <th>Resuelto por</th>
				            <th>Ingresado</th>
				            <th>Estado</th>
				            <th>Accion</th>
				        </tr>
				    </thead>
				</table>
			</div>
		</div>
	</div>
</div>
<div><a class="descargarreal btn" type="hidden"></a></div>
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

<script>
$( document ).ready(function() {

	var table;
	var periodo = '';

	$('#periodo').inputmask({
		mask : '9999-99',
		placeholder : 'AAAA-MM'
	});

	table = datatable();

	$('.parametros-tablero').validate({
			rules : {
				provincia : {
					required : true
				},
				periodo : {
					required : true
				}
			}
	});

    $('.parametros-tablero').on('submit', function(event){
    	event.preventDefault();

    	if($("#periodo").val() != ""){
    		table.destroy();
			table = datatable();
			table.draw();
    	}
	});

	$('.tablero-historico').on('click' , function(event){
		event.preventDefault();
    	console.log($(this).attr('href'));

    	var v_href = $(this).attr('href');
        	$.get(v_href , function(data){
        		$('.content-wrapper').html(data);
        	});
    });

	$('#tablero-administracion-table').on('click', '#aceptar-periodo,#rechazar-periodo', function (){

			console.log($(this).attr('id_ingreso'));
			console.log($(this).attr('id'));

            $.ajax({
                    method : 'post',
                    data : { 'id_ingreso' : $(this).attr('id_ingreso') },
                    url  : $(this).attr('id'),
                    success : function(data){
                    	console.log(data);
                        if(data.status == "ok"){
                        	if($('.modal').hasClass('modal-danger')){
                                $('.modal').removeClass('modal-danger').addClass('modal-success');
                        	}
                        }
                        $('#modal-text').html(data.msj);
                        $('.modal').modal();

                        $('.modal .modal-dialog button').on('click', function(){
                            table.clear();
    						table = datatable();
    						table.draw();
                        })
                    },
                    error : function(data){
                        $('.modal').removeClass('modal-success').addClass('modal-danger');
                        $('#modal-text').html('Ha ocurrido un error en la aceptacion del periodo');
                        console.log(data);
                        $('.modal').modal();
                        $('.modal .modal-dialog button').on('click', function(){
                            table.clear();
		    				table = datatable();
		    				table.draw();
                        })
                    }
                });
    });

});

function datatable(){

  	return  $('#tablero-administracion-table').DataTable({
				        type: 'get',
				        processing: true,
				        serverSide: true,
				        sortable: false,
				        destroy: true,
				        paging: false,
				        dataType: 'json',
				        ajax : {
				        	url: '{{url("/tablero-administracion-table")}}/'+ $("#provincia").val() + '/' + $("#periodo").val()

				        },
				        columns: [
				            { data: 'periodo', orderable:false},
				            { data: 'provincia_descripcion'},
				            { data: 'usuario_nombre'},
				            { data: 'completado'},
				            { data: 'estado'},
				            { data: 'action'}
				        ],
				        "initComplete": function(){
				            if($("#tablero-administracion-table tbody tr .dataTables_empty").length > 0){
				                $('.descargar').attr('disabled', true);
				            }
				            else{
				            	$('.descargar').removeAttr('disabled');
				            }
			        	}
		    });
}
</script>

@endsection

