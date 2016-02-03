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
                                    <th>Provincia</th>
                                    <th>Codigo Prestacion</th>
                                    <th>Cantidad Puntual</th>
                                    <th>Cantidad Oportuna</th>
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
                        <h2 class="box-title">DR Reportados en periodo porcentual</h2>
                    </div>
                    <div class="box-body">
                        <div id="container"></div>
                    </div>
                </div>
                <div class="row">            
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header">
                                <h2 class="box-title">Distribucion Datos Reportables</h2>
                            </div>
                            <div class="box-body">
                                <div id="container2"></div>
                            </div>
                        </div>
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
            iDisplayLength: 15,                
            ajax : 'grafico-3-table/{{$periodo}}',
            columns: [
                { data: 'id_provincia', name: 'id_provincia' },
                { data: 'codigo_prestacion' , name: 'estadisticas.fc_009.codigo_prestacion'},                
                { data: 'cantidad_dr', orderable: false, searchable: false },
                { data: 'cantidad_total_dr', orderable: false, searchable: false }
            ]
        });
    
    $.get('grafico-3/{{ $periodo }}' , function(data){

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

    $.get('grafico-3-treemap/{{ $periodo }}' , function(data){
        $('#container2').highcharts({
            series: [{
                type: "treemap",
                layoutAlgorithm: 'squarified',
                allowDrillToNode: true,
                dataLabels: {
                    enabled: false
                },
                levelIsConstant: false,
                levels: [{
                    level: 1,
                    dataLabels: {
                        enabled: true
                    },
                    borderWidth: 3
                }],
                data : data,
               /* tooltip: {
                    pointFormatter : function(){
                        if (this.codigo_prestacion){
                            return this.texto_prestacion + ' : ' + Highcharts.numberFormat(this.value , '0');
                        } else {
                            return Highcharts.numberFormat(this.value , '0');
                        }
                    }
                },*/
                turboThreshold : 5000
            }],
            subtitle: {
                text: 'Fuente: SIRGe Web.'
            },
            title : {
                text : 'Distribucion en periodo'
            }
        });
    });
   
</script>
@endsection