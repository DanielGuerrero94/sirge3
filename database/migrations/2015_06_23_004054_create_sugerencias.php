<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSugerencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sistema.sugerencias', function (Blueprint $table) {
            $table->increments('id_sugerencia');
            $table->integer('id_usuario');
            $table->text('sugerencia');
            $table->timestamps();

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
        Schema::drop('sistema.sugerencias');
    }
}
