@extends('content')
@section('content')
<div class="row" id="request-container">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
                <h2 class="box-title">Estado de mis requerimientos</h2>
            </div>
            <div class="box-body">
                <table class="table table table-hover">
                    <thead>
                      <tr>
                        <th>Nº</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Detalles</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($solicitudes as $solicitud)
                        <tr>
                            <td>{{ $solicitud->id }}</td>
                            <td>{{ date ('d M Y', strtotime($solicitud->fecha_solicitud)) }}</td> 
                            <td>{{ $solicitud->tipos->descripcion }}</td>
                            <td><span class="label label-{{$solicitud->estados->css}}">{{ $solicitud->estados->descripcion }}</span></td>
                            <td><button id-solicitud="{{ $solicitud->id }}" class="view-solicitud btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i></button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                {!! $solicitudes->render() !!}
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        
        $('.content-wrapper').off().on('click', '.pagination a', function (event) {
            event.stopPropagation();
            event.preventDefault();
            var route = $(this).attr('href');
            $.get(route , function(data){
                $('.content-wrapper').html(data);
            })
        });

        $('.view-solicitud').click(function(){
            var id = $(this).attr('id-solicitud');
            $.get('ver-solicitud/' + id , function(data){
                $('#request-container').html(data);
            })
        });
    }); 
</script>
@endsection