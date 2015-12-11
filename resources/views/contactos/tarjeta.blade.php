<link href="{{ asset("/dist/css/rotating-card.css") }}" rel="stylesheet" type="text/css" />
<div class="card-container manual-flip">
    <div class="card">
        <div class="front">
            <div class="cover">
                <img src="{{asset ("/dist/img/Sumar_4.3.png") }}"/>
            </div>
            <div class="user">
                <img src="{{asset ("/dist/img/usuarios/$usuario->ruta_imagen") }}" class="user-image img-circle" alt="User Image">
            </div>
            <div class="content">
                <div class="main">
                    <h3 class="name">{{ $usuario->nombre }}</h3>
                    <p class="profession">{{ $usuario->ocupacion }}</p>
                    <p class="text-center"><button id="enviar-mensaje" id-usuario="{{ $usuario->id_usuario }}" type="button" class="btn btn-info btn-sm">Enviar mensaje</button></p>
                    <h5><i class="fa fa-map-marker fa-fw text-muted"></i> {{ $usuario->provincia->descripcion }} </h5>
                    <h5><i class="fa fa-building-o fa-fw text-muted"></i> Unidad Ejecutora Central. </h5>
                    <h5><i class="fa fa-envelope-o fa-fw text-muted"></i> {{ $usuario->email }} </h5>
                    <h5><i class="fa fa-phone fa-fw text-muted"></i> {{ $usuario->telefono }} </h5>
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
                <h5 class="motto">"{{$usuario->mensaje}}"</h5>
            </div> 
            <div class="content">
                <div class="main">
                    <h4 class="text-center">Experiencia</h4>
                    <p>Miemrbo del Programa SUMAR / Plan Nacer desde Octubre de 2012.</p>
                    <h4 class="text-center">Cumpleaños</h4>
                    <p class="text-center"><i class="fa fa-birthday-cake"></i> {{ date ('d M', strtotime($usuario->fecha_nacimiento)) }}</p>
                </div>
            </div>
            <div class="footer">
            	<button class="btn btn-simple" rel="tooltip" title="" onclick="rotateCard(this)" data-original-title="Flip Card">
                    <i class="fa fa-reply"></i> Atr&aacute;s
                </button>
                <div class="social-links text-center">
                    <a href="{{ strlen($usuario->facebook) ? $usuario->facebook : '#' }}" class="facebook"><i class="fa fa-facebook fa-fw"></i></a>
                    <a href="{{ strlen($usuario->google) ? $usuario->google : '#' }}" class="google"><i class="fa fa-google-plus fa-fw"></i></a>
                    <a href="{{ strlen($usuario->twitter) ? $usuario->twitter : '#' }}" class="twitter"><i class="fa fa-twitter fa-fw"></i></a>
                    <a href="{{ strlen($usuario->skype) ? $usuario->skype : '#' }}" class="skype"><i class="fa fa-skype fa-fw"></i></a>
                    <a href="{{ strlen($usuario->linkedin) ? $usuario->linkedin : '#' }}" class="linkedin"><i class="fa fa-linkedin-square fa-fw"></i></a>
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