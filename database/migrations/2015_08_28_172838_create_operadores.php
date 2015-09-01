<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperadores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes.operadores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_usuario');
            $table->integer('id_grupo');
            $table->char('habilitado', 1);
            $table->timestamps();

            $table->unique(['id_usuario','id_grupo']);
            $table->foreign('id_usuario')->references('sistema.usuarios')->on('id_usuario');
            $table->foreign('id_grupo')->references('solicitudes.grupos')->on('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('solicitudes.operadores');
    }
}
