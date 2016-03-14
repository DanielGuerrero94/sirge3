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
                            <h4>No se ha encontrado el email ingresado</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <p class="text-center">
                            El correo que está intentando ingresar no se encuentra registrado.<br/>
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
    <script src="{{ asset ("/plugins/backstrech/jquery.backstretch.min.js") }}"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$.backstretch([
			"http://i.imgur.com/TKZpSPq.jpg"
          , "http://i.imgur.com/wvAoHzO.jpg"
          , "http://i.imgur.com/cjBRlew.jpg"
          , "http://i.imgur.com/2konMTs.jpg"
          , "http://i.imgur.com/7MyX5Vg.jpg"
		], {duration: 3000, fade: 750});
   	});
	</script>
</body>