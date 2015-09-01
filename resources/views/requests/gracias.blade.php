<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SIRGe Web</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
</head>
<body>
    <div style="margin: 10%;">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>Gracias por su tiempo</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <p class="text-center">
                            Nos complace saber que la solución brindada cumple sus expectativas. <br/>
                            Ante cualquier consulta puede enviar un mail a: <br/>
                            sistemasuec@gmail.com
                        </p>
                    </div>
                </div>
            </div>    
        </div>
    </div>
	
	<!-- jQuery 2.1.4 -->
	<script src="{{ asset ("/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
	<!-- Bootstrap 3.3.2 JS -->
	<script src="{{ asset ("/bower_components/admin-lte/bootstrap/js/bootstrap.min.js") }}"></script>
	<!-- Backstrech -->
    <script src="{{ asset ("/bower_components/admin-lte/plugins/backstrech/jquery.backstretch.min.js") }}"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$.backstretch([
			"http://dl.dropbox.com/u/515046/www/outside.jpg"
			, "http://dl.dropbox.com/u/515046/www/garfield-interior.jpg"
			, "http://dl.dropbox.com/u/515046/www/cheers.jpg"
			, "https://scontent-gru1-1.xx.fbcdn.net/hphotos-xfa1/v/t1.0-9/538669_3912335528347_530471242_n.jpg?oh=fe9fa224ed1b7a8ca0588914fff76098&oe=565437DF"
		], {duration: 3000, fade: 750});
   	});
	</script>
</body>