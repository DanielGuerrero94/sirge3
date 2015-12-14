@extends('content')
@section('content')
<style type="text/css">
	.subtitle{
		font-size: 10px;
	}
	.subtitle th , th , td{
		text-align: center;
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
							<th>{{$mes}}</th>
						@endforeach
					@endfor
					</tr>

					<tr>
						<td>CABA</td>
						<td>
							<span class="label label-success">120k</span>
						</td>
						<td>
							<span class="label label-success">600</span>
						</td>
						<td>
							<span class="label label-warning">0</span>
						</td>
						<td>
							<span class="label label-danger">-</span>
						</td>
						<td>
							<span class="label label-success">541</span>
						</td>
						<td>
							<span class="label label-success">3</span>
						</td>
						<td>
							<button class="btn btn-info btn-xs"><i class="fa fa-line-chart"></i></button>
						</td>

						<td>
							<span class="label label-success">120</span>
						</td>
						<td>
							<span class="label label-success">600</span>
						</td>
						<td>
							<span class="label label-warning">0</span>
						</td>
						<td>
							<span class="label label-danger">-</span>
						</td>
						<td>
							<span class="label label-success">541</span>
						</td>
						<td>
							<span class="label label-success">3</span>
						</td>
						<td>
							<button class="btn btn-info btn-xs"><i class="fa fa-line-chart"></i></button>
						</td>

						<td>
							<span class="label label-success">120</span>
						</td>
						<td>
							<span class="label label-success">600</span>
						</td>
						<td>
							<span class="label label-warning">0</span>
						</td>
						<td>
							<span class="label label-danger">-</span>
						</td>
						<td>
							<span class="label label-success">541</span>
						</td>
						<td>
							<span class="label label-success">3</span>
						</td>
						<td>
							<button class="btn btn-info btn-xs"><i class="fa fa-line-chart"></i></button>
						</td>
					</tr>



				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){

    

});
</script>
@endsection