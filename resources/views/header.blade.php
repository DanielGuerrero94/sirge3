<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="" class="logo"><b>SIRGe</b>Web</a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-envelope-o"></i>
                    <span class="label label-success new-messages"></span>
                </a>
                    
                    <ul class="dropdown-menu">
                        <li class="header new-messages-text"></li>
                        <li class="footer"><a href="inbox" class="ajax-link">Ver todos los mensajes</a></li>
                    </ul>
                </li><!-- /.messages-menu -->
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if (Auth::user()->ruta_imagen != null)
                          <img src="{{ asset("/dist/img/usuarios/" . '/' . Auth::user()->ruta_imagen ) }}" class="user-image" alt="User Image" />
                        @else
                          <img src="{{ asset("/dist/img/usuarios/" . '/' . 'default-avatar.png' ) }}" class="user-image" alt="User Image" />
                        @endif

                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ $usuario }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                        @if (Auth::user()->ruta_imagen != null)
                          <img src="{{ asset("/dist/img/usuarios/" . '/' . Auth::user()->ruta_imagen ) }}" class="img-circle" alt="User Image" />
                        @else
                          <img src="{{ asset("/dist/img/usuarios/" . '/' . 'default-avatar.png' ) }}" class="img-circle" alt="User Image" />
                        @endif

                            <p>
                                {{ $usuario }} - {{ $ocupacion }}
                                <small>{{ $mensaje }}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="perfil" class="btn btn-default btn-flat ajax-link">Perfil</a>
                            </div>
                            <div class="pull-right">
                                <a href="logout" class="btn btn-default btn-flat">Salir</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
