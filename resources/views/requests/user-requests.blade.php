<table class="table table table-hover">
    <thead>
      <tr>
        <th>Fecha</th>
        <th>Tipo</th>
        <th>Estado</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($solicitudes as $solicitud)
        <tr>
            <td><h6>{{ date ('d M', strtotime($solicitud->fecha_solicitud)) }}</h6></td> 
            <td><h6>{{ $solicitud->tipos->descripcion }}</h6></td>
            <td><span class="label label-{{$solicitud->estados->css}}">{{ $solicitud->estados->descripcion }}</span></td>
        </tr>
    @endforeach
    </tbody>
</table>
{!! $solicitudes->render() !!}