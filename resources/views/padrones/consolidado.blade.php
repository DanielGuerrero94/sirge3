@extends('content')
@section('content')
<style type="text/css">
	.subtitle, .name{
		font-size: 10px;
	}
	.subtitle th , th , td{
		text-align: center;
	}
	.name{
		text-align: left;
	}

</style>
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Consolidado de fuentes de datos</h2><br/>
				<small> Últimos 6 meses</small>
			</div>
			<div class="box-body">
				<table class="table table-stripped">
					<tr>
						<th rowspan="2">Provincia</th>
						<th colspan="6">Prestaciones</th>
						<th rowspan="2"></th>
						<th colspan="6">Comprobantes</th>
						<th rowspan="2"></th>
						<th colspan="6">Uso de fondos</th>
						<th rowspan="2"></th>
					</tr>

					<tr class="subtitle">
					@for ($i = 0 ; $i < 3 ; $i++)
						@foreach($meses as $mes)
							<td>{{$mes}}</td>
						@endforeach
					@endfor
					</tr>

					@foreach($consolidado as $key => $provincia)
					<tr>
						<td class="name">{{ucwords(mb_strtolower($provincia['data']['descripcion']))}}</td>
						@foreach ($provincia['prestaciones'] as $prestacion)
						<td>
							@if ($prestacion == 0)
								<span class="label label-warning">0</span>
							@elseif ($prestacion == -1)
								<span class="label label-danger">-</span>
							@else
								@if ($prestacion >= 1000)
								<span class="label label-success">{{round($prestacion/1000,0)}}k</span>
								@else
								<span class="label label-success">{{$prestacion}}</span>
								@endif
							@endif
						</td>
						@endforeach
						<td>
							<button href="padron-graficar/1/{{$provincia['data']['id_provincia']}}" class="graficar btn btn-info btn-xs"><i class="fa fa-line-chart"></i></button>
						</td>
						@foreach ($provincia['comprobantes'] as $prestacion)
						<td>
							@if ($prestacion == 0)
								<span class="label label-warning">0</span>
							@elseif ($prestacion == -1)
								<span class="label label-danger">-</span>
							@else
								@if ($prestacion >= 1000)
								<span class="label label-success">{{round($prestacion/1000,0)}}k</span>
								@else
								<span class="label label-success">{{$prestacion}}</span>
								@endif
							@endif
						</td>
						@endforeach
						<td>
							<button href="padron-graficar/3/{{$provincia['data']['id_provincia']}}" class="graficar btn btn-info btn-xs"><i class="fa fa-line-chart"></i></button>
						</td>
						@foreach ($provincia['fondos'] as $prestacion)
						<td>
							@if ($prestacion == 0)
								<span class="label label-warning">0</span>
							@elseif ($prestacion == -1)
								<span class="label label-danger">-</span>
							@else
								@if ($prestacion >= 1000)
								<span class="label label-success">{{round($prestacion/1000,0)}}k</span>
								@else
								<span class="label label-success">{{$prestacion}}</span>
								@endif
							@endif
						</td>
						@endforeach
						<td>
							<button href="padron-graficar/2/{{$provincia['data']['id_provincia']}}" class="graficar btn btn-info btn-xs"><i class="fa fa-line-chart"></i></button>
						</td>
					</tr>
					@endforeach

				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){

    $('.graficar').click(function(event){
    	var href = $(this).attr('href');
    	$.get(href , function(data){
    		$('.content-wrapper').html(data);
    	});	
    });

});
</script>
@endsection