<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
                <h2 class="box-title">Módulos</h2>
                <p>Se muestran todas las módulos registrados:</p>
                <div class="box-tools pull-right">
                    <button class="new-modulo btn btn-success">Nuevo módulo <i class="fa fa-plus-circle"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table table table-hover">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>ID Padre</th>
                        <th>Árbol</th>
                        <th>Nivel 1</th>
                        <th>Nivel 2</th>
                        <th>Nombre</th>
                        <th>Ruta</th>
                        <th>Icono</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($modulos as $modulo)
                        <tr>
                            <td>{{ $modulo->id_modulo }}</td> 
                            <td>{{ $modulo->id_padre or '-' }}</td> 
                            <td>{{ $modulo->arbol }}</td> 
                            <td>{{ $modulo->nivel_1 }}</td> 
                            <td>{{ $modulo->nivel_2 }}</td> 
                            <td>{{ $modulo->descripcion }}</td> 
                            <td>{{ $modulo->modulo }}</td> 
                            <td><i class="fa {!! $modulo->icono !!}"></i></td> 
                            <td><button id-modulo="{{ $modulo->id_modulo }}" class="edit-modulo btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $modulos->render() !!}        
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        
        $('.edit-modulo').click(function(){
            var id = $(this).attr('id-modulo');
            $.get('edit-modulo/' + id, function(data){
                $('#modulos-container').html(data);
            });
        });

        $('.new-modulo').click(function(){
            $.get('new-modulo' , function(data){
               $('#modulos-container').html(data); 
            })
        });
    });
</script>
