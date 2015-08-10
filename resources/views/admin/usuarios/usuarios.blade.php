@extends('content')
@section('content')
<div class="row">
    <div class="col-md-12">
		<div id="usuarios-container">
			@include('admin.usuarios.table')
		</div>
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.pagination a', function (event) {
            event.preventDefault();
            var route = $(this).attr('href');
            $.get(route , function(data){
            	$('#usuarios-container').html(data);
            })
        });
    }); 
</script>
@endsection