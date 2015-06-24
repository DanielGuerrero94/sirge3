<!DOCTYPE html>
<html>
<head>
	<title>Hola</title>
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>
	<form id="form-index">
		Ingrese su usuario : <input type="text" name="nombre">
		<input type="submit">
	</form>
	<div class="container"></div>
</body>
<script type="text/javascript">
	$(document).ready(function(){

		$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

		$('#form-index').submit(function(event){
			event.preventDefault();

			var form = $('#form-index').serialize();

			$.post('usuarios' ,'data=' + form, function(data){
				$('.container').html(data);
			});
		});
	});
</script>
</html>