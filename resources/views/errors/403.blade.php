@extends('content')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="box">
            <div class="box-header">
               <h2 class="box-title">Permiso denegado.</h2>
            </div>
            <div class="box-body">
                <div class="callout callout-warning">
                    <h4>Usted no posee permisos para acceder a la opción solicitada.</h4>
                    <p>Esta opción está solo disponible para las UGSP.</p>
                </div>
            </div>
            <div class="box-footer">
                <div class="btn-group" role="group">
                    <button type="button" class="back btn btn-primary">Atrás</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection