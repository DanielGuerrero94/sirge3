<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sistema.lotes', function (Blueprint $table) {
            $table->increments('lote');
            $table->integer('id_subida');
            $table->integer('id_usuario');
            $table->integer('id_provincia');
            $table->integer('id_estado');
            $table->integer('registros_in');
            $table->integer('registros_out');
            $table->integer('registros_mod');
            $table->timestamp('inicio')->default(DB::raw('now()::timestamp(0)'));
            $table->timestamp('fin');

            $table->foreign('id_subida')->references('id_subida')->on('sistema.subidas');
            $table->foreign('id_usuario')->references('id_usuario')->on('sistema.usuarios');
            $table->foreign('id_provincia')->references('id_entidad')->on('sistema.entidades');
            $table->foreign('id_estado')->references('id_estado')->on('sistema.estados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sistema.lotes');
    }
}
