@extends('content')
@section('content')
<div class="row">
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-header">
				<h2 class="box-title">Cargar archivos</h2>
			</div>
			<div class="box-body">
				<p>Desde esta opción usted podrá subir los archivos para la carga de prestaciones. Recuerde respetar la estructura de datos. Si tiene dudas consulte la opción "Diccionario de Datos"</p>
			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button href="subir-padron/{{ $id_padron }}" class="action btn btn-primary">Cargar archivos</button>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-header">
				<h2 class="box-title">Generar lotes</h2>
				<div class="box-tools pull-right">
					@if ($pendientes != 0)
					<span class="label label-warning">{{ $pendientes }} archivo(s) sin procesar</span>
					@else
					<span class="label label-success">No hay archivos pendientes</span>
					@endif
				</div>
			</div>
			<div class="box-body">
				<p>Desde esta opción usted podrá procesar aquellos archivos que ha subido y aceptarlos o no en caso que ud. lo desee. Recuerde revisar los errores informados una vez finalizado el proceso.</p>
			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button class="btn btn-primary">Procesar archivos</button>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-header">
				<h2 class="box-title">Administrar lotes</h2>
			</div>
			<div class="box-body">
				<p>Desde esta opción usted podrá administrar los lotes generados en el paso 2. Una vez que esté de acuerdo con el mismo se lo debe cerrar y posteriormente se generará una DDJJ.</p>
			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button class="btn btn-primary">Procesar archivos</button>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Declarar lotes cerrados</h2>
			</div>
			<div class="box-body">
				<p>Desde aquí ud. podrá declarar la cantidad de lotes que desee, de los que haya cerrado, para luego generar una DDJJ.</p>
			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button class="btn btn-info">Informar lotes</button>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">DDJJ</h2>
			</div>
			<div class="box-body">
				<p>Esta opción le permite imprimir las DDJJ correspondientes a los últimos lotes declarados y antiguos grupos.</p>
			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button class="btn btn-info">Ver DDJJ</button>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Diccionario de Datos</h2>
			</div>
			<div class="box-body">
				<p>Si tiene dudas de como generar el archivo de prestaciones para subir al SIRGe Web ingrese a esta opción.</p>
			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button class="btn btn-info">Ver diccionario</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('.action').click(function(){
		var href = $(this).attr('href');
		$.get(href , function(data){
			$('.content-wrapper').html(data);
		});
	})
</script>
@endsection