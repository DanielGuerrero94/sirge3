@extends('content')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-body">
				<div class="row">
					<div class="col-md-6">
						<p>La idea de esta herramienta es que funcione para probar distintos datos reportables y como funciona la validacion de su formato y valores. 
	Puede probar solo el formato o ingresar mas datos de la prestacion que son necesarios para calcular el rango de valores. 
					</div>
					<div class="col-md-6">
						<pre id="json">
{
  "prestacion_codigo": '2020-01-01',
  "prestacion_fecha": '2020-03-06',
  "beneficiario_nacimiento": '2020-01-01',
  "beneficiario_sexo": 'M',
  "id_dato_reportable_1": 1,
  "dato_reportable_1": 40
}
						</pre>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-body">
				<div class="row" id="dr">
					<div class="col-md-1">
						<a class="btn btn-app">
					                <i class="fa fa-play"></i> Probar
				              </a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
function addButton(string) {
		const button = '<div class="col-md-2"><div class="input-group input-group-lg"><div class="input-group-btn"><button type="button" class="btn bg-olive dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'+string+'</button></div><input type="text" class="form-control"></div></div>';

		return button;
	}
	$(document).ready(function() {
		$("#dr").append(addButton('Peso'));
		$("#dr").append(addButton('Talla'));
		$("#dr").append(addButton('Tension'));
	});
</script>

@endsection
