@extends('content')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Líneas de cuidado C.E.I.</h2>
			</div>
			<div class="box-body">
				<table class="table table table-hover" id="table">
	                <thead>
	                  <tr>
	                    <th>Id</th>
	                    <th>Nombre</th>
	                    <th>Edad mínima</th>
	                    <th>Edad máxima</th>
	                    <th>Detalles</th>
	                    <th>Descargar</th>
	                  </tr>
	                </thead>
	            </table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){

		$('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax : 'cei-reportes-table',
            columns: [
                { data: 'id' },
                { data: 'nombre', name: 'nombre' },
                { data: 'edad_min' },
                { data: 'edad_max' },
                { data: 'action' },
                { data: 'download' }
            ]
        });

        $('#table').on('click' , '.ver-indicador' ,function(data){
        	var id = $(this).attr('id');
        	$.get('cei-reportes/' + id , function(data){
        		$('.content-wrapper').html(data);
        	});
        });

        // $('#table').on('click' , '.download-indicador' ,function(data){
        // 	var id = $(this).attr('id');
        // 	$.get('cei-reportes-download/' + id , function(data){
        // 		$('.content-wrapper').html(data);
        // 	});
        // });

	})
</script>
@endsection