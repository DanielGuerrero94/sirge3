<div class="row">
    <div class="col-md-12">
        
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        
        $('.edit-modulo').click(function(){
            var id = $(this).attr('id-modulo');
            $.get('edit-modulo/' + id, function(data){
                $('#modulos-container').html(data);
            });
        });

        $('.new-modulo').click(function(){
            $.get('new-modulo' , function(data){
               $('#modulos-container').html(data); 
            })
        });
    });
</script>
