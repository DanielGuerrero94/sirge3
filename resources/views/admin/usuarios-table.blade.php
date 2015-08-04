<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
                <h2>Usuarios</h2>
                <p>Se muestran todos los usuarios registrados al sistema:</p>
            </div>
            <div class="box-body">
                <table class="table table table-striped">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Usuario</th>
                        <th>Menú</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->nombre }}</td> 
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->usuario }}</td>
                            <td>{{ $usuario->menu->descripcion }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $usuarios->render() !!}        
            </div>
        </div>
        
    </div>
</div>
