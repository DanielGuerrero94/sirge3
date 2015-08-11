<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
                <h2 class="box-title">Menues</h2>
                <p>Se muestran todas las menues registrados:</p>
                <div class="box-tools pull-right">
                    <button class="new-menu btn btn-success">Nuevo menú <i class="fa fa-plus-circle"></i></button>
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
                        @foreach ($menues as $menu)
                        <tr>
                            <td>{{ $menu->descripcion }}</td> 
                            <td><button id-menu="{{ $menu->id_menu }}" class="edit-menu btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $menues->render() !!}        
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.edit-menu').click(function(){
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
