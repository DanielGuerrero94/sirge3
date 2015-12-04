@extends('content')
@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Listado de líneas de cuidado del P.S.S.</h2>
				<div class="box-tools pull-right">
					<a class="btn btn-warning" href="pss-descargar-tabla"><i class="fa fa-download"></i> Descargar P.S.S.</a>					
				</div>
			</div>
			<div class="box-body">
				<table class="table table-hover" id="pss-table">
	                <thead>
	                  <tr>
	                    <th>Nombre</th>
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

		$('#pss-table').DataTable({
            processing: true,
            serverSide: true,
            ajax : 'pss-lineas-table',
            columns: [
                { data: 'descripcion'},
                { data: 'action'}
            ]
        });

        $('#pss-table').on('click' , '.ver' , function(){
        	var id = $(this).attr('linea');
        	$.get('pss-lineas-detalle/' + id , function(data){
        		$('.content-wrapper').html(data);
        	})
        });

	})
</script>
@endsection