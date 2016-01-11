@extends('content')
@section('content')
<div class="row">
    <div class="col-md-12">
		<div id="areas-container">
			<div class="box box-lime">
                <div class="box-header">
                    <h2 class="box-title">Areas</h2>
                    <p>Se muestran todas las áreas registradas:</p>
                    <div class="box-tools pull-right">
                        <button class="new-area btn btn-success">Nueva área <i class="fa fa-plus-circle"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table table-hover" id="areas-table">
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
        $('#areas-table').DataTable({
            processing: true,
            serverSide: true,
            ajax : 'areas-table',
            columns: [
                { data: 'nombre', name: 'nombre' },
                { data: 'action', name: 'action' }
            ]
        });

        $('#areas-table').on('click' , '.edit-area' , function(){
            var id = $(this).attr('id-area');
            $.get('edit-area/' + id, function(data){
                $('#areas-container').html(data);
            });
        });

        $('.new-area').click(function(){
            $.get('new-area' , function(data){
               $('#areas-container').html(data); 
            })
        });
    }); 
</script>
@endsection