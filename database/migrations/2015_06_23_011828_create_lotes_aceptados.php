<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotesAceptados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sistema.lotes_aceptados', function (Blueprint $table) {
            $table->integer('lote');
            $table->integer('id_usuario');
            $table->timestamp('fecha_aceptado');

            $table->foreign('lote')->references('lote')->on('sistema.lotes');
            $table->foreign('id_usuario')->references('id_usuario')->on('sistema.usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sistema.lotes_aceptados');
    }
}
