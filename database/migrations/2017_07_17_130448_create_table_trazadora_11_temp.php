<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrazadora11Temp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trazadoras.trz_11_temp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('periodo');
            $table->char('cuie', 6);
            $table->string('numero_documento', 12);
            $table->date('fecha_asistencia_taller')->nullable();
            $table->string('tema_taller', 4)->nullable();
            $table->string('indice_conocimiento', 5)->nullable();
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
        Schema::drop('trazadoras.trz_11_temp');
    }
}
