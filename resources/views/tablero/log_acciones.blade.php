@extends('content')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Historial de Acciones</h2>
				<div class="box-tools pull-right">
					<a class="descargar btn btn-warning" href="log-acciones-descargar-tabla"><i class="fa fa-download"></i> Descargar tabla</a>
				</div>
			</div>

			<div class="box-body">
				<table class="table table-hover" id="tablero-log-acciones-table">
				    <thead>
				        <tr>
				            <th>Provincia</th>
				            <th>Usuario</th>
				            <th>Accion</th>
				        </tr>
				    </thead>
				</table>
			</div>
		</div>
	</div>
</div>

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

  	return  $('#tablero-log-acciones-table').DataTable({
				        type: 'get',
				        processing: true,
				        serverSide: true,
				        dataType: 'json',
				        ajax : {
				        		url: '{{url("/tablero-log-acciones-table")}}'
				    	},
				        columns: [
				        	{ data: 'provincias.descripcion'},
				            { data: 'usuario.nombre'},
				            { data: 'accion'}
				        ]
		    });
	}
</script>

@endsection

