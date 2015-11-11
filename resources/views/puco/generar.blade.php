@extends('content')
@section('content')
<div class="row">
	<div class="col-md-5">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Estadísticas</h2>
			</div>
			<div class="box-body">
				<table class="table table-hover" id="estadisticas-puco-table">
	                <thead>
	                  <tr>
	                    <th>Período</th>
	                    <th>Beneficiarios</th>
	                  </tr>
	                </thead>
	            </table>
			</div>
		</div>
	</div>
	<div class="col-md-7">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Estadísticas</h2>
				<div class="box-tools pull-right">
					<button class="generar-puco btn btn-warning"><i class="fa fa-flag"></i> Generar PUCO</button>
				</div>
			</div>
			<div class="box-body">
				<table class="table table-hover" id="resumen-puco-table">
	                <thead>
	                  <tr>
	                    <th>Lote</th>
	                    <th>Nombre</th>
	                    <th>Beneficiarios</th>
	                  </tr>
	                </thead>
	            </table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">

$(document).ready(function(){

	var dt = $('#estadisticas-puco-table').DataTable({
		processing: true,
        serverSide: true,
        ajax : 'puco-estadisticas-table',
        columns: [
            { data: 'periodo' , name: 'periodo'},
            { data: 'registros' , name: 'registros'}
            
        ],
        order : [[0,'desc']]
	});

	var dt = $('#resumen-puco-table').DataTable({
		processing: true,
        serverSide: true,
        ajax : 'puco-resumen-table',
        columns: [
            { data: 'lote' , name: 'periodo'},
            { data: 'codigo' , name: 'registros'}
            
        ],
        order : [[0,'desc']]
	});

});

</script>
@endsection