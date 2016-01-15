@extends('content')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">{{htmlentities("Año"). ' '.$anio}}</h2>
			</div>
			<div class="box-body">
				<table class="table table-hover" id="priorizados-table">
				    <thead>
				        <tr>
				            <th>Nombre</th>
				            <th>CUIE</th>
				            <th>Q1</th>
				            <th>Q2</th>
				            <th>Q3</th>				           				           
				        </tr>
				    </thead>
				</table>
			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button type="button" class="back btn btn-info">Atrás</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$(function() {

    /*$.get('priorizados-listado-table/{{$id_provincia}}/{{$indicador}}/{{$anio}}' , function(data){
			$('.content-wrapper').html(data);
	});*/


   $('#priorizados-table').DataTable({
        processing: true,
        serverSide: true,
        ajax : 'priorizados-listado-table/{{$id_provincia}}/{{$indicador}}/{{$anio}}',
        columns: [
            { data: 'nombre', name: 'nombre' },
            { data: 'efector', name: 'efector' },
            { data: 'c1', name: 'c1' },
            { data: 'c2', name: 'c2' },
            { data: 'c3' , name: 'c3' }
        ]
    }); 

    $('.back').click(function(){
		$.get('{{ $back }}' , function(data){
			$('.content-wrapper').html(data);
		});
	});
});
</script>
@endsection