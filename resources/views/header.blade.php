<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="#" class="logo"><b>SIRGe</b>Web</a>

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
                        <!--
                        <li>
                            <ul class="menu">
                                <li>
                                <a href="#">
                                    <div class="pull-left">
                                        <img src="{{ asset("/bower_components/admin-lte/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image"/>
                                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
                                    </div>
                                    <h4>
                                        Support Team
                                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                    </h4>
                                    <p>Why not buy a new awesome theme?</p>
                                </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
                    </ul>
                    -->
                </li><!-- /.messages-menu -->
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{ asset("/bower_components/admin-lte/dist/img/user2-160x160.jpg") }}" class="user-image" alt="User Image"/>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ $usuario }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="{{ asset("/bower_components/admin-lte/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image" />
                            <p>
                                {{ $usuario }} - {{ $ocupacion }}
                                <small>Miembro desde {{ $alta }}</small>
                            </p>
                        </li>
                        <!-- Menu Body 
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </li>
                        -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="perfil" class="btn btn-default btn-flat">Perfil</a>
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