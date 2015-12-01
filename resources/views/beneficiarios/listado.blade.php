@extends('content')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Listado completo de beneficiarios</h2>
			</div>
			<div class="box-body">
				<table class="table table-hover" id="beneficiarios-table">
				    <thead>
				        <tr>
				            <th>Nombre</th>
				            <th>Apellido</th>
				            <th>Provincia</th>
				            <th>Fecha Nacimiento</th>
				            <th>Sexo</th>
				            <th>Clave Beneficiario</th>
				            <th>Detalle</th>
				        </tr>
				    </thead>
				</table>
			</div>
		</div>
	</div>
</div>
<!--
-->
<script type="text/javascript" src="{{ asset("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.js") }}"></script>
<script>
$(function() {
    $('#beneficiarios-table').DataTable({
        processing: true,
        serverSide: true,
        ajax : 'beneficiarios-listado-table',
        columns: [
            { data: 'nombre', name: 'nombre' },
            { data: 'apellido', name: 'apellido' },
            { data: 'provincia.descripcion', name: 'provincia' },
            { data: 'fecha_nacimiento', name: 'fecha_nacimiento' },
            { data: 'sexo' , name: 'sexo' },
            { data: 'clave_beneficiario', name: 'clave beneficiario'},
            { data: 'action', name: 'detalle'},
        ]
    });

    $('#beneficiarios-table').on('click' , '.edit-user' , function(){
    	console.log($(this).attr('id-usuario'));
    })
});
</script>
@endsection