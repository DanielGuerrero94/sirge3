@extends('content')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div id="usuarios-container">
            <div class="box box-lime">
                <div class="box-header">
                    <h2 class="box-title">Listado completo de beneficiarios</h2>
                </div>
                <div class="box-body">
                    <table class="table table-hover" id="usuarios-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Provincia</th>
                                <th>Area</th>
                                <th>Permisos</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(function() {
    $('#usuarios-table').DataTable({
        processing: true,
        serverSide: true,
        ajax : 'usuarios-table',
        columns: [
            { data: 'id_usuario', name: 'id_usuario'},
            { data: 'nombre', name: 'nombre'},
            { data: 'email', orderable: false },
            { data: 'provincia.descripcion', name: 'provincia.descripcion', orderable: false },
            { data: 'nombre_area', orderable: false },
            { data: 'menu.descripcion', orderable: false },
            { data: 'action', orderable: false, searchable: false }

           
        ]
    });

    $('#usuarios-table').on('click' , '.edit-user' , function(){
        var id = $(this).attr('id-usuario');
        $.get('edit-usuario/' + id, function(data){
            $('#usuarios-container').html(data);
        });
    });
});
</script>
@endsection