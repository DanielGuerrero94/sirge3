<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrestacionesDoiPagadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestaciones.prestaciones_doi_pagadas', function (Blueprint $table) {
        $table->increments('id');
	$table->char('id_provincia', 2)->nullable();
	//Es unique en conjunto con la provincia
        $table->integer('id_prestacion')->nullable();
        $table->string('prestacion_codigo', 11)->nullable();
	$table->char('cuie', 6)->nullable();
	$table->date('prestacion_fecha')->nullable();
	$table->string('beneficiario_apellido', 100)->nullable();
	$table->string('beneficiario_nombre', 100)->nullable();
	$table->string('beneficiario_clave', 16)->nullable();
	$table->char('beneficiario_tipo_documento', 3)->nullable();
	$table->char('beneficiario_clase_documento', 1)->nullable();
	$table->string('beneficiario_nro_documento', 14)->nullable();
	$table->char('beneficiario_sexo', 1)->nullable();
	$table->date('beneficiario_nacimiento')->nullable();

	$table->decimal('valor_unitario_facturado', 7, 2)->nullable();
	$table->integer('cantidad_facturado')->nullable();
	$table->decimal('importe_prestacion_facturado', 9, 2)->nullable();
	//Es unique en conjunto con la provincia pero puede tener varias prestaciones
	$table->integer('id_factura'); 
	$table->string('factura_nro', 100)->nullable();
	$table->date('factura_fecha')->nullable();
	$table->decimal('factura_importe_total', 9, 2)->nullable();
	$table->date('factura_fecha_recepcion')->nullable();
	$table->char('alta_complejidad', 1)->nullable();
	//Liquidadas
	
$table->integer('id_liquidacion')->nullable();
$table->date('liquidacion_fecha')->nullable();
$table->decimal('valor_unitario_aprobado', 7, 2)->nullable();
$table->integer('cantidad_aprobada')->nullable();
$table->decimal('importe_prestacion_aprobado', 9, 2)->nullable();

	//Pagadas
$table->integer('id_dato_reportable_1')->nullable();
$table->string('dato_reportable_1')->nullable();
$table->integer('id_dato_reportable_2')->nullable();
$table->string('dato_reportable_2')->nullable();
$table->integer('id_dato_reportable_3')->nullable();
$table->string('dato_reportable_3')->nullable();
$table->integer('id_dato_reportable_4')->nullable();
$table->string('dato_reportable_4')->nullable();
$table->integer('id_op')->nullable();
$table->string('numero_op', 100)->nullable();
$table->date('fecha_op')->nullable();
$table->decimal('importe_total_op', 7, 2)->nullable();
$table->string('numero_expte', 100)->nullable();
$table->date('fecha_debito_bancario')->nullable();
$table->decimal('importe_debito_bancario', 9, 2)->nullable();
$table->date('fecha_notificacion_efector')->nullable();



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
        Schema::drop('prestaciones.prestaciones_doi_pagadas');
    }
}
