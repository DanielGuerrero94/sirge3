@extends('content')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-5">
                <div class="box box-info">
                    <div class="box-header">
                        <h2 class="box-title">Información Periodo {{$periodo}}</h2>
                    </div>
                    <div class="box-body">
                        <table class="table table-hover" id="table">
                            <thead>
                                <tr>
                                    <th>Periodo Prestacion</th>
                                    <th>Codigo Prestacion</th>
                                    <th>Cantidad Reportada</th>                                    
                                </tr>
                            </thead>
                        </table>                        
                    </div>
                    <div class="box-footer">
                        <div class="btn-group" role="group">
                            <button class="back btn btn-info">Atrás</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="box box-info">
                    <div class="box-header">
                        <h2 class="box-title">Datos Reportados en periodo porcentual</h2>
                    </div>
                    <div class="box-body">
                        <div id="container"></div>
                    </div>
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

    var dt = $('#table').DataTable({
            processing: true,
            serverSide: true,                                
            ajax : 'grafico-7-table/{{$periodo}}/{{$provincia}}',
            columns: [                
                { data: 'periodo_prestacion' , name: 'estadisticas.fc_008.periodo_prestacion'},                
                { data: 'codigo_prestacion', name: 'codigo_prestacion'},
                { data: 'cantidad', orderable: false, searchable: false }
            ]
        });
    
    $.get('grafico-7/{{ $periodo }}/{{ $provincia }}' , function(data){

        $('#container').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: null
            },
            xAxis: {
                categories: data.categorias,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: null
                },
                labels: {
                    enabled: false
                }
            },
            tooltip: {
                shared: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: data.series
        });

    })    
   
</script>
@endsection