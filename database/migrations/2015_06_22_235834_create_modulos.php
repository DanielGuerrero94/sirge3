<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sistema.modulos', function (Blueprint $table) {
            $table->integer('id_modulo')->unique();
            $table->integer('nivel_1');
            $table->integer('nivel_2');
            $table->string('descripcion' , 100);
            $table->string('modulo' , 100);
            $table->string('icono');
            $table->timestamps();

            $table->primary(['nivel_1','nivel_2']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sistema.modulos');
    }
}
