<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePssCodigosDatosReportables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pss.codigos_datos_reportables', function (Blueprint $table) {
            $table->string('codigo_prestacion', 11)->primary();            
            $table->nullableTimestamps();           
            $table->foreign('codigo_prestacion')->references('codigo_prestacion')->on('pss.codigos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pss.codigos_datos_reportables');
    }
}
