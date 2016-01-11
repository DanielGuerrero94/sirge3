@extends('content')
@section('content')
<div class="row">
    <div class="col-md-12">
		<div id="modulos-container">
			<div class="box box-lime">
                <div class="box-header">
                    <h2 class="box-title">Módulos</h2>
                    <p>Se muestran todas las módulos registrados:</p>
                    <div class="box-tools pull-right">
                        <button class="new-modulo btn btn-success">Nuevo módulo <i class="fa fa-plus-circle"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table table-hover" id="modulos-table">
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
                    </table>
                </div>
            </div>
		</div>
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        
        $('#modulos-table').on('click' , '.edit-modulo' , function(){
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

        $('#modulos-table').DataTable({
            processing: true,
            serverSide: true,
            ajax : 'modulos-table',
            columns: [
                { data: 'id_modulo', name: 'id_modulo' },
                { data: 'id_padre', name: 'id_padre' },
                { data: 'arbol', name: 'arbol' },
                { data: 'nivel_1', name: 'nivel_1' },
                { data: 'nivel_2', name: 'nivel_2' },
                { data: 'descripcion', name: 'descripcion'},
                { data: 'modulo', name: 'modulo'},
                { data: 'icono', name: 'icono'},
                { data: 'action', name: 'action'}
            ],
            order : [
                [3 , 'asc'],
                [4 , 'desc']
            ]
        });

    }); 
</script>
@endsection