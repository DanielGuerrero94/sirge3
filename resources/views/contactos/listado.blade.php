@extends('content')
@section('content')
<!-- Contact list -->
<link href="{{ asset("/dist/css/contact_list.css") }}" rel="stylesheet" type="text/css" />
<div>
	<div class="col-md-4" style="border: solid 1px red;">
		<div class="container" style="margin-top:20px;">
		  <div class="row">
		    <div class="col-md-12">
		    @foreach ($contactos as $contacto)
		      <div class="media">
		        <a href="#" class="pull-left">
		        	<img src="http://localhost/sirge3/public/bower_components/admin-lte/dist/img/user2-160x160.jpg" class="user-image img-circle" alt="User Image" style="width: 48px; height: 48px;">
		        </a>
		        <div class="media-body">
		          <h4 class="media-heading"><a href="#">{{ $contacto['nombre'] }}</a></h4>
		          <p class="small">Ciudad Autónoma de Buenos Aires - UEC</p>
		          <p class="small"><span class="glyphicon glyphicon-time timestamp" data-toggle="tooltip" data-placement="bottom" ></span> 02 mayo 2015</p>
		        </div>
		      </div>    
		    @endforeach
		    </div>
		  </div>
		</div>
	</div>
	<div class="col-md-6"></div>
	<div class="col-md-2"></div>
</div>
@endsection