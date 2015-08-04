<div class="container">
  <h2>Usuarios</h2>
  <p>Se muestran todos los usuarios registrados al sistema:</p>
  <table class="table">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Email</th>
        <th>Usuario</th>
      </tr>
    </thead>
	<tbody>
	@foreach ($usuarios as $usuario)
		<tr>
			<td>{{ $usuario->nombre }}</td>	
			<td>{{ $usuario->email }}</td>	
			<td>{{ $usuario->usuario }}</td>	
		</tr>
	@endforeach
    </tbody>
  </table>
</div>

{!! $usuarios->render() !!}