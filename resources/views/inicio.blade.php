<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; UTF-8"> 
    <title>SIRGe Web</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}"  />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"  />
    <!-- Ionicons -->
    <link rel="stylesheet" type="text/css" href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css"  />
    <!-- Fullcalendar -->
    <link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/admin-lte/plugins/fullcalendar/fullcalendar.css") }}"  />
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}" />
    <!-- iCheck -->
    <link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/admin-lte/plugins/iCheck/square/red.css")}}"  />
    <!-- Theme style -->
    <link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/admin-lte/dist/css/AdminLTE.css")}}"  />
    <!-- Upload style -->
    <link rel="stylesheet" type="text/css" href="{{ asset("/plugins/jquery-file-upload/css/jquery.fileupload.css")}}"  />
    <!-- Loading Modal -->
    <link rel="stylesheet" type="text/css" href="{{ asset("/dist/css/loading-modal.css")}}" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link href="{{ asset("/bower_components/admin-lte/dist/css/skins/skin-red-light.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="skin-red-light">
<div class="wrapper">

    <!-- Header -->
    @include('header')

    <!-- Sidebar -->
    @include('sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper"></div><!-- /.content-wrapper -->

    <!-- Footer -->
    @include('footer')

    <div class="loading-modal"></div>

</div><!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- Google Maps -->
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
<!-- jQuery 2.1.4 -->
<script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/bootstrap/js/bootstrap.min.js") }}" ></script>
<!-- Highcharts -->
<script type="text/javascript" src="{{ asset ("/plugins/highcharts/js/highcharts.js") }}" ></script>
<!-- Highcharts more -->
<script type="text/javascript" src="{{ asset ("/plugins/highcharts/js/highcharts-more.js") }}" ></script>
<!-- Highcharts more -->
<script type="text/javascript" src="{{ asset ("/plugins/highcharts/js/modules/heatmap.js") }}" ></script>
<!-- Highcharts more -->
<script type="text/javascript" src="{{ asset ("/plugins/highcharts/js/modules/treemap.js") }}" ></script>
<!-- Highcharts exporting server -->
<script type="text/javascript" src="{{ asset ("/plugins/highcharts/js/modules/exporting.js") }}" ></script>
<!-- Highmaps -->
<script type="text/javascript" src="{{ asset ("/plugins/highmaps/js/modules/map.js") }}"></script>
<!-- JS Tree -->
<script type="text/javascript" src="{{ asset ("/plugins/bootstrap-treeview-master/dist/bootstrap-treeview.min.js") }}" ></script>
<!-- Upload plugin Jquery UI widget -->
<script type="text/javascript" src="{{ asset ("/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js") }}"></script>
<!-- Iframe Transport -->
<script type="text/javascript" src="{{ asset ("/plugins/jquery-file-upload/js/jquery.iframe-transport.js") }}"></script>
<!-- Jquery File Upload -->
<script type="text/javascript" src="{{ asset ("/plugins/jquery-file-upload/js/jquery.fileupload.js") }}"></script>
<!-- Highmaps Argentina -->
<script type="text/javascript" src="http://code.highcharts.com/mapdata/countries/ar/ar-all.js" ></script>
<!-- Jquery Sparkline -->
<script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/plugins/sparkline/jquery.sparkline.min.js") }}" ></script>
<!--- MomentJs -->
<script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/plugins/fullcalendar/moment.js") }}" ></script>
<!-- Fullcalendar -->
<script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/plugins/fullcalendar/fullcalendar.min.js") }}" ></script>
<!-- Fullcalendar Language-->
<script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/plugins/fullcalendar/es.js") }}" ></script>
<!-- Google Calendar -->
<script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/plugins/fullcalendar/gcal.js") }}" ></script>
<!-- Datatables -->
<script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<!-- Bootstrap Datatables -->
<script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.js") }}"></script>
<!-- iCheck -->
<script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/plugins/iCheck/icheck.min.js") }}"></script>
<!-- jQuery validator -->
<script type="text/javascript" src="{{ asset ("/dist/js/jquery.validate.min.js") }}"></script>
<!-- Inputmask jQuery -->
<script type="text/javascript" src="{{ asset ("/dist/js/jquery.inputmask.js") }}"></script>
<!-- Inputmask -->
<script type="text/javascript" src="{{ asset ("/dist/js/inputmask.js") }}"></script>
<!-- Password Strength -->
<script type="text/javascript" src="{{ asset ("/dist/js/pwstrength-bootstrap.js") }}"></script>
<!-- jQuery Wizard -->
<script type="text/javascript" src="{{ asset ("/dist/js/jquery.bootstrap.wizard.js") }}"></script>
<!-- Typeahead -->
<script type="text/javascript" src="{{ asset ("/dist/js/typeahead.js") }}"></script>
<!-- SlimScroll -->
<script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js") }}"></script>
<!-- AdminLTE App -->
<script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/dist/js/app.min.js") }}"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->
<script>
$(document).ready(function(){
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on({
        ajaxStart: function() { $('body').addClass("loading"); },
        ajaxStop: function() { $('body').removeClass("loading"); }    
    });

    $.get('dashboard', function(data){
        $('.content-wrapper').html(data);
    });

    $('.sidebar-menu a[href!="#"] , .ajax-link').click(function(event){
        event.preventDefault();
        var modulo = $(this).attr('href');
        $.get(modulo , function (data){
            $('.content-wrapper').html(data);
        });
    });

    function getMessages(){
        $.ajax({
            global : false,
            url : 'nuevos-mensajes',
            method : 'get',
            success : function(data){
                var m = data;
                if (m > 0) {
                    $('.new-messages').html(m);
                    $('.new-messages-text').html('Usted tiene ' + m + ' conversaciones no leídas');
                } else {
                    $('.new-messages').html('');
                    $('.new-messages-text').html('Usted no tiene mensajes nuevos');
                }        
            }
        })
    }

    function newMessages(){
        setInterval(function(){ getMessages() } , 10000);
    }

    getMessages();
    newMessages();

    $.extend( true, $.fn.dataTable.defaults, {
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "pagingType": "simple"
    });
});
</script>
</body>
</html>
