<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdjuntos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes.adjuntos', function (Blueprint $table) {
            $table->increments('id_adjunto');            
            $table->text('nombre_original_solicitante')->nullable();
            $table->text('nombre_actual_solicitante')->nullable();
            $table->float('size_solicitante')->nullable();
            $table->text('nombre_original_respuesta')->nullable();
            $table->text('nombre_actual_respuesta')->nullable();
            $table->float('size_respuesta')->nullable();
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
        Schema::drop('solicitudes.adjuntos');
    }
}
