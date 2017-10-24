<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrazadora4Temp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trazadoras.trz_4_temp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('periodo');
            $table->string('numero_documento', 12);
            $table->string('orden', 2)->nullable();
            $table->char('departamento_residencia', 3)->nullable();
            $table->string('observaciones')->nullable();
            $table->jsonb('detalle')->nullable();
            $table->integer('lote');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('trazadoras.trz_4_temp');
    }
}
