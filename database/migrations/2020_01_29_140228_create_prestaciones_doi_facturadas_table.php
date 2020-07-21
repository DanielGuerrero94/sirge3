<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrestacionesDoiFacturadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestaciones.prestaciones_doi_facturadas', function (Blueprint $table) {
        $table->increments('id');
	$table->char('id_provincia', 2);
	//Es unique en conjunto con la provincia
        $table->integer('id_prestacion');
        $table->string('prestacion_codigo', 11);
	$table->char('cuie', 6);
	$table->date('prestacion_fecha');
	$table->string('beneficiario_apellido', 100);
	$table->string('beneficiario_nombre', 100);
	$table->string('beneficiario_clave', 16);
	$table->char('beneficiario_tipo_documento', 3);
	$table->char('beneficiario_clase_documento', 1);
	$table->string('beneficiario_nro_documento', 14);
	$table->char('beneficiario_sexo', 1);
	$table->date('beneficiario_nacimiento');

	$table->decimal('valor_unitario_facturado', 7, 2);
	$table->integer('cantidad_facturado');
	$table->decimal('importe_prestacion_facturado', 9, 2);
	//Es unique en conjunto con la provincia pero puede tener varias prestaciones
	$table->integer('id_factura'); 
	$table->integer('factura_nro');
	$table->date('factura_fecha');
	$table->decimal('factura_importe_total', 9, 2);
	$table->date('factura_fecha_recepcion');
	$table->char('alta_complejidad', 1);
            $table->timestamps();

    /**
     * Foreign keys
     */
	$table->foreign('id_provincia')->references('id_provincia')->on('geo.provincias');
	$table->foreign('prestacion_codigo')->references('codigo_prestacion')->on('pss.codigos');
	$table->foreign('cuie')->references('cuie')->on('efectores.efectores');
	$table->foreign('beneficiario_tipo_documento')->references('tipo_documento')->on('sistema.tipo_documento');
	$table->foreign('beneficiario_clase_documento')->references('clase_documento')->on('sistema.clases_documento');
	$table->foreign('beneficiario_sexo')->references('sigla')->on('sistema.sexos');

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('prestaciones.prestaciones_doi_facturadas');
    }
}
