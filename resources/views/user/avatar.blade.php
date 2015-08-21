@extends('content')
@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/cropper/dist/cropper.css") }}">

<form id="form1">
    <input type='file' id="imgInp" />
    <div class="cropper-example-1">
    	<img id="blah" src="#" alt="your image" height="300" />
    </div>
</form>

<div class="cropper-example-2">
	<img id="avatar" src="{{ asset("/dist/img/usuarios/") . '/' . $user->ruta_imagen }}" class="img-circle">
</div>

<script type="text/javascript" src="{{ asset("/bower_components/cropper/dist/cropper.js") }}"></script>
<script type="text/javascript">
$(document).ready(function(){

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp").change(function(){
        readURL(this);
	    $('.cropper-example-1 > img').cropper({
			aspectRatio: 16 / 9,
			autoCropArea: 0.65,
			strict: false,
			guides: false,
			highlight: false,
			dragCrop: false,
			cropBoxMovable: false,
			cropBoxResizable: false
		});
    });

        

});
</script>
@endsection