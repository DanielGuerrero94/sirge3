@extends('content')
@section('content')
<div class="row" id="request-container">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
                <h2 class="box-title">Solicitudes ingresadas</h2>
            </div>
            <div class="box-body">
                <table class="table table table-hover " id="listado-requests-table">
                    <thead>
                      <tr>
                        <th>Nº</th>
                        <th>Usuario</th>
                        <th>Fecha ingreso</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th></th>
                      </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-info">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Atención!</h4>
            </div>
            <div class="modal-body">
                <p id="modal-text"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
    $(document).ready(function() {
        
         var dt = $('#listado-requests-table').DataTable({
            processing: true,
            serverSide: true,
            ajax : 'listado-solicitudes-table',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'usuario.nombre', name: 'usuario.nombre' },
                { data: 'fecha_solicitud', name: 'fecha_solicitud' },
                { data: 'tipos.descripcion', name: 'tipo' },
                { data: 'estado_label', name: 'estado_label' },
                { data: 'action', name: 'action'}
            ],
            order : [[0,'desc']]
        });


        $('#listado-requests-table').on('click','.view-solicitud' , function(){
            var id = $(this).attr('id-solicitud');
            $.get('ver-solicitud/' + id + '/listado-solicitudes', function(data){
                $('#request-container').html(data);
            })
        });

        $('#listado-requests-table').on('click','.notificar-solicitud' , function(){
            var id = $(this).attr('id-solicitud');
            $.get('notificar-cierre/' + id , function(data){
                $('#modal-text').html(data);
                $('.modal').modal();
            })
        });
    }); 
</script>
@endsection