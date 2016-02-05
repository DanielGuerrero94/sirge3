<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>SIRGe Web | Recuperar contraseña</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset("/bower_components/admin-lte/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }} HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <b>SIRGe</b>Web
      </div><!-- /.login-logo -->
      <div class="login-box-body">
      @if (count ($errors) > 0)
        <div class="alert alert-danger">
          Error en ingreso:<br><br>
          <ul>
            @foreach ($errors as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
        <p class="login-box-msg">Por favor ingrese el email con el que se registró</p>
        <form action="password" method="post">
          <div class="form-group has-feedback">
            <input name="email" type="email" class="form-control" placeholder="Email" />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-7 col-xs-offset-5">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Recuperar contraseña</button>
            </div><!-- /.col -->
          </div>
          {!! csrf_field() !!}
        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="{{ asset ("/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{ asset ("/bower_components/admin-lte/bootstrap/js/bootstrap.min.js") }}"></script>
    <!-- Backstrech -->
    <script src="{{ asset ("/bower_components/admin-lte/plugins/backstrech/jquery.backstretch.min.js") }}"></script>
    <!-- jQuery validator -->
    <script src="{{ asset ("/dist/js/jquery.validate.min.js") }}"></script>
    <script>
      $.backstretch([
          "http://i.imgur.com/TKZpSPq.jpg"
        , "http://i.imgur.com/wvAoHzO.jpg"
        , "http://i.imgur.com/cjBRlew.jpg"
        , "http://i.imgur.com/2konMTs.jpg"
        , "http://i.imgur.com/7MyX5Vg.jpg"
      ], {duration: 3000, fade: 750});

      $('form').validate({
        rules : {
          email : {
            required: true,
            email: true,
            remote: 'checkemail-exists'
          }
        },
        submitHandler : function(form){
          form.submit();
        }
      });

    </script>
  </body>
</html>
