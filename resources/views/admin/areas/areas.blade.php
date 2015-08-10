@extends('content')
@section('content')
<div class="row">
    <div class="col-md-12">
		<div id="areas-container">
			@include('admin.areas.table')
		</div>
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.pagination a', function (event) {
            event.preventDefault();
            var route = $(this).attr('href');
            $.get(route , function(data){
            	$('#areas-container').html(data);
            })
        });
    }); 
</script>
@endsection