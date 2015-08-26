@extends('content')
@section('content')
<div class="row">
    <div class="col-md-12">
		<div id="modulos-container">
			@include('admin.modulos.table')
		</div>
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#modulos-container').off().on('click', '.pagination a', function (event) {
            event.preventDefault();
            var route = $(this).attr('href');
            $.get(route , function(data){
            	$('#modulos-container').html(data);
            })
        });
    }); 
</script>
@endsection