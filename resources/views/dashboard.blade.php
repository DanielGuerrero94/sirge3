@extends('content')
@section('content')
<!-- INDICADORES GRANDES -->
<div class="row">
	<div class="col-lg-3 col-xs-6">
	  <!-- small box -->
	  <div class="small-box bg-aqua">
	    <div class="inner">
	      <h3>53.2 M</h3>
	      <p>PRESTACIONES</p>
	    </div>
	    <div class="icon">
	      <i class="ion ion-ios-pulse-strong"></i>
	    </div>
	    <a href="#" class="small-box-footer">
	      Info <i class="fa fa-arrow-circle-right"></i>
	    </a>
	  </div>
	</div><!-- ./col -->
	<div class="col-lg-3 col-xs-6">
	  <!-- small box -->
	  <div class="small-box bg-aqua">
	    <div class="inner">
	      <h3>9076</h3>
	      <p>EFECTORES</p>
	    </div>
	    <div class="icon">
	      <i class="ion ion-ios-medkit"></i>
	    </div>
	    <a href="#" class="small-box-footer">
	      Info <i class="fa fa-arrow-circle-right"></i>
	    </a>
	  </div>
	</div><!-- ./col -->
	<div class="col-lg-3 col-xs-6">
	  <!-- small box -->
	  <div class="small-box bg-aqua">
	    <div class="inner">
	      <h3>44</h3>
	      <p>USUARIOS</p>
	    </div>
	    <div class="icon">
	      <i class="ion ion-person"></i>
	    </div>
	    <a href="#" class="small-box-footer">
	      Info <i class="fa fa-arrow-circle-right"></i>
	    </a>
	  </div>
	</div><!-- ./col -->
	<div class="col-lg-3 col-xs-6">
	  <!-- small box -->
	  <div class="small-box bg-aqua">
	    <div class="inner">
	      <h3>13.5 M</h3>
	      <p>BENEFICIARIOS</p>
	    </div>
	    <div class="icon">
	      <i class="ion ion-ios-people"></i>
	    </div>
	    <a href="#" class="small-box-footer">
	      Info <i class="fa fa-arrow-circle-right"></i>
	    </a>
	  </div>
	</div><!-- ./col -->
</div>
<!-- FIN INDICADORES GRANDES -->

<!-- INDICADORES DE PROGRESO -->
<div class="row">
	<div class="col-md-8">
		<div class="box box-warning">
			<div class="box-header with-border">
	          <h3 class="box-title">Informaci&oacute;n r&aacute;pida</h3>
	        </div>
	        <div class="box-body no-padding">
	        	<div class="row">
	        		<div class="col-md-9 col-sm-8">
						<div id="map-container"></div>
					</div>
					<div class="col-md-3 col-sm-4">
						<div class="pad box-pane-right bg-orange" style="min-height: 280px">
                        <div class="description-block margin-bottom">
                          <div class="sparkbar pad" data-color="#fff">
                      		<span class="inlinesparkline">6,4,4,7,5,9,10</span>
	                  	</div>
						<h5 class="description-header">8390</h5>
						<span class="description-text">Visitas</span>
                        </div><!-- /.description-block -->
                        <div class="description-block margin-bottom">
                          <div class="sparkbar pad" data-color="#fff">
                          	<span class="inlinesparkline">6,4,4,7,5,9,10</span>
                          </div>
                          <h5 class="description-header">36</h5>
                          <span class="description-text">Efectores nuevos</span>
                        </div><!-- /.description-block -->
                        <div class="description-block">
                          <div class="sparkbar pad" data-color="#fff">
                          	<span class="inlinesparkline">2,2,1,1,3,1,2</span>
                          </div>
                          <h5 class="description-header">12</h5>
                          <span class="description-text">Usuarios nuevos</span>
                        </div><!-- /.description-block -->
                      </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
	  <div class="info-box bg-lime">
	    <span class="info-box-icon"><i class="fa fa-stethoscope"></i></span>
	    <div class="info-box-content">
	      <span class="info-box-text">PRESTACIONES</span>
	      <span class="info-box-number">41,410</span>
	      <div class="progress">
	        <div class="progress-bar" style="width: 30%"></div>
	      </div>
	      <span class="progress-description">
	        Enero 2015
	      </span>
	    </div><!-- /.info-box-content -->
	  </div><!-- /.info-box -->
	  <div class="info-box bg-lime">
	    <span class="info-box-icon"><i class="fa fa-file-text"></i></span>
	    <div class="info-box-content">
	      <span class="info-box-text">Comprobantes</span>
	      <span class="info-box-number">340</span>
	      <div class="progress">
	        <div class="progress-bar" style="width: 70%"></div>
	      </div>
	      <span class="progress-description">
	        Enero 2015
	      </span>
	    </div><!-- /.info-box-content -->
	  </div><!-- /.info-box -->
	  <div class="info-box bg-lime">
	    <span class="info-box-icon"><i class="fa fa-usd"></i></span>
	    <div class="info-box-content">
	      <span class="info-box-text">Uso de Fondos</span>
	      <span class="info-box-number">9</span>
	      <div class="progress">
	        <div class="progress-bar" style="width: 100%"></div>
	      </div>
	      <span class="progress-description">
	        Enero 2015
	      </span>
	    </div><!-- /.info-box-content -->
	  </div><!-- /.info-box -->
	  <div class="info-box bg-lime">
	    <span class="info-box-icon"><i class="fa fa-database"></i></span>
	    <div class="info-box-content">
	      <span class="info-box-text">Puco</span>
	      <span class="info-box-number">13,341,232</span>
	      <div class="progress">
	        <div class="progress-bar" style="width: 80%"></div>
	      </div>
	      <span class="progress-description">
	        Enero 2015
	      </span>
	    </div><!-- /.info-box-content -->
	  </div><!-- /.info-box -->
	</div>
</div>
<!-- FIN INDICADORES DE PROGRESO -->

<div class="row">
    
    <div class="col-md-6">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Noticias</h2>
			</div>
			<div class="box-body">
			<a class="twitter-timeline" data-chrome="noheader" lang="es" data-height="320" href="https://twitter.com/GustavoHeineken/lists/sirge" data-widget-id="661775470397100032">Tweets de https://twitter.com/GustavoHeineken/lists/sirge</a>
			</div>
		</div>
	</div>

    <div class="col-md-6">
    	<div class="box box-warning">
    		 <div class="box-header with-border">
		      <h3 class="box-title">Calendario</h3>
		    </div><!-- /.box-header -->
		    <div class="box-body no-padding">
		    	<div id="calendar"></div>	
		    </div>
    	</div>
    </div>
</div>

<div class="row">

	<div class="col-md-4">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Beneficiarios</h2>
			</div>
			<div class="box-body">
				<div class="g1" style="height: 300px;"></div>
			</div>
		</div>
    </div><!-- /.col -->

    <div class="col-md-4">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Facturación</h2>
			</div>
			<div class="box-body">
				
			</div>
		</div>
    </div><!-- /.col -->

    <div class="col-md-4">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Uso de Fondos</h2>
			</div>
			<div class="box-body">
				
			</div>
		</div>
    </div><!-- /.col -->

</div>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<script type="text/javascript">

	$('.g1').highcharts({
		title: {
            text: '',
        },
        xAxis: {
            categories: {!! $meses !!}
        },
        yAxis: {
            title: {
                text: ''
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }],
            labels : {
            	enabled : false
            }
        },
        legend: {
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom',
            borderWidth: 0
        },
        series: {!! $series !!}
    	
	});
	
	$('#map-container').highcharts('Map', {
		title : {
			text : ''
		},
		mapNavigation: {
			enabled: true,
			buttonOptions: {
				verticalAlign: 'bottom'
			}
		},
		colorAxis: {
			min: 0
		},
		series : [{
			//data : geo,
			mapData: Highcharts.maps['countries/ar/ar-all'],
			joinBy: 'hc-key',
			name: 'Población',
			states: {
				hover: {
					color: '#BADA55'
				}
			},
			dataLabels: {
				enabled: false,
				format: '{point.name}'
			},/*
			point : {
				events : {
					click : InfoProvincia
				}
			},*/
			cursor : 'pointer'
		}]
	});
	

	$('.inlinesparkline').sparkline('html' , {
		type : 'bar',
		barColor : 'white',
		barWidth : '7',
		height : '40',
		chartRangeMin : '0'
	});

	$('#calendar').fullCalendar({
		height: 340,
		lang: 'es',
		googleCalendarApiKey : 'AIzaSyAY1AZ5aKTuMen9SBQcXmc9xtnXZkxYep8',
		events : {
			googleCalendarId : 'sirgeweb@gmail.com'
		}
	});
</script>
@endsection