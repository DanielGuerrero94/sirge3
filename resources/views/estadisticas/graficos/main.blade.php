@extends('content')
@section('content')
<div class="row">
@foreach ($graficos as $grafico)
	
	<div class="col-md-4">
		<div class="box box-{{$grafico->css}}">
			<div class="box-header">
				<h2 class="box-title">{{ $grafico->titulo }}</h2>
			</div>
			<div class="box-body">
				<div class="descripcion">
					{{ $grafico->descripcion }}
				</div>
				@foreach ($grafico->tags as $tag)
				<span class="label label-default">{{$tag}}</span>
				@endforeach
			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button id-grafico="{{ $grafico->id }}" class="view btn btn-info">Ver</button>
				</div>
			</div>
		</div>
	</div>	

@endforeach
</div>

<script type="text/javascript">
	$('.view').click(function(){
		var id = $(this).attr('id-grafico');
		$.get('estadisticas-graficos/' + id , function(data){
			$('.content-wrapper').html(data);
		});
	});

	$('.descripcion').slimScroll({
		height: '100px'
	});

</script>
@endsection