<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrazadora1Temp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trazadoras.trz_1_temp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('periodo');
            $table->char('cuie', 6);
            $table->string('numero_documento', 12);
            $table->date('fecha_control')->nullable();
            $table->smallInteger('edad_gestacional')->nullable();
            $table->date('fecha_ultima_menstruacion')->nullable();
            $table->date('fecha_probable_parto')->nullable();
            $table->decimal('peso')->nullable();
            $table->char('tension_arterial', 7)->nullable();
            $table->char('es_control', 1)->nullable();
            $table->bigInteger('id_registro_provincial')->nullable();
            $table->bigInteger('id_registro')->nullable();
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
        Schema::drop('trazadoras.trz_1_temp');
    }
}
