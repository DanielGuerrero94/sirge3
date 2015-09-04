@extends('content')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Detalle del efector: {{ $efector->nombre }}</h2>
			</div>
			<div class="box-body">
				<h4>Detalle del efector: {{ $efector->nombre }}</h4>
				
			</div>
		</div>
	</div>
</div>
@endsection