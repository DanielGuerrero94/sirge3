@extends('content')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Efectores</h2>
				<div class="box-tools pull-right">
					<a class="btn btn-warning" href="efectores-descargar-tabla" title={{$title}}><i class="fa fa-download"></i> Descargar tabla de efectores</a>	
				</div>
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
            ajax : 'efectores-listado-table',
            columns: [
                { data: 'cuie', name: 'cuie', orderable: false },
                { data: 'siisa', name: 'siisa', orderable: false },
                { data: 'nombre', name: 'nombre', orderable: false },
                { data: 'label_estado', name: 'estado.descripcion', orderable: false, searchable: false},
                { data: 'action', orderable: false, searchable: false}
            ]
        });

        $('#efectores-table').on('click' , '.ver-efector' ,function(data){
        	var id = $(this).attr('id-efector');
        	$.get('efectores-detalle/' + id + '/efectores-listado' , function(data){
        		$('.content-wrapper').html(data);
        	});
        });

	})
</script>
@endsection
