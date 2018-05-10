@extends('content')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Estado de cargas del tablero en periodo</h2>
				<div class="box-tools pull-right">
					<a class="descargar btn btn-warning" href="rechazados-descargar-tabla"><i class="fa fa-download"></i> Descargar tabla</a>
				</div>
			</div>

			<div class="box-body">
				<table class="table table-hover" id="tablero-rechazados-table">
				    <thead>
				        <tr>
				            <th>ID</th>
				            <th>Fecha</th>
				            <th>Periodo</th>
				            @if($user->id_entidad == 1)
					        <th>Provincia</th>
					        @endif
				            <th>Resuelto por</th>
				            <th>Estado</th>
				        </tr>
				    </thead>
				</table>
			</div>
		</div>
	</div>
</div>
<div><a class="descargarreal btn" type="hidden"></a></div>

<script>
$( document ).ready(function() {

	table = datatable();

	$('.descargar').click(function(event){
		event.preventDefault();

		var url = $(this).attr('href');

		location.href = url;
	});
});

function datatable(){

  	return  $('#tablero-rechazados-table').DataTable({
				        type: 'get',
				        processing: true,
				        serverSide: true,
				        sortable: false,
				        destroy: true,
				        paging: false,
				        dataType: 'json',
				        ajax : {
				        		url: '{{url("/tablero-rechazados-table")}}'
				    	},
				        columns: [
				        	{ data: 'id'},
				        	{ data: 'fecha', searchable:false},
				            { data: 'periodo', orderable:true},
				            @if($user->id_entidad == 1)
					        { data: 'provincias.descripcion'},
					        @endif
				            { data: 'usuario.nombre'},
				            { data: 'estado', searchable: false}
				        ],
				        "initComplete": function(){
				            if($("#tablero-rechazados-table tbody tr .dataTables_empty").length > 0){
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

