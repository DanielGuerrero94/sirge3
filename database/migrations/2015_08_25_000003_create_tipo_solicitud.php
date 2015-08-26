<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoSolicitud extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes.tipo_solicitud', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('grupo');
            $table->string('descripcion' , 100);

            $table->foreign('grupo')->references('id')->on('solicitudes.grupos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('solicitudes.tipo_solicitud');
    }
}
