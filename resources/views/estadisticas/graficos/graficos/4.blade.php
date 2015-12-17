@extends('content')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
                <h2 class="box-title">{{$grafico->titulo}}</h2>
            </div>
            <div class="box-body">
                <div id="container"></div>
            </div>
            <div class="box-footer">
                <div class="btn-group" role="group">
                    <button class="back btn btn-info">Atrás</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    
    $('.back').click(function(){
        $.get('estadisticas-graficos' , function(data){
            $('.content-wrapper').html(data);
        });
    });

   
</script>
@endsection