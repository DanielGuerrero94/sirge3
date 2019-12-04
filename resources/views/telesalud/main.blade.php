@extends('content')
@section('content')
<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="box box-info">
				<div class="box-header">
					<h2 class="box-title">Profesional</h2>
				</div>
				<div class="box-body">
	    			<div class="form-group">
	      				<label for="periodo" class="col-sm-3 control-label">Nombre</label>
	  					<div class="col-sm-9">
                            <p>{{$json['nombre']}}</p>
	  					</div>
	    			</div>
	    			<div class="form-group">
	      				<label for="periodo" class="col-sm-3 control-label">Apellido</label>
	  					<div class="col-sm-9">
                            <p>{{$json['apellido']}}</p>
	  					</div>
	    			</div>
	    			<div class="form-group">
	      				<label for="periodo" class="col-sm-3 control-label">Tipo documento</label>
	  					<div class="col-sm-9">
                            <p>{{$json['tipo_documento']}}</p>
	  					</div>
	    			</div>
	    			<div class="form-group">
	      				<label for="periodo" class="col-sm-3 control-label">Numero de documento</label>
	  					<div class="col-sm-9">
                            <p>{{$json['numero_documento']}}</p>
	  					</div>
	    			</div>
	    			<div class="form-group">
	      				<label for="periodo" class="col-sm-3 control-label">Matricula</label>
	  					<div class="col-sm-9">
                            <p>{{$json['matricula']?:'sin dato'}}</p>
	  					</div>
	    			</div>
	    			<div class="form-group">
	      				<label for="periodo" class="col-sm-3 control-label">Centro</label>
	  					<div class="col-sm-9">
                            <p>{{$json['centro']?:'sin dato'}}</p>
	  					</div>
	    			</div>

				</div>
			</div>
		</div>
</div>

<div class="row">
	<form>
		<div class="col-md-4 col-md-offset-4">
			<div class="box box-info">
				<div class="box-header">
					<h2 class="box-title">Consultas historico</h2>
				</div>
				<div class="box-footer">
					<div class="btn-group" role="group">
						<a href="telesalud/descarga" class="send btn btn-success">Descargar</a>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">

	$('#periodo').inputmask({
		mask : '9999-99',
		placeholder : 'AAAA-MM'
	});

    $(".content").css("background-image", "url('http://192.3.0.36/sirge3/public/dist/img/telesalud.jpg')");
    $(".content").css("min-height", "1080px");

	$('.download').click(function(){
	    $.get('telesalud/descarga', function(data){
	        $('.content-wrapper').html(data);
		});
	});
</script>
@endsection
