@extends('content')
@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Registros rechazados</h2>
			</div>
			<div class="box-body">
				<div class="alert alert-danger" id="errores-div">
					<ul id="errores-form">
					</ul>
				</div>
				<table class="table table table-hover" id="lotes-table">
	                <thead>
	                  <tr>
	                    <th>Lote</th>
	                    <th>Fecha cierre</th>
	                  </tr>
	                </thead>
	            </table>
			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button class="back btn btn-info">Atrás</button>
				</div>			
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){

		$('#errores-div').hide();

		$('.back').click(function(){
			$.get('padron/{{ $padron }}' , function(data){
				$('.content-wrapper').html(data);
			})
		});

		var dt = $('#lotes-table').DataTable({
			processing: true,
            serverSide: true,
            ajax : 'listado-lotes-cerrados-table/{{ $padron }}',
            columns: [
                { data: 'lote' , name : 'lote'},
                { data: 'fecha_aceptado' , name: 'fecha_aceptado'}
                
            ],
            order : [[0,'desc']]
		});

	});
</script>
@endsection