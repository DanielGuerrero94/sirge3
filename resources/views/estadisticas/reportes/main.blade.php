@extends('content')
@section('content')
<div class="row">
@foreach ($reportes as $reporte)
	
	<div class="col-md-4">
		<div class="box box-{{$reporte->css}}">
			<div class="box-header">
				<h2 class="box-title">{{ $reporte->titulo }}</h2>
			</div>
			<div class="box-body">
				<div class="descripcion">
					{{ $reporte->descripcion }}
				</div>
				@foreach ($reporte->tags as $tag)
				<span class="label label-default">{{$tag}}</span>
				@endforeach
			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button id-reporte="{{ $reporte->id }}" class="view btn btn-info">Ver</button>
				</div>
			</div>
		</div>
	</div>	

@endforeach
</div>

<script type="text/javascript">
	$('.view').click(function(){
		var id = $(this).attr('id-reporte');
		$.get('estadisticas-reportes/' + id , function(data){
			$('.content-wrapper').html(data);
		});
	});

	$('.descripcion').slimScroll({
		height: '100px'
	});

</script>
@endsection