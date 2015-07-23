@extends('content')
@section('content')
<!-- Contact list -->
<link href="{{ asset("/dist/css/rotating-card.css") }}" rel="stylesheet" type="text/css" />
<div>
	<div class="col-md-3" style="border: solid 1px red;">
		<form class="navbar-form navbar-left" role="search">
		  <div class="form-group">
		    <input type="text" class="form-control" placeholder="Contacto">
		  </div>
		  <button type="submit" class="btn btn-default">Buscar</button>
		</form>
		<div class="container" style="margin-top:20px;">
	  		<div class="row">
		    <div class="col-md-12">
		    @foreach ($contactos as $contacto)
		      <div class="media">
		        <a href="#" class="pull-left usuario" id-usuario="{{ $contacto['id_usuario'] }}">
		        	<img src="http://localhost/sirge3/public/bower_components/admin-lte/dist/img/user2-160x160.jpg" class="user-image img-circle" alt="User Image" style="width: 48px; height: 48px;">
		        </a>
		        <div class="media-body">
		          <h4 class="media-heading usuario" id-usuario="{{ $contacto['id_usuario'] }}"><a href="#">{{ $contacto['nombre'] }}</a></h4>
		          <p class="small">Ciudad Autónoma de Buenos Aires</p>
		          <p class="small"><span class="glyphicon glyphicon-time timestamp" data-toggle="tooltip" data-placement="bottom" ></span> 02 mayo 2015</p>
		        </div>
		      </div>    
		    @endforeach
		    </div>
		  </div>
		</div>
	</div>
	<div class="col-md-4" id="small-profile" style="border: solid 1px red;">
		<div class="card-container manual-flip">
            <div class="card">
                <div class="front">
                    <div class="cover">
                        <img src="{{asset ("/dist/img/header-sumar.png") }}"/>
                    </div>
                    <div class="user">
                        <img src="http://localhost/sirge3/public/bower_components/admin-lte/dist/img/user2-160x160.jpg" class="user-image img-circle" alt="User Image">
                    </div>
                    <div class="content">
                        <div class="main">
                            <h3 class="name">Gustavo Hekel</h3>
                            <p class="profession">Desarrollador PHP Sr.</p>
                            <p class="text-center"><button type="button" class="btn btn-info btn-sm">Enviar mensaje</button></p>
                            <h5><i class="fa fa-map-marker fa-fw text-muted"></i> Ciudad Autónoma de Buenos Aires.</h5>
                            <h5><i class="fa fa-building-o fa-fw text-muted"></i> Unidad Ejecutora Central. </h5>
                            <h5><i class="fa fa-envelope-o fa-fw text-muted"></i> gustavo.hekel@gmail.com</h5>

                        </div>
                        <div class="footer">
                            <button class="btn btn-simple" onclick="rotateCard(this)">
                                <i class="fa fa-mail-forward"></i> Ver m&aacute;s
                            </button>
                        </div>
                    </div>
                </div> <!-- end front panel -->
                <div class="back">
                    <div class="header">
                        <h5 class="motto">"To be or not to be, this is my awesome motto!"</h5>
                    </div> 
                    <div class="content">
                        <div class="main">
                            <h4 class="text-center">Experince</h4>
                            <p>Inna was working with our team since 2012.</p>
                            <h4 class="text-center">Areas of Expertise</h4>
                            <p>Web design, Adobe Photoshop, HTML5, CSS3, Corel and many others...</p>
                        </div>
                    </div>
                    <div class="footer">
                    	<button class="btn btn-simple" rel="tooltip" title="" onclick="rotateCard(this)" data-original-title="Flip Card">
                            <i class="fa fa-reply"></i> Atr&aacute;s
                        </button>
                        <div class="social-links text-center">
                            <a href="http://creative-tim.com" class="facebook"><i class="fa fa-facebook fa-fw"></i></a>
                            <a href="http://creative-tim.com" class="google"><i class="fa fa-google-plus fa-fw"></i></a>
                            <a href="http://creative-tim.com" class="twitter"><i class="fa fa-twitter fa-fw"></i></a>
                        </div>
                    </div>
                </div> <!-- end back panel -->
            </div> <!-- end card -->
        </div> <!-- end card-container -->
	</div>
	<div class="col-md-2"></div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('.usuario').click(function(event){
		event.preventDefault();
		alert($(this).attr('id-usuario'))
	});

	

});

function rotateCard(btn){
        var $card = $(btn).closest('.card-container');
        console.log($card);
        if($card.hasClass('hover')){
            $card.removeClass('hover');
        } else {
            $card.addClass('hover');
        }
    }
</script>
@endsection