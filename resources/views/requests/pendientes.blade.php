@extends('content')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div id="cerrar-container">
            <div class="box box-info">
                <div class="box-header">
                    <h2 class="box-title">Tareas pendientes de solución</h2>
                </div>
                <div class="box-body">
                    <table class="table table table-hover " id="pendientes-requests-table">
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
</div>
<div id="operadores-modal-container"></div>
<script type="text/javascript">
    $(document).ready(function() {
        
         var dt = $('#pendientes-requests-table').DataTable({
            processing: true,
            serverSide: true,
            ajax : 'solicitudes-pendientes-table',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'usuario.nombre', name: 'usuario.nombre' },
                { data: 'fecha_solicitud', name: 'fecha_solicitud' },
                { data: 'tipos.descripcion', name: 'tipo' },
                { data: 'action', name: 'action'}
            ],
            order : [[0,'desc']]
        });


        $('#pendientes-requests-table').on('click','.view-solicitud' , function(){
            var id = $(this).attr('id-solicitud');
            $.get('ver-solicitud/' + id + '/solicitudes-pendientes', function(data){
                $('#cerrar-container').html(data);
            })
        });

        $('#pendientes-requests-table').on('click','.cerrar-solicitud' , function(){
            var id = $(this).attr('id-solicitud');
            $.get('cerrar-solicitud/' + id , function(data){
                $('#cerrar-container').html(data);
            });
        });


    }); 
</script>
@endsection