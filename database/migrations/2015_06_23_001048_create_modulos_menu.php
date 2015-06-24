<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulosMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sistema.modulos_menu', function (Blueprint $table) {
            $table->integer('id_menu');
            $table->integer('id_modulo');
            $table->timestamps();

            $table->primary(['id_menu','id_modulo']);
            $table->foreign('id_menu')->references('id_menu')->on('sistema.menues');
            $table->foreign('id_modulo')->references('id_modulo')->on('sistema.modulos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sistema.modulos_menu');
    }
}
