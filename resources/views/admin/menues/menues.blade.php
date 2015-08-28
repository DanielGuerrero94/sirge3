@extends('content')
@section('content')
<div class="row">
    <div class="col-md-12">
		<div id="menues-container">
			<div class="box box-info">
                <div class="box-header">
                    <h2 class="box-title">Menues</h2>
                    <p>Se muestran todas las menues registrados:</p>
                    <div class="box-tools pull-right">
                        <button class="new-menu btn btn-success">Nuevo menú <i class="fa fa-plus-circle"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table table-hover" id="menues-table">
                        <thead>
                          <tr>
                            <th>Nombre</th>
                            <th></th>
                          </tr>
                        </thead>
                    </table>
                </div>
            </div>
		</div>
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $('#menues-table').DataTable({
            processing: true,
            serverSide: true,
            ajax : 'menues-table',
            columns: [
                { data: 'descripcion', name: 'descripcion' },
                { data: 'action', name: 'action' }
            ]
        });

        $('#menues-table').on('click' , '.edit-menu' , function(){
            var id = $(this).attr('id-menu');
            $.get('edit-menu/' + id, function(data){
                $('#menues-container').html(data);
            });
        });

        $('.new-menu').click(function(){
            $.get('new-menu' , function(data){
               $('#menues-container').html(data); 
            })
        });
    }); 
</script>
@endsection