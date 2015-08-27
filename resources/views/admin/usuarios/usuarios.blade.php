@extends('content')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<div class="row">
    <div class="col-md-12">
        <div id="usuarios-container">
            <div class="box box-info">
                <div class="box-header">
                    <h2 class="box-title">Listado completo de beneficiarios</h2>
                </div>
                <div class="box-body">
                    <table class="table table-bordered" id="usuarios-table">
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
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--
-->
<script type="text/javascript" src="{{ asset("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.js") }}"></script>
<script>
$(function() {
    $('#usuarios-table').DataTable({
        processing: true,
        serverSide: true,
        ajax : 'usuarios-table',
        columns: [
            { data: 'nombre', name: 'nombre' },
            { data: 'email', name: 'email' },
            { data: 'provincia.descripcion', name: 'provincia' },
            { data: 'area.nombre', name: 'area' },
            { data: 'menu.descripcion', name: 'menu' },
            { data: 'action', name: 'action'}
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