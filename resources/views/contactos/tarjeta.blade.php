<div class="card-container manual-flip">
    <div class="card">
        <div class="front">
            <div class="cover">
                <img src="{{asset ("/dist/img/Sumar_4.3.png") }}"/>
            </div>
            <div class="user">
                <img src="http://localhost/sirge3/public/bower_components/admin-lte/dist/img/user2-160x160.jpg" class="user-image img-circle" alt="User Image">
            </div>
            <div class="content">
                <div class="main">
                    <h3 class="name">{{ $usuario->nombre }}</h3>
                    <p class="profession">{{ $usuario->ocupacion }}</p>
                    <p class="text-center"><button type="button" class="btn btn-info btn-sm">Enviar mensaje</button></p>
                    <h5><i class="fa fa-map-marker fa-fw text-muted"></i> {{ $usuario->provincia->descripcion }} </h5>
                    <h5><i class="fa fa-building-o fa-fw text-muted"></i> Unidad Ejecutora Central. </h5>
                    <h5><i class="fa fa-envelope-o fa-fw text-muted"></i> {{ $usuario->email }} </h5>

                </div>
                <div class="footer">
                    <button class="btn btn-simple" onclick="rotateCard(this)">
                        <i class="fa fa-mail-forward"></i> Ver m&aacute;s
                    </button>
                </div>
            </div>
        </div>
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
        </div> 
    </div> 
</div> 
<script type="text/javascript">
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