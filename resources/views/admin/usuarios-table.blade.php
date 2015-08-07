<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
                <h2 class="box-title">Usuarios</h2>
                <p>Se muestran todos los usuarios registrados al sistema:</p>
            </div>
            <div class="box-body">
                <table class="table table table-hover">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Provincia</th>
                        <th>Area</th>
                        <th>Permisos</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($usuarios as $usuario)
                        @if ($usuario->activo == 'N')
                            <tr class="danger">
                        @else
                            <tr>
                        @endif
                            <td>{{ $usuario->nombre }}</td> 
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->provincia->descripcion }}</td>
                            <td>{{ $usuario->area->nombre }}</td>
                            <td>{{ $usuario->menu->descripcion }}</td>
                            <td><button id-usuario="{{ $usuario->id_usuario }}" class="edit-user btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i></button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $usuarios->render() !!}        
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.edit-user').click(function(){
            var id = $(this).attr('id-usuario');
            $.get('edit-usuario/' + id, function(data){
                $('#usuarios-container').html(data);
            });
        });
    });
</script>
