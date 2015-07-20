<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <!--
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset("/bower_components/admin-lte/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <!-- Status -->
                <!--
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        -->
        <!-- search form (Optional) -->
        <!--
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
<span class="input-group-btn">
  <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
</span>
            </div>
        </form>
        <!-- /.search form -->
        
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">MENU PRINCIPAL</li>
            @foreach ($modulos as $key_padre => $modulo)
                @if ($modulo['arbol'] === 'S')
                    <li class="treeview">
                        <a href="#"><i class="fa {{ $modulo['icono'] }}"></i><span>{{ $modulo['descripcion'] }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            @foreach ($modulo['hijos'] as $key_hijo => $modulo_hijo)
                            <li><a href="{{ $modulo_hijo['modulo'] }}">{{ $modulo_hijo['descripcion'] }}</a></li>
                            @endforeach
                        </ul>
                    </li>        
                @else
                    <li><a href="{{ $modulo['modulo'] }}"><i class="fa {{ $modulo['icono'] }}"></i><span>{{ $modulo['descripcion'] }}</span></a></li>
                @endif
            @endforeach
            <!-- Optionally, you can add icons to the links 
            <li class="active"><a href="#"><span>Link</span></a></li>
            <li><a href="prueba" id="prueba"><span>PRUEBA</span></a></li>
            <li class="treeview">
                <a href="#"><span>Multilevel</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">Link in level 2</a></li>
                    <li><a href="#">Link in level 2</a></li>
                </ul>
            </li>
            -->
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>