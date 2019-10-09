@extends('content')
@section('content')
<div id="sigop-reportes" class="row justify-content-center">
</div>

<script type="text/javascript">

function load_sigop_views(url)
{
	var base_url = "http://170.150.155.102:9999/public/";

		$.ajax({
			"url": base_url + url,
			"crossDomain": true,
		    "dataType": 'jsonp',
		})
		.done(function(msg) {
			let view = msg[0].view;
			$("#sigop-reportes").html(view);
	    	console.log( "success" );
		})
		.fail(function(msg, b) {
			console.log(msg);
	    	alert("Reporte no disponible");
		});
}

$(document).ready(function () {

    $(".content-header h1").html("Reportes SIGOP");

	//load_sigop_views("reportes");

	$("#sigop-reportes").on("click", ".load-view", function (e) {
		e.preventDefault();
		let url = $(this).data('url-reporte');
		load_sigop_views(url);
	});

});
</script>
@endsection
