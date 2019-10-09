<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; UTF-8">
    <link rel="shortcut icon" href="{{ asset("/dist/img/logo_shortcut_icon.png")}}">
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
    <!-- Date Picker -->
    <link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}"  />
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
<!-- Sounds -->
<script type="text/javascript" src="{{ asset ("/dist/js/ion.sound.js") }}"></script>
<!-- SlimScroll -->
<script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js") }}"></script>
<!-- AdminLTE App -->
<script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/dist/js/app.min.js") }}"></script>
<!-- Date Picker -->
<script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
<!-- Moment JS -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/locale/es.js"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->
<script>
$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN-SIRGE': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.validator.addMethod("lessThan", function(value, element, param) {
                    var d = new Date(value);
                    var month = d.getMonth()+1;
                    var day = d.getDate();

                    var d2 = new Date(param);
                    var month2 = d2.getMonth()+1;
                    var day2 = d2.getDate();

                    if(value == null || value == ''){
                        return true;
                    }
                    else if(d.getFullYear() < d2.getFullYear()){
                        return true;
                    }
                    else if(d.getFullYear() == d2.getFullYear() && month < month2){
                        return true;
                    }
                    else if(d.getFullYear() == d2.getFullYear() && month == month2 && day <= day2){
                        return true;
                    }
                    else{
                        return false;
                    }
    });

  $.validator.addMethod('le', function(value, element, param) {

    return value <= $(param).val();

  }, 'El valor debe ser menor que su comparativa.');

  $.validator.addMethod('ge', function(value, element, param) {

    return value >= $(param).val();

  },'El valor debe ser mayor que su comparativa.');

    $.validator.addMethod( "correct_period", function( value, element ) {
    var check = false,
        re = /^\d{4}\-\d{1,2}$/,
        adata, gg, mm, aaaa, xdata;
    if ( re.test( value ) ) {check = false;
        adata = value.split( "-" );
        aaaa = parseInt( adata[ 0 ], 10 );
        mm = parseInt( adata[ 1 ], 10 );
        gg = 1;
        xdata = new Date( Date.UTC( aaaa, mm - 1, gg, 12, 0, 0, 0 ) );
        if ( ( xdata.getUTCFullYear() === aaaa ) && ( xdata.getUTCMonth() === mm - 1 ) && ( xdata.getUTCDate() === gg ) ) {
            check = true;
        } else {
            check = false;
        }
    } else {
        check = false;
    }
        return this.optional( element ) || check;
    }, $.validator.messages.date );

    ion.sound({
        sounds: [
            {
                name: "water_droplet_3",
                volume: 0.9
            },
            {
                name: "branch_break",
                volume: 0.8
            },
            {
                name: "button_tiny",
                volume: 0.8,
                preload: false
            }
        ],
        volume: 0.8,
        path: "/sirge3/public/dist/sounds/",
        preload: true
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

        if(! $('.navbar-nav > .notifications-menu, .navbar-nav > .messages-menu, .navbar-nav > .tasks-menu').hasClass('open')){

            $.ajax({
                global : false,
                url : 'nuevos-mensajes',
                method : 'get',
                dataType: 'json',
                success : function(data){

                    var m = data['mensajes'];
                    var m_no_leido = m;
                    var texto = '<ul>';

                    if(typeof data['subidas'] !== "undefined"){

                        ion.sound.play("branch_break");

                        var subidas = data['subidas'];
                        m = m + subidas.length;
                        var estado = 'FINALIZO su procesamiento.';
                        for (i = 0; i < subidas.length; ++i) {
                            if((subidas[i]['id_estado'] == 5 && subidas[i]['avisado'] == 1) || (subidas[i]['id_estado'] == 3 && subidas[i]['avisado'] == 1) || (subidas[i]['id_estado'] == 3 && subidas[i]['avisado'] == 2) ){
                                if(subidas[i]['id_estado'] == 5 && subidas[i]['avisado'] == 1){
                                    estado = 'HA COMENZADO a procesarse.';
                                }
                                texto += '<li class="subidas" subida="'+subidas[i]['id_subida']+'">El lote <b>' + subidas[i]['lote'] + '</b> ' + estado + '</li>';
                            }
                            else{
                                m = m - 1;
                            }
                        }
                        texto += '<li>Diríjase a adm. lotes para más detalles.</li><br />';
                    }

                    if (m > 0) {
                        $('.new-messages').html(m);
                        texto += '<li> Usted tiene ' + m_no_leido + ' conversaciones no leídas </li>';
                        texto += '</ul>';
                        $('.navbar-nav > .notifications-menu > .dropdown-menu, .navbar-nav > .messages-menu > .dropdown-menu, .navbar-nav > .tasks-menu > .dropdown-menu').css('width','380px');
                        $('.new-messages-text').html(texto);
                    } else {
                        $('.new-messages').html('');
                        $('.new-messages-text').html('Usted no tiene mensajes nuevos');
                    }
                }
            })
        }
    }

    function getNotifications(){

        if(! $('.navbar-nav > .notifications-menu, .navbar-nav > .messages-menu, .navbar-nav > .tasks-menu').hasClass('open')){
            $.ajax({
                    global : false,
                    method : 'get',
                    url : 'sonido-notificacion',
                    success : function(data){
                        if(data == 1){
                            ion.sound.play("water_droplet_3");
                        }
                    }
            });
        }
    }

    function newMessages(){
        setInterval(function(){ getMessages(); getNotifications(); } , 10000);
    }

    getMessages();
    getNotifications();
    newMessages();

    $('.dropdown-toggle').on('click', function(){
        var variables = '';
        $('.new-messages-text .subidas').each(function(i){
            variables += $(this).attr('subida') + ',';
        });

        $.ajax({
            method: 'post',
            url: 'avisos-leidos',
            data: {subidas: variables},
            success: function(data){
                console.log(data);
            },
            global: false,     // this makes sure ajaxStart is not triggered
            dataType: 'json'
        });
    });

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
