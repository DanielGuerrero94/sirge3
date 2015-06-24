<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoDocumento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sistema.tipo_documento', function (Blueprint $table) {
            $table->increments('id_tipo_documento');
            $table->char('tipo_documento' , 3)->unique();
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
        Schema::drop('sistema.tipo_documento');
    }
}
