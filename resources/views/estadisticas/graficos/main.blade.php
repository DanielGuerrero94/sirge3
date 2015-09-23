@extends('content')
@section('content')
<div class="row">
@foreach ($graficos as $grafico)
	{{--*/ $i = 0 /*--}}
	@if ($i % 3 == 0)
		{{--*/ $i ++ /*--}}
		<div class="col-md-4">
			<div class="box box-danger">
				<div class="box-header">
					<h2 class="box-title">{{ $grafico->titulo }}</h2>
				</div>
				<div class="box-body">
					{{ $grafico->descripcion }}
				</div>
				<div class="box-footer">
					<div class="btn-group" role="group">
						<button id-grafico="{{ $grafico->id }}" class="view btn btn-info">Ver</button>
					</div>
				</div>
			</div>
		</div>	
	@endif
@endforeach
</div>

<script type="text/javascript">
	$('.view').click(function(){
		var id = $(this).attr('id-grafico');
		$.get('estadisticas-graficos/' + id , function(data){
			$('.content-wrapper').html(data);
		});
	})
</script>
@endsection