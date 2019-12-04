<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>SIRGe Web | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset("/bower_components/admin-lte/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="{{ asset("/bower_components/admin-lte/plugins/iCheck/square/blue.css")}}" rel="stylesheet" type="text/css" />

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
        <p class="login-box-msg">Ingrese sus datos</p>
        <form action="login" method="post">
          <div class="form-group has-feedback">
            <input name="email" type="email" class="form-control" placeholder="Email" />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input name="password" type="password" class="form-control" placeholder="Password" />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Recordarme
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
            </div><!-- /.col -->
          </div>
          {!! csrf_field() !!}
        </form>

        <a href="password">Olvidé mi contrase&ntilde;a</a><br>
        <a href="registrar" class="text-center">Solicitar un usuario</a>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="{{ asset ("/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{ asset ("/bower_components/admin-lte/bootstrap/js/bootstrap.min.js") }}"></script>
    <!-- iCheck -->
    <script src="{{ asset ("/bower_components/admin-lte/plugins/iCheck/icheck.min.js") }}"></script>
    <!-- Backstrech -->
    <script src="{{ asset ("/plugins/backstrech/jquery.backstretch.min.js") }}"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    
      $.backstretch([
        "https://cas.gde.gob.ar/src/img/fondo/semana_01.jpg"
      , "https://cas.gde.gob.ar/src/img/fondo/semana_02.jpg"
      , "https://cas.gde.gob.ar/src/img/fondo/semana_03.jpg"
      , "https://cas.gde.gob.ar/src/img/fondo/semana_04.jpg"
      , "https://cas.gde.gob.ar/src/img/fondo/semana_05.jpg"
      , "https://cas.gde.gob.ar/src/img/fondo/semana_06.jpg"
      , "https://cas.gde.gob.ar/src/img/fondo/semana_07.jpg"
      , "https://cas.gde.gob.ar/src/img/fondo/semana_08.jpg"
      , "https://cas.gde.gob.ar/src/img/fondo/semana_09.jpg"
      , "https://cas.gde.gob.ar/src/img/fondo/semana_10.jpg"
      , "https://cas.gde.gob.ar/src/img/fondo/semana_11.jpg"
      , "https://cas.gde.gob.ar/src/img/fondo/semana_12.jpg"
      , "https://cas.gde.gov.ar/src/img/fondo/semana_13.jpg"
      , "https://cas.gde.gov.ar/src/img/fondo/semana_14.jpg"
      , "https://cas.gde.gov.ar/src/img/fondo/semana_15.jpg"
      ], {duration: 6000, fade: 2000});
    </script>
  </body>
</html>
