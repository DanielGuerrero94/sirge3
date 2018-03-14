<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrazadora13Temp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trazadoras.trz_13_temp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('periodo');
            $table->char('cuie', 6);
            $table->string('numero_documento', 12);
            $table->date('fecha_diagnostico_histologico')->nullable();
            $table->char('carcinoma', 1)->nullable();
            $table->string('tamano', 2)->nullable();
            $table->string('ganglios_linfaticos', 2)->nullable();
            $table->string('metastasis', 2)->nullable();
            $table->string('estadio', 4)->nullable();
            $table->date('fecha_inicio_tratamiento')->nullable();
            $table->bigInteger('id_registro_provincial')->nullable();
            $table->bigInteger('id_registro')->nullable();
            $table->integer('lote');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('trazadoras.trz_13_temp');
    }
}
