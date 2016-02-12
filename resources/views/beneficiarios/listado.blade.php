@extends('content')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Listado completo de beneficiarios</h2>
			</div>
			<div class="box-body">				
				    <div class="row-fluid">
				        <div class="col-md-9">				            
				        </div>
				        <div class="col-md-3">
				        	<form id="form-busqueda" action="listado_submit" method="get" accept-charset="utf-8">				        		
				        		<p><text style="margin-right:10px;">Buscar:</text> <input id="busqueda" name="busqueda"></p>
				        	</form>
				        </div>
				    </div>				
				<table class="table table-hover" id="beneficiarios-table">
				    <thead>
				        <tr>
				            <th>Nombre</th>
				            <th>Apellido</th>
				            <th>DNI</th>
				            <th>Fecha Nacimiento</th>
				            <th>Sexo</th>
				            <th>Clave Beneficiario</th>
				            <th>Detalles</th>
				        </tr>
				    </thead>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
$(function() {
    
	var table;

    table = $('#beneficiarios-table').DataTable({
        processing: true,
        serverSide: true,        
        searching: false,
        sortable: false,
        ajax : 'beneficiarios-listado-table',
        columns: [
            { data: 'nombre', orderable: false, searchable: false},
            { data: 'apellido', orderable: false, searchable: false},            
            { data: 'numero_documento', name:'numero_documento' , orderable: false},
            { data: 'fecha_nacimiento', orderable: false, searchable: false},
            { data: 'sexo', orderable: false, searchable: false},
            { data: 'clave_beneficiario', name: 'clave_beneficiario', orderable: false},
            { data: 'action', orderable: false, searchable: false},
        ]
    });

    $('#beneficiarios-table').on('click' , '.ver-beneficiario' , function(){
    	console.log($(this).attr('clave-beneficiario'));

    	var id = $(this).attr('clave-beneficiario');
        	$.get('beneficiarios-historia-clinica/' + id + '/beneficiarios-listado' , function(data){
        		$('.content-wrapper').html(data);
        	});
    });

    $("#form-busqueda").on('submit', function(event){
    		event.preventDefault();

    		table.destroy();

    		if($("#busqueda").val() == '' || $("#busqueda").val() == null){
				table = $('#beneficiarios-table').DataTable({
		        processing: true,
		        serverSide: true,	        
		        searching: false,		        
		        sortable: false,
		        ajax : 'beneficiarios-listado-table',
			        columns: [
			            { data: 'nombre', orderable: false, searchable: false},
			            { data: 'apellido', orderable: false, searchable: false},            
			            { data: 'numero_documento', name:'numero_documento' , orderable: false},
			            { data: 'fecha_nacimiento', orderable: false, searchable: false},
			            { data: 'sexo', orderable: false, searchable: false},
			            { data: 'clave_beneficiario', name: 'clave_beneficiario', orderable: false},
			            { data: 'action', orderable: false, searchable: false},
		        	]
	   			});    			
    		}
    		else{
    			table = $('#beneficiarios-table').DataTable({
		        processing: true,
		        serverSide: true,	        
		        searching: false,
		        paging: false,
		        sortable: false,
		        ajax : 'beneficiarios-busqueda/'+$("#busqueda").val(),
			        columns: [
			            { data: 'nombre', orderable: false, searchable: false},
			            { data: 'apellido', orderable: false, searchable: false},            
			            { data: 'numero_documento', name:'numero_documento' , orderable: false},
			            { data: 'fecha_nacimiento', orderable: false, searchable: false},
			            { data: 'sexo', orderable: false, searchable: false},
			            { data: 'clave_beneficiario', name: 'clave_beneficiario', orderable: false},
			            { data: 'action', orderable: false, searchable: false},
		        	]
	   			});
    		}    		
    	});     
});
</script>
@endsection