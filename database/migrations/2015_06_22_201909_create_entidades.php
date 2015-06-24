<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntidades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sistema.entidades', function (Blueprint $table) {
            $table->increments('id_entidad');
            $table->integer('id_tipo_entidad');
            $table->integer('id_region');
            $table->string('descripcion' , 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sistema.entidades');
    }
}
