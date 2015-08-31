@extends('content')
@section('content')
<div class="row" id="request-container">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
                <h2 class="box-title">Requerimientos pendientes de asignación</h2>
            </div>
            <div class="box-body">
                <table class="table table table-hover " id="asignaciones-requests-table">
                    <thead>
                      <tr>
                        <th>Nº</th>
                        <th>Usuario</th>
                        <th>Fecha ingreso</th>
                        <th>Tipo</th>
                        <th></th>
                      </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="operadores-modal-container"></div>
<script type="text/javascript">
    $(document).ready(function() {
        
         var dt = $('#asignaciones-requests-table').DataTable({
            processing: true,
            serverSide: true,
            ajax : 'asignacion-solicitud-table',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'usuario.nombre', name: 'usuario.nombre' },
                { data: 'fecha_solicitud', name: 'fecha_solicitud' },
                { data: 'tipos.descripcion', name: 'tipo' },
                { data: 'action', name: 'action'}
            ],
            order : [[0,'desc']]
        });


        $('#asignaciones-requests-table').on('click','.view-solicitud' , function(){
            var id = $(this).attr('id-solicitud');
            $.get('ver-solicitud/' + id + '/asignacion-solicitud', function(data){
                $('#request-container').html(data);
            })
        });

        $('#asignaciones-requests-table').on('click','.asignar-solicitud' , function(){
            var id = $(this).attr('id-solicitud');
            $.get('operadores/' + id , function(data){
                $('#operadores-modal-container').html(data);
                $('.modal-form-asignar').modal();
                $('.modal-form-asignar').on('hidden.bs.modal', function (e) {
                    dt.ajax.reload( null, false );
                });
            })
        });


    }); 
</script>
@endsection