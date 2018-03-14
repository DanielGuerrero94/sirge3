@extends('content')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header">
                        <h2 class="box-title">Operadores</h2>
                    </div>
                    <div class="box-body">
                        <table class="table table-hover" id="operadores">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Cantidad</th>                                    
                                </tr>
                            </thead>
                        </table>                        
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header">
                        <h2 class="box-title">Solicitantes</h2>
                    </div>
                    <div class="box-body">
                        <table class="table table-hover" id="solicitantes">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                        </table>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $('#operadores').DataTable({
        processing: true,
        serverSide: true,
        ajax : 'listado-ranking-operadores',
        columns: [
            { data: 'nombre', name: 'nombre' },                
            { data: 'cantidad', orderable: false, searchable: false }
        ]
    });
    
    $('#solicitantes').DataTable({
        processing: true,
        serverSide: true,
        ajax : 'listado-ranking-solicitantes',
        columns: [
            { data: 'nombre', name: 'nombre' },                
            { data: 'cantidad', orderable: false, searchable: false }
        ]
    });
   
</script>
@endsection