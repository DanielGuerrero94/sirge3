@extends('content')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Listado de códigos del P.S.S.</h2>
				<div class="box-tools pull-right">
					<!-- <a class="btn btn-warning" href="pss-descargar-tabla"><i class="fa fa-download"></i> Descargar P.S.S.</a>					 -->
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
	                    <th>Descripcion</th>
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
                { data: 'codigo_prestacion'},
                { data: 'tipo'},
                { data: 'objeto'},
                { data: 'diagnostico'},
                { data: 'descripcion_grupal'},
                { data: 'action' ,orderable: false, searchable: false}
            ]
        });

        $('#pss-table').on('click' , '.ver' , function(){
        	var id = $(this).attr('codigo');
        	$.get('pss-detalle/' + id , function(data){
        		$('.content-wrapper').html(data);
        	})
        });

	})
</script>
@endsection