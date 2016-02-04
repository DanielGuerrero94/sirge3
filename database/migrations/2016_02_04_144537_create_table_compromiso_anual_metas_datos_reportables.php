<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCompromisoAnualMetasDatosReportables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compromiso_anual.metas_datos_reportables', function(Blueprint $table)
        {
            $table->char('id_provincia', 2);
            $table->float('primer_cuatrimestre')->nullable();
            $table->float('segundo_cuatrimestre')->nullable();
            $table->float('tercer_cuatrimestre')->nullable();
            $table->integer('year');
            $table->primary(['id_provincia', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('compromiso_anual.metas_datos_reportables');
    }
}
