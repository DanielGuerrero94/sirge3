<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrazadora9Temp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trazadoras.trz_9_temp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('periodo');
            $table->string('numero_documento', 12);
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
        Schema::drop('trazadoras.trz_9_temp');
    }
}
