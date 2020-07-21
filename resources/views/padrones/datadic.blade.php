@extends('content')
@section('content')
@if($padron == 12)
<div class="row">
	<div class="col-md-12">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Aclaraciones</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body" style="">
              Prestaciones con codigo CON*: Tienen que llevar los datos del beneficiario y of the box
            </div>
          </div>
	</div>
</div>
@endif
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
			    @if($padron == 12)
			    <th>Ejemplo</th>
			    @endif
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
	 	@if($padron == 12)
                { data: 'ejemplo'},
		@endif
                { data: 'descripcion'}
                
            ],
            order : [[0,'asc']]
		});

	});
</script>
@endsection
