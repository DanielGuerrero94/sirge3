@extends('content')
@section('content')
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Administración de Lotes</h2>
			</div>
			<div class="box-body">
				<div class="alert alert-danger" id="errores-div">
					<ul id="errores-form">
					</ul>
				</div>
				<table class="table table-hover" id="lotes-table">
	                <thead>
	                  <tr>
	                  @if ($priority == 1)
	                    <th>Lote</th>
	                    <th>Fecha</th>
	                    <th>Provincia</th>
	                    @if ($id_padron == 7)
	                    	<th>Trazadora</th>
	                   	@endif 
	                    <th>Registros IN</th>
	                    <th>Registros OUT</th>
	                    @if ($id_padron != 7)
	                    	<th>Registros MOD</th>
	                   	@endif 
	                    <th>Estado</th>
	                    <th></th>
	                  @else
	                  	<th>Lote</th>
	                    <th>Fecha</th>	                    
	                    @if ($id_padron == 7)
	                    	<th>Trazadora</th>
	                   	@endif 
	                    <th>Registros IN</th>
	                    <th>Registros OUT</th>
	                    @if ($id_padron != 7)
	                    	<th>Registros MOD</th>
	                   	@endif 
	                    <th>Estado</th>
	                    <th></th>
	                  @endif
	                  </tr>
	                </thead>
	            </table>
			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button class="back btn btn-info">Atrás</button>
					<button class="refresh btn btn-success">Refrescar</button>
				</div>			
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){

		$('#errores-div').hide();

		$('.back').click(function(){
			$.get('padron/{{ $id_padron }}' , function(data){
				$('.content-wrapper').html(data);
			})
		});

		@if ($priority == 1)

			var dt = $('#lotes-table').DataTable({
				processing: true,
	            serverSide: true,
	            ajax : 'listar-lotes-table/{{ $id_padron }}',
	            columns: [
	                { data: 'lote', name: 'lote' },
	                { data: 'inicio' , name: 'inicio'},
	                { data: 'id_provincia' , name: 'id_provincia'},
	                @if ($id_padron == 7)
	                { data: 'nro_trazadora' , name: 'nro_trazadora'},
	                @endif
	                { data: 'registros_in'},
	                { data: 'registros_out'},
	                @if ($id_padron != 7)
	                { data: 'registros_mod'},
	                @endif	                
	                { data: 'estado_css' , name: 'estado_css'},
	                { data: 'action' }
	            ],
	            order : [[0,'desc']]
			});

		@else 

			var dt = $('#lotes-table').DataTable({
				processing: true,
	            serverSide: true,
	            ajax : 'listar-lotes-table/{{ $id_padron }}',
	            columns: [
	                { data: 'lote', name: 'lote' },
	                { data: 'inicio' , name: 'inicio'},
	                @if ($id_padron == 7)
	                { data: 'nro_trazadora' , name: 'nro_trazadora'},
	                @endif
	                { data: 'registros_in'},
	                { data: 'registros_out'},
	                @if ($id_padron != 7)
	                { data: 'registros_mod'},
	                @endif	                
	                { data: 'estado_css' , name: 'estado_css'},
	                { data: 'action' }
	            ],
	            order : [[0,'desc']]
			});

		@endif


		$('#lotes-table').on('click' , '.view-lote' , function(){
			var lote = $(this).attr('lote');
			$.get('detalle-lote/' + lote , function(data){
				$('.content-wrapper').html(data);
			});
		});

		$('.refresh').click(function(){
			$('#lotes-table').DataTable().ajax.reload();
		});



	});
</script>
@endsection('content')