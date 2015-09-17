@extends('content')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Solicitudes de operaciones</h2>
			</div>
			<div class="box-body">
				<table class="table table table-hover" id="efectores-table">
	                <thead>
	                  <tr>
	                    <th>Cuie</th>
	                    <th>Siisa</th>
	                    <th>Nombre</th>
	                    <th>Estado</th>
	                    <th></th>
	                    <th></th>
	                    <th></th>
	                  </tr>
	                </thead>
	            </table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){

		$('#efectores-table').DataTable({
            processing: true,
            serverSide: true,
            ajax : 'efectores-revision-table',
            columns: [
                { data: 'cuie', name: 'cuie' },
                { data: 'siisa', name: 'siisa' },
                { data: 'nombre', name: 'nombre' },
                { data: 'label_estado', name: 'estado.descripcion' },
                { data: 'action', name: 'action' },
                { data: 'action_2', name: 'action_2' },
                { data: 'action_3', name: 'action_3' }
            ]
        });

        $('#efectores-table').on('click' , '.ver-efector' ,function(data){
        	var id = $(this).attr('id-efector');
        	$.get('efectores-detalle/' + id + '/efectores-revision', function(data){
        		$('.content-wrapper').html(data);
        	});
        });

        $('.alta').click(function(){
        	$.post('alta-efector' , 'id=' + $(this).attr('id-efector') , function(data){

        	})
        });

        $('.baja').click(function(){
        	$.post('baja-efector' , 'id=' + $(this).attr('id-efector') , function(data){

        	})
        });

        $('.rechazar').click(function(){
        	$.post('rechazo-efector' , 'id=' + $(this).attr('id-efector') , function(data){

        	})
        });

	})
</script>
@endsection