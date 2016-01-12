@extends('content')
@section('content')
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
				            <th>Historia Cl&iacute;nica</th>
				        </tr>
				    </thead>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
$(function() {
    $('#beneficiarios-table').DataTable({
        processing: true,
        serverSide: true,
        ajax : 'beneficiarios-listado-table',
        columns: [
            { data: 'nombre', name: 'nombre' },
            { data: 'apellido', name: 'apellido' },
            { data: 'geo.provincia.descripcion', name: 'provincia' },
            { data: 'fecha_nacimiento', name: 'fecha_nacimiento' },
            { data: 'sexo' , name: 'sexo' },
            { data: 'clave_beneficiario', name: 'clave beneficiario'},
            { data: 'action', name: 'detalle'},
        ]
    });

    $('#beneficiarios-table').on('click' , '.ver-beneficiario' , function(){
    	console.log($(this).attr('clave-beneficiario'));

    	var id = $(this).attr('clave-beneficiario');
        	$.get('beneficiarios-historia-clinica/' + id + '/beneficiarios-listado' , function(data){
        		$('.content-wrapper').html(data);
        	});


    })
});
</script>
@endsection