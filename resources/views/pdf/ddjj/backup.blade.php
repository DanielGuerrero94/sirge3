<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap 3.3.2 -->
    <link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}"  />
    <!-- Theme style -->
    <link rel="stylesheet" type="text/css" href="{{ asset("/bower_components/admin-lte/dist/css/AdminLTE.css")}}"  />
    <style type="text/css">
    	tbody:before, tbody:after { display: none; }
      	.footer { position: fixed; bottom: 60px; }
      	.page {  margin-left: 49%; }
      	.pagenum:before { content: counter(page); }
      	.resumen , .lugar-dia-hora { text-align: right;}
      	td { text-align: center;  border: solid 1px black; height: 40px; font-weight: bold;}
      	p , li { line-height: 1.5em }
      	body { font-size: 13px}
	</style>
</head>
<body>
<img src="{{ asset("/dist/img/header-sumar.png") }}" style="width: 100%;">
  <div style="text-align: right">
    <i>{{ $mensaje->valor }}</i>
  </div>
  <hr />
  <table style="width: 100%">
    <tr>
      <td>FORMULARIO BACKUP DE DATOS DE INSCRIPCION</td>
      <td>Nº {{ $ddjj->id_provincia}}/{{ $ddjj->periodo_reportado}}</td>
    </tr>
  </table>
  <p class="lugar-dia-hora"><b>{{ ucwords(strtolower($ddjj->provincia->descripcion)) }} , {{ $fecha_impresion }}</b></p>
  <p style="font-weight: bold">
    SEÑOR <br/>
    RESPONSABLE DEL ÁREA SISTEMAS INFORMÁTICOS <br />
    JAVIER E. MINSKY
  </p>
  <p style="text-indent: 2em;">
    Por la presente, certifico que el día {{$ddjj->fecha_backup}} se ha realizado por duplicado la Copia de Resguardo Completa de la
Base de Datos de Inscripción referente al período {{$ddjj->periodo_reportado}} en el archivo {{$ddjj->nombre_backup}}.
  </p>
  <p style="text-indent: 2em;">
    Dejo constancia bajo juramento que la información enviada en esta nota es exacta y verdadera y que las copias han
sido elaboradas y resguardadas siguiendo todos los procedimientos razonables para garantizar la mayor exactitud posible. Las
mismas se encuentran a disposición de cualquier autoridad competente que las requiera.
  </p>
  <p>
    Sin otro particular, saludo a Ud. cordialmente
  </p>
  <div class="footer">
    <div style="margin-left:60%; width: 40%; text-align: left;">
      <p style="border-top: 1px solid; text-align: center;">Firma y sello del Coordinador Ejecutivo</p>
    </div>
    <hr />
    <div class="page">
      Página: <span class="pagenum"></span>
    </div>
  </div>