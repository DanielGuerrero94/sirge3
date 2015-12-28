@extends('content')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-5">
                <div class="box box-info">
                    <div class="box-header">
                        <h2 class="box-title">Información</h2>
                    </div>
                    <div class="box-body">
                        <table class="table table-hover" id="table">
                            <thead>
                                <tr>
                                    <th>Provincia</th>
                                    <th>Edad</th>
                                    <th>Sexo</th>
                                    <th>Cantidad</th>
                                    <th>Monto</th>
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
                        <h2 class="box-title">Gráfico</h2>
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
            ajax : 'grafico-4-table/{{$periodo}}',
            columns: [
                { data: 'id_provincia', name: 'id_provincia' },
                { data: 'edad' , name: 'edad'},
                { data: 'sexo' , name: 'sexo'},
                { data: 'cantidad'},
                { data: 'monto'}
            ]
        });

    $.get('grafico-4/{{$periodo}}' , function(data){

        $('#container').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Facturación por edad y sexo'
            },
            xAxis: [{
                    categories: data.categorias,
                    reversed: false,
                    labels: {
                        step: 1
                    },
                }, { // mirror axis on right side
                    opposite: true,
                    reversed: false,
                    categories: data.categorias,
                    linkedTo: 0,
                    labels: {
                        step: 1
                    },
                }],
            yAxis: {
                title: {
                    text: null
                },
                labels: {
                    formatter: function () {
                        return Math.abs(this.value) + '%';
                    }
                }
            },

            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },

            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + ', edad ' + this.point.category + '</b><br/>' +
                        'Prestaciones: ' + Highcharts.numberFormat(Math.abs(this.point.y) * 1000, 0);
                }
            },

            series: data.series
        });

    })
   
</script>
@endsection