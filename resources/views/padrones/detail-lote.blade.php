@extends('content')
@section('content')
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Detalle lote {{ $lote->lote }}</h2>
				<div class="box-tools pull-right">
					@if ($lote->registros_out != 0)
					<button class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o"></i> Ver rechazos</button>
					@else
					<span class="label label-success">No hay registros rechazados</span>
					@endif
				</div>
			</div>
			<div class="box-body">
				<form class="form-horizontal">
					<div class="form-group">
						<!-- LOTE -->
						<label class="col-md-5 control-label">Lote</label>
						<div class="col-md-7">
							<p class="form-control-static"> {{ $lote->lote }} </p>
						</div>

						<!-- USUARIO -->
						<label class="col-md-5 control-label">Usuario creación</label>
						<div class="col-md-7">
							<p class="form-control-static"> {{ $lote->usuario->nombre }} </p>
						</div>

						<!-- PROVINCIA -->
						<label class="col-md-5 control-label">Provincia</label>
						<div class="col-md-7">
							<p class="form-control-static"> {{ $lote->provincia->descripcion }} </p>
						</div>

						<!-- ESTADO -->
						<label class="col-md-5 control-label">Estado</label>
						<div class="col-md-7">
							<p class="form-control-static"><label class="label label-{{ $lote->estado->css }}">{{ $lote->estado->descripcion }}</label></p>
						</div>

						<!-- IN -->
						<label class="col-md-5 control-label">Registros insertados</label>
						<div class="col-md-7">
							<p class="form-control-static"> {{ $lote->registros_in }} </p>
						</div>

						<!-- OUT -->
						<label class="col-md-5 control-label">Registros rechazados</label>
						<div class="col-md-7">
							<p class="form-control-static"> {{ $lote->registros_out }} </p>
						</div>

						<!-- MOD -->
						<label class="col-md-5 control-label">Registros modificados</label>
						<div class="col-md-7">
							<p class="form-control-static"> {{ $lote->registros_mod }} </p>
						</div>

						<!-- INICIO -->
						<label class="col-md-5 control-label">Fecha inicio</label>
						<div class="col-md-7">
							<p class="form-control-static"> {{ $lote->inicio }} </p>
						</div>

						<!-- FIN -->
						<label class="col-md-5 control-label">Fecha fin</label>
						<div class="col-md-7">
							<p class="form-control-static"> {{ $lote->fin }} </p>
						</div>

					</div>
				</form>
			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button class="back btn btn-info">Atrás</button>
					<button class="aceptar btn btn-success">Aceptar</button>
					<button class="eliminar btn btn-danger">Rechazar</button>
				</div>			
			</div>
		</div>
	</div>
</div>
<div class="modal fade modal-info">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Atención!</h4>
            </div>
            <div class="modal-body">
                <p id="modal-text"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){

		$('.back').click(function(){
			$.get('listar-lotes/{{ $lote->archivo->id_padron }}' , function(data){
				$('.content-wrapper').html(data);
			});
		});

		$('.aceptar').click(function(){
			$.post('aceptar-lote' , 'lote=' + {{ $lote->lote }} , function(data){
				$('#modal-text').html(data);
                $('.modal').modal();
                $('.modal').on('hidden.bs.modal', function (e) {
                    $.get('listar-lotes/{{ $lote->archivo->id_padron }}' , function(data){
						$('.content-wrapper').html(data);
					});
                });
			});
		});

		$('.eliminar').click(function(){
			$.post('eliminar-lote' , 'lote=' + {{ $lote->lote }} , function(data){
				$('#modal-text').html(data);
                $('.modal').modal();
                $('.modal').on('hidden.bs.modal', function (e) {
                    $.get('listar-lotes/{{ $lote->archivo->id_padron }}' , function(data){
						$('.content-wrapper').html(data);
					});
                });
			});
		});

	});
</script>
@endsection