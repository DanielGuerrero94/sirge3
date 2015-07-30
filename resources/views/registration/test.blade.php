<head>
    <meta charset="UTF-8">
    <title>SIRGe Web</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Form CSS -->
    <link href="{{ asset("/dist/css/gsdk-base.css") }}" rel="stylesheet" type="text/css" />
</head>
<form id="commentForm" method="get" action="" class="form-horizontal">
<div id="wizard">
    <ul>
        <li><a href="#tab1" data-toggle="tab">First</a></li>
        <li><a href="#tab2" data-toggle="tab">Second</a></li>
        <li><a href="#tab3" data-toggle="tab">Third</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="tab1">
            <div class="control-group">
                <label class="control-label" for="email">Email</label>
                <div class="controls">
                  <input type="text" id="emailfield" name="emailfield" class="required email">
                </div>
              </div>
 
              <div class="control-group">
                <label class="control-label" for="name">Name</label>
                <div class="controls">
                  <input type="text" id="namefield" name="namefield" class="required">
                </div>
              </div>
        </div>
        <div class="tab-pane" id="tab2">
          <div class="control-group">
                <label class="control-label" for="url">URL</label>
                <div class="controls">
                  <input type="text" id="urlfield" name="urlfield" class="required url">
                </div>
              </div>
        </div>
        <div class="tab-pane" id="tab3">
            3
        </div>
        <ul class="pager wizard">
            <li class="previous first" style="display:none;"><a href="#">First</a></li>
            <li class="previous"><a href="#">Previous</a></li>
            <li class="next last" style="display:none;"><a href="#">Last</a></li>
            <li class="next"><a href="#">Next</a></li>
        </ul>
    </div>  
</div>
</form>
<!-- jQuery 2.1.4 -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset ("/bower_components/admin-lte/bootstrap/js/bootstrap.min.js") }}"></script>
<!-- jQuery Wizard -->
<script src="{{ asset ("/dist/js/jquery.bootstrap.wizard.js") }}"></script>
<!-- Wizard 
<script src="{{ asset ("/dist/js/wizard.js") }}"></script>
-->
<!-- Inputmask jQuery -->
<script src="{{ asset ("/dist/js/jquery.inputmask.js") }}"></script>
<!-- Inputmask -->
<script src="{{ asset ("/dist/js/inputmask.js") }}"></script>
<!-- jQuery validator -->
<script src="{{ asset ("/dist/js/jquery.validate.min.js") }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
    var $validator = $("#commentForm").validate({
          rules: {
            emailfield: {
              required: true,
              email: true,
              minlength: 3
            },
            namefield: {
              required: true,
              minlength: 3
            },
            urlfield: {
              required: true,
              minlength: 3,
              url: true
            }
          }
        });
 
        $('#wizard').bootstrapWizard({
            'tabClass': 'nav nav-pills',
            'onNext': function(tab, navigation, index) {
                alert('ok');
                var $valid = $("#commentForm").valid();
                if(!$valid) {
                    $validator.focusInvalid();
                    return false;
                }
            }
        }); 
});
</script>