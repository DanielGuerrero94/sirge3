@extends('content')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Datadic</h2>
			</div>
			<div class="box-body">
				<div class="alert alert-danger" id="errores-div">
					<ul id="errores-form">
					</ul>
				</div>
				<table class="table table-hover" id="lotes-table">
	                <thead>
	                  <tr>
	                    <th>Orden</th>
	                    <th>Campo</th>
	                    <th>Tipo</th>
	                    <th>Obligatorio</th>
	                    <th>Ejemplo</th>
	                    <th>Descripción</th>
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
            ajax : 'diccionario-table/{{ $padron }}',
            columns: [
                { data: 'orden' , name : 'orden'},
                { data: 'campo' , name : 'campo'},
                { data: 'tipo' , name: 'tipo'},
                { data: 'obligatorio'},
                { data: 'ejemplo'},
                { data: 'descripcion'}
                
            ],
            order : [[0,'asc']]
		});

	});
</script>
@endsection
