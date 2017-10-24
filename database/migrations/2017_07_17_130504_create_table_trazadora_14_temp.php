<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrazadora14Temp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trazadoras.trz_14_temp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('periodo');
            $table->char('cuie', 6);
            $table->string('numero_documento', 12);
            $table->string('orden', 2)->nullable();
            $table->date('fecha_defuncion')->nullable();
            $table->date('fecha_auditoria_muerte')->nullable();
            $table->date('fecha_parto_o_interrupcion_embarazo')->nullable();
            $table->string('diagnostico', 4)->nullable();
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
        Schema::drop('trazadoras.trz_14_temp');
    }
}
