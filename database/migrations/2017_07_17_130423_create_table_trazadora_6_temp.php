<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrazadora6Temp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trazadoras.trz_6_temp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('periodo');
            $table->char('cuie', 6);
            $table->string('numero_documento', 12);
            $table->date('fecha_diagnostico')->nullable();
            $table->date('fecha_denuncia')->nullable();
            $table->string('cardiopatia_detectada', 3)->nullable();
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
        Schema::drop('trazadoras.trz_6_temp');
    }
}
