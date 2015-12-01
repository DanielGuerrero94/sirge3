@extends('content')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Listado de códigos del P.S.S.</h2>
				<div class="box-tools pull-right">
					<a class="btn btn-warning" href="pss-descargar-tabla"><i class="fa fa-download"></i> Descargar tabla de pss</a>					
				</div>
			</div>
			<div class="box-body">
				<table class="table table-hover" id="pss-table">
	                <thead>
	                  <tr>
	                    <th>Código</th>
	                    <th>Tipo</th>
	                    <th>Objeto</th>
	                    <th>Diagnóstico</th>
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
            ajax : 'pss-listado-table',
            columns: [
                { data: 'codigo_prestacion', name: 'codigo_prestacion' },
                { data: 'tipo', },
                { data: 'objeto' },
                { data: 'diagnostico' }
            ]
        });

	})
</script>
@endsection