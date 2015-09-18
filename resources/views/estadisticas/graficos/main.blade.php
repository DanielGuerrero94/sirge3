@extends('content')
@section('content')
<div class="row">
	<div class="col-md-4">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Tasa de Mortalidad</h2>
			</div>
			<div class="box-body">
				La tasa de mortalidad general es la proporción de personas que fallecen respecto al total de la población, la tasa de mortalidad particular se refiere a la proporción de personas con una característica particular que mueren respecto al total de personas que tienen esa característica.
			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button class="view btn btn-info">Ver</button>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-header">
				<h2 class="box-title">Gráfico 2</h2>
			</div>
			<div class="box-body">
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ac nisi id tortor scelerisque dapibus vel ut magna. Nam vulputate, eros nec mollis semper, nisi tortor posuere ligula, non vestibulum magna nunc a ligula. Mauris posuere euismod nulla, in interdum massa efficitur quis.
			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button class="view btn btn-info">Ver</button>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-danger">
			<div class="box-header">
				<h2 class="box-title">Gráfico 3</h2>
			</div>
			<div class="box-body">
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ac nisi id tortor scelerisque dapibus vel ut magna. Nam vulputate, eros nec mollis semper, nisi tortor posuere ligula, non vestibulum magna nunc a ligula. Mauris posuere euismod nulla, in interdum massa efficitur quis.
			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button class="view btn btn-info">Ver</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="box box-warning">
			<div class="box-header">
				<h2 class="box-title">Gráfico 4</h2>
			</div>
			<div class="box-body">
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ac nisi id tortor scelerisque dapibus vel ut magna. Nam vulputate, eros nec mollis semper, nisi tortor posuere ligula, non vestibulum magna nunc a ligula. Mauris posuere euismod nulla, in interdum massa efficitur quis.
			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button class="view btn btn-info">Ver</button>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Gráfico 5</h2>
			</div>
			<div class="box-body">
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ac nisi id tortor scelerisque dapibus vel ut magna. Nam vulputate, eros nec mollis semper, nisi tortor posuere ligula, non vestibulum magna nunc a ligula. Mauris posuere euismod nulla, in interdum massa efficitur quis.
			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button class="view btn btn-info">Ver</button>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-success">
			<div class="box-header">
				<h2 class="box-title">Gráfico 6</h2>
			</div>
			<div class="box-body">
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ac nisi id tortor scelerisque dapibus vel ut magna. Nam vulputate, eros nec mollis semper, nisi tortor posuere ligula, non vestibulum magna nunc a ligula. Mauris posuere euismod nulla, in interdum massa efficitur quis.
			</div>
			<div class="box-footer">
				<div class="btn-group" role="group">
					<button class="view btn btn-info">Ver</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('.view').click(function(){
		$.get('estadisticas-graficos/1' , function(data){
			$('.content-wrapper').html(data);
		});
	})
</script>
@endsection