@extends('content')
@section('content')
<!-- INDICADORES GRANDES -->
<div class="row">
	<div class="col-lg-3 col-xs-6">
		<!-- small box -->
		<div class="small-box bg-aqua">
			<div class="inner">
				<h3>{{$total_prestaciones}}</h3>
				<p>PRESTACIONES</p>
			</div>
			<div class="icon">
				<i class="ion ion-ios-pulse-strong"></i>
			</div>
			<a href="prestaciones-evolucion" class="ajax-href small-box-footer">
				Info <i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div><!-- ./col -->
	<div class="col-lg-3 col-xs-6">
		<!-- small box -->
		<div class="small-box bg-aqua">
			<div class="inner">
				<h3>{{$total_efectores}}</h3>
				<p>EFECTORES ACTIVOS</p>
			</div>
			<div class="icon">
				<i class="ion ion-ios-medkit"></i>
			</div>
			<a href="efectores-listado" class="ajax-href small-box-footer">
				Info <i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div><!-- ./col -->
	<div class="col-lg-3 col-xs-6">
		<!-- small box -->
		<div class="small-box bg-aqua">
			<div class="inner">
				<h3>{{$total_usuarios}}</h3>
				<p>USUARIOS ACTIVOS</p>
			</div>
			<div class="icon">
				<i class="ion ion-person"></i>
			</div>
			<a href="contactos" class="ajax-href small-box-footer">
				Info <i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div><!-- ./col -->
	<div class="col-lg-3 col-xs-6">
		<!-- small box -->
		<div class="small-box bg-aqua">
			<div class="inner">
				<h3>{{$total_beneficiarios}}</h3>
				<p>BENEFICIARIOS ACTIVOS</p>
			</div>
			<div class="icon">
				<i class="ion ion-ios-people"></i>
			</div>
			<a href="beneficiarios-listado" class="ajax-href small-box-footer">
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
									<span class="inlinesparkline">{{$visitas}}</span>
								</div>
								<h5 class="description-header">{{$visitas_total}}</h5>
								<span class="description-text">Visitas</span>
							</div><!-- /.description-block -->
							<div class="description-block margin-bottom">
								<div class="sparkbar pad" data-color="#fff">
									<span class="inlinesparkline">{{$efectores}}</span>
								</div>
								<h5 class="description-header">{{$efectores_total}}</h5>
								<span class="description-text">Efectores</span>
							</div><!-- /.description-block -->
							<div class="description-block">
								<div class="sparkbar pad" data-color="#fff">
									<span class="inlinesparkline">{{$usuarios}}</span>
								</div>
								<h5 class="description-header">{{$usuarios_total}}</h5>
								<span class="description-text">Usuarios</span>
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
				<span class="info-box-number">{{$mes_prestaciones}}</span>
				<div class="progress">
					<div class="progress-bar" style="width: {{$porcentaje_prestaciones}}%"></div>
				</div>
				<span class="progress-description">
					{{$mes}}
				</span>
			</div><!-- /.info-box-content -->
		</div><!-- /.info-box -->
		<div class="info-box bg-lime">
			<span class="info-box-icon"><i class="fa fa-file-text"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Comprobantes</span>
				<span class="info-box-number">{{$mes_comprobantes}}</span>
				<div class="progress">
					<div class="progress-bar" style="width: {{$porcentaje_comprobantes}}%"></div>
				</div>
				<span class="progress-description">
					{{$mes}}
				</span>
			</div><!-- /.info-box-content -->
		</div><!-- /.info-box -->
		<div class="info-box bg-lime">
			<span class="info-box-icon"><i class="fa fa-usd"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Uso de Fondos</span>
				<span class="info-box-number">{{$mes_fondos}}</span>
				<div class="progress">
					<div class="progress-bar" style="width: {{$porcentaje_fondos}}%"></div>
				</div>
				<span class="progress-description">
					{{$mes}}
				</span>
			</div><!-- /.info-box-content -->
		</div><!-- /.info-box -->
		<div class="info-box bg-lime">
			<span class="info-box-icon"><i class="fa fa-database"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Puco</span>
				<span class="info-box-number">{{$mes_puco}}</span>
				<div class="progress">
					<div class="progress-bar" style="width: {{$porcentaje_puco}}%"></div>
				</div>
				<span class="progress-description">
					{{$mes}}
				</span>
			</div><!-- /.info-box-content -->
		</div><!-- /.info-box -->
	</div>
</div>
<!-- FIN INDICADORES DE PROGRESO -->

<div class="row">

	<div class="col-md-8">
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
				<div class="g2" style="height: 300px;"></div>
			</div>
		</div>
	</div><!-- /.col -->

	<!-- <div class="col-md-4">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Uso de Fondos</h2>
			</div>
			<div class="box-body">
				<div class="g3" style="height: 300px;"></div>
			</div>
		</div>
	</div><!-- /.col --> -->

</div>

<div class="row">

	<div class="col-md-3">
		<div class="box box-info">
			<div class="box-header">
				<h2 class="box-title">Noticias</h2>
			</div>
			<div class="box-body">
				<a class="twitter-timeline" data-chrome="noheader" lang="es" data-height="320" href="https://twitter.com/GustavoHeineken/lists/sirge" data-widget-id="661775470397100032">Tweets de https://twitter.com/GustavoHeineken/lists/sirge</a>
			</div>
		</div>
	</div>

	<div class="col-md-9">
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

<div class="modal fade modal-info">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				<p id="modal-text"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
				<button type="button" id="google-event-details" class="btn btn-outline pull-right" data-dismiss="modal">Ver detalles</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>


<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<script type="text/javascript">

	$('.ajax-href').click(function(event){
		event.preventDefault();
		var href = $(this).attr('href');
		$.get(href , function(data){
			$('.content-wrapper').html(data);
		});
	})

	// Make monochrome colors and set them as default for all pies
	Highcharts.getOptions().plotOptions.pie.colors = (function () {
		var colors = [],
		base = Highcharts.getOptions().colors[8],
		i;

		for (i = 0; i < 10; i += 1) {
            // Start out with a darkened base color (negative brighten), and end
            // up with a much brighter color
            colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());
        }
        return colors;
    }());

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
		plotOptions: {
			line: {
				dataLabels: {
					enabled: true,
					style: {"color": "contrast", "fontSize": "12px", "fontWeight": "bold", "textOutline": "1px 1px contrast" }
				},
				enableMouseTracking: false
			}
		},		
		subtitle: {
			text: 'Fuente: SIRGe Web.'
		},
		legend: {
			layout: 'horizontal',
			align: 'center',
			verticalAlign: 'bottom',
			borderWidth: 0
		},
		series: {!! $grafico_ceb !!}

	});

	$('.g2').highcharts({
		chart: {
			type: 'area'
		},
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
		series: {!! $grafico_fc !!}
	});

	/*$('.g3').highcharts({
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'pie'
		},
		title: {
			text: ''
		},
		tooltip: {
			pointFormat: '{series.name}: <b>${point.y}</b> : {point.percentage:.1f} %'
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: false,
					format: '<b>{point.name}</b>: {point.percentage:.1f} %',
					style: {
						color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
					}
				}
			}
		},
		series: [{
			name: 'Monto',
			colorByPoint: true,
			data: {!! $grafico_af !!}
		}]
	});*/
	
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
			data : {!! $map !!},
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
			},
			tooltip : {
				pointFormatter : function(){
					var html = '';
					html += 'Poblacion : ' + Highcharts.numberFormat(this.value , 0) + '<br />';
					html += 'Inscriptos : ' + Highcharts.numberFormat(this.inscriptos , 0) + '<br />';
					html += 'Activos : ' + Highcharts.numberFormat(this.activos , 0) + '<br />';
					html += 'C.E.B. : ' + Highcharts.numberFormat(this.ceb , 0) + '<br />';
					return html;
				}
			},

			/*
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

	$("#google-event-details").on('click', function(event) {		
		window.open($(this).attr('href'));		
	});

	$('#calendar').fullCalendar({
		height: 550,		
		lang: 'es',
		eventClick: function(event) {
			console.log(event);
			if (event.url) {
	            //window.open(event.url);
	            $('.modal-title').html(event.title);
	            var text = '';	            
	            text += '<ul>';
	            text += '<li><b>D&iacute;a:</b> ' + moment(event.start).format('DD/MM/YYYY') + '</li>';
	            text += '<li><b>Desde:</b> ' + moment(event.start).format('hh:mm') + '</li>';
	            text += '<li><b>Hasta:</b> ' + moment(event.end).format('hh:mm') + '</li>';
	            text += '<li><b>Descripci&oacute;n:</b> ' + (event.description === undefined ? 'Sin datos' : event.description) + '</li>';	            
	            text += '<li><b>Ubicaci&oacute;n:</b> ' + (event.location === undefined ? 'Sin datos' : event.location) + '</li>';  
	            text += '</ul>';				

	            $('#modal-text').html(text);	            
	            $('.modal-footer #google-event-details').attr('href', event.url);
	            $('.modal').modal();
	            return false;
	        }

	    },
	    googleCalendarApiKey : 'AIzaSyAY1AZ5aKTuMen9SBQcXmc9xtnXZkxYep8',
	    events : {
	    	googleCalendarId : 'sirgeweb@gmail.com'
	    }
	});
</script>
@endsection