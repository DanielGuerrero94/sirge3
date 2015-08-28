<div class="modal fade modal-info modal-form-asignar">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-asignar-operador">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Seleccione el operador</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        @foreach($operadores as $operador)
                        <div class="radio">
                            <input type="radio" name="operador" value="{{ $operador->id_usuario }}">
                            <label for="radio">
                              {{ $operador->usuario->nombre }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="solicitud" value="{{ $id_solicitud }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                    <button class="asignar btn btn-outline">Asignar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade modal-info modal-respuesta">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-asignar-operador">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Seleccione el operador</h4>
                </div>
                <div class="modal-body">
                    <p class="modal-text"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-red',
            radioClass: 'iradio_square-red',
            increaseArea: '20%' // optional
        });

        $('.asignar').click(function(){
            $('#form-asignar-operador').validate({
                rules : {
                    operador : {
                        required : true
                    }
                },
                submitHandler : function(form){
                    $.post('asignar-operador' , $(form).serialize() , function(data){
                        $('.modal-text').html(data);
                        $('.modal-respuesta').modal();
                        $('.modal-form-asignar').modal('hide');
                    });
                }
            })
        });
    });

</script>