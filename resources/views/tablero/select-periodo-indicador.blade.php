@extends('content')
@section('content')
<div class="row">
	<form>
		<div class="col-md-8 col-md-offset-2">
			<div class="box box-info">
				<div class="box-header">
					<h2 class="box-title">Ingrese parámetros</h2>
				</div>
				<div class="box-body">
					<div class="form-group">
	      				<label for="provincia" class="col-sm-3 control-label">Provincia</label>
	  					<div class="col-sm-9">
	    					<select id="provincia" name="provincia" class="form-control">
   							<option value="99">TODAS</option>

							@foreach ($provincias as $provincia)
								@if ($provincia->id_provincia == $back_provincia && $back_provincia != null)
								<option value="{{ $provincia->id_provincia }}" selected>{{ $provincia->descripcion }}</option>
								@else
								<option value="{{ $provincia->id_provincia }}">{{ $provincia->descripcion }}</option>
								@endif
							@endforeach
							</select>
	  					</div>
	    			</div>
	    			<br />
	    			<div class="form-group">
	      				<label for="periodo" class="col-sm-3 control-label">Período</label>
	  					<div class="col-sm-9">
	  						@if ($back_periodo != '9999-99' && $back_periodo != null)
								<input type="text" class="form-control" id="periodo" name="periodo" value="{{$back_periodo}}">
							@else
								<input type="text" class="form-control" id="periodo" name="periodo">
							@endif

	  					</div>
	    			</div>
	    			<br />
	    			<div class="form-group">
	      				<label for="indicador" class="col-sm-3 control-label">Indicador</label>
	  					<div class="col-sm-9">
	    					<select id="indicador" name="indicador" class="form-control">
	    					<option value="999"> TODOS </option>

							@foreach ($indicadores as $main)
								@if ($main->indicador == $back_indicador && $back_indicador != null)
								<option value="{{ $main->indicador }}" selected>{{ str_replace("|",".",$main->indicador) }}</option>
								@else
								<option value="{{ $main->indicador }}">{{ str_replace("|",".",$main->indicador) }}</option>
								@endif
							@endforeach
							</select>
	  					</div>
	    			</div>
				</div>
				<div class="box-footer">
					<div class="btn-group" role="group">
						<button class="send btn btn-success">Ver</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="modal modal-danger">
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
        <button type="button" class="btn btn-outline" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">

	$('#periodo').inputmask({
		mask : '9999-99',
		placeholder : 'AAAA-MM'
	});

	$('.send').click(function(){
		$('form').validate({
			rules : {
				provincia : {
					required : true
				},
				periodo : {
					required : true,
					minlength : 7,
					maxlength : 7
				},
				indicador : {
					required : true
				},
			},
			submitHandler : function(form){
				$.get('tablero-listado-historico-view/' + $('#periodo').val() + '/' + $('#provincia').val() + '/' + $('#indicador').val(), function(data){
					if(data){
						$('.content-wrapper').html(data);
					}
				});
			}
		});
	});
</script>
@endsection