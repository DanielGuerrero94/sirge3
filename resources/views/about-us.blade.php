@extends('content')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-body">
				<div class="row">
					<div class="col-md-6">
						<p>La misión del sistema SIRGe Web consiste en organizar la información de que genera el programa SUMAR para que todos puedan acceder a ella y usarla. 
	Nos encontramos en constante crecimiento, desarrollando y mejorando funcionalidades para ofrecer el mejor servicio posible. 
	Entre toda la información que se puede encontrar se encuentran:</p>
						<ul>
							<li>Efectores</li>
							<li>Beneficiarios</li>
							<li>Prestaciones</li>
							<li>Plan de Servicios de Salud</li>
							<li>Uso de Fondos</li>
							<li>Comprobantes</li>
						</ul>
						<blockquote>
							<p>Porque el que tiene salud tiene esperanza; y el que tiene esperanza, tiene todo</p>
							<footer>Owen Arthur</footer>
						</blockquote>
					</div>
					<div class="col-md-6">
						<iframe style="width:100%; height:327px;border:0" src="https://www.youtube.com/embed/pYYfmFQXJy4" frameborder="0" allowfullscreen=""></iframe>
					</div>
				</div>
				<h3>Conozca a nuestro equipo</h3>
				<div class="row">
					@foreach($usuarios as $key => $usuario)
						<div class="col-md-4 text-center" style="margin-bottom:80px;">
							<img style="height: 120px;" src="{{ asset("/dist/img/usuarios/") . '/' . $usuario->ruta_imagen }}" class="img-circle img-responsive center-block" alt="Responsive image">
							<h4>{{$usuario->nombre}}</h4>
							<h5>{{$usuario->cargo}}</h5>
							<div class="text-right">
								<a href="{{strlen($usuario->google) ? $usuario->google : '#'}}" class="btn btn-xs btn-danger"><i class="fa fa-google-plus"></i></a>
								<a href="{{strlen($usuario->facebook) ? $usuario->facebook : '#'}}" class="btn btn-xs btn-primary"><i class="fa fa-facebook "></i></a>
								<a href="{{strlen($usuario->linkedin) ? $usuario->linkedin : '#'}}" class="btn btn-xs btn-primary"><i class="fa fa-linkedin "></i></a>
								<a href="{{strlen($usuario->twitter) ? $usuario->twitter : '#'}}" class="btn btn-xs btn-info"><i class="fa fa-twitter"></i></a>
								<a href="{{strlen($usuario->skype) ? $usuario->skype : '#'}}" class="btn btn-xs btn-info"><i class="fa fa-skype "></i></a>
							</div>
							<div style="height: 100px;">
								<blockquote>
									<p><footer>{{$usuario->mensaje}}</footer></p>
								</blockquote>	
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
@endsection