<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
                <h2 class="box-title">Areas</h2>
                <p>Se muestran todas las áreas registradas:</p>
                <div class="box-tools pull-right">
                    <button class="new-area btn btn-success">Nueva área <i class="fa fa-plus-circle"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table table table-hover">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($areas as $area)
                        <tr>
                            <td>{{ $area->nombre }}</td> 
                            <td><button id-area="{{ $area->id_area }}" class="edit-area btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $areas->render() !!}        
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.edit-area').click(function(){
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
