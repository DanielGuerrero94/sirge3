@extends('content')
@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/cropper/dist/cropper.css") }}">
<link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/cropper/dist/main.css") }}">

<div class="container" id="crop-avatar">

    <!-- Current avatar -->
    <div class="avatar-view" title="Change the avatar">
      <img src="{{ asset("/dist/img/usuarios/") . '/' . $user->ruta_imagen }}" alt="Avatar">
    </div>

    <!-- Cropping modal -->
    <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form class="avatar-form" action="usuario-imagen" enctype="multipart/form-data" method="post">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="avatar-modal-label">Cambiar imágen</h4>
            </div>
            <div class="modal-body">
              <div class="avatar-body">

                <!-- Upload image and data -->
                <div class="avatar-upload">
                  <input type="hidden" class="avatar-src" name="avatar_src">
                  <input type="hidden" class="avatar-data" name="avatar_data">
                  <label for="avatarInput">Archivo local</label>
                  <input type="file" class="avatar-input" id="avatarInput" name="avatar_file">
                </div>

                <!-- Crop and preview -->
                <div class="row">
                  <div class="col-md-9">
                    <div class="avatar-wrapper"></div>
                  </div>
                  <div class="col-md-3">
                    <div class="avatar-preview preview-lg"></div>
                    <div class="avatar-preview preview-md"></div>
                    <div class="avatar-preview preview-sm"></div>
                  </div>
                </div>

                <div class="row avatar-btns">
                  <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-block avatar-save">Listo!</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> -->
          </form>
        </div>
      </div>
    </div><!-- /.modal -->
  </div>

<script type="text/javascript" src="{{ asset("/bower_components/cropper/dist/cropper.js") }}"></script>
<script type="text/javascript" src="{{ asset("/bower_components/cropper/dist/main.js") }}"></script>
<script type="text/javascript">
$(document).ready(function(){
	
});
</script>
@endsection